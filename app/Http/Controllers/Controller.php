<?php

namespace App\Http\Controllers;

use App\Models\Bakery;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

abstract class Controller
{
    protected function currentBakery(): Bakery
    {
        $user = Auth::user();
        $bakery = $user->bakery()->first();

        if ($bakery) {
            return $bakery;
        }

        $slug = $this->makeBakerySlug($user->name ?: 'bakery-owner');

        return $user->bakery()->create([
            'shop_name' => ($user->name ?: 'Bakery Owner')."'s Bakery",
            'public_slug' => $slug,
            'qr_token' => $slug,
            'revenue_ledger' => 0,
        ]);
    }

    protected function makeBakerySlug(string $name): string
    {
        $base = Str::slug($name) ?: 'bakery-owner';

        do {
            $slug = $base.'-'.Str::lower(Str::random(6));
        } while (
            Bakery::query()
                ->where('public_slug', $slug)
                ->orWhere('qr_token', $slug)
                ->exists()
        );

        return $slug;
    }
}

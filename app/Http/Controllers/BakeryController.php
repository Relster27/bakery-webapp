<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BakeryController extends Controller
{
    public function edit(): View
    {
        return view('bakery.edit', [
            'bakery' => $this->currentBakery(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'shop_name'           => ['required', 'string', 'max:255'],
            'phone'               => ['nullable', 'string', 'max:50'],
            'email'               => ['nullable', 'email', 'max:255'],
            'address'             => ['nullable', 'string'],
            'bank_name'           => ['nullable', 'string', 'max:100'],
            'bank_account_number' => ['nullable', 'string', 'max:100'],
            'bank_account_name'   => ['nullable', 'string', 'max:255'],
        ]);

        $this->currentBakery()->update($validated);

        return redirect()
            ->route('bakery.edit')
            ->with('success', 'Bakery profile updated.');
    }
}

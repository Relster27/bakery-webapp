<?php

namespace App\Http\Controllers;

use App\Models\Bakery;
use Illuminate\Support\Facades\Auth;

abstract class Controller
{
    protected function currentBakery(): Bakery
    {
        return Auth::user()->bakery()->firstOrFail();
    }
}

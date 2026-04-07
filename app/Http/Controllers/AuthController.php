<?php

namespace App\Http\Controllers;

use App\Models\Bakery;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showLogin(): View
    {
        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (! Auth::attempt($credentials)) {
            return back()
                ->withErrors(['email' => 'Email or password is not correct.'])
                ->onlyInput('email');
        }

        $request->session()->regenerate();

        return redirect()->route('dashboard');
    }

    public function showRegister(): View
    {
        return view('auth.register');
    }

    public function register(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'owner_name' => ['required', 'string', 'max:255'],
            'shop_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $user = User::create([
            'name' => $validated['owner_name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        $publicSlug = $this->makePublicSlug($validated['shop_name']);

        Bakery::create([
            'user_id' => $user->id,
            'shop_name' => $validated['shop_name'],
            'public_slug' => $publicSlug,
            'revenue_ledger' => 0,
            'qr_token' => $publicSlug,
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('dashboard');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    protected function makePublicSlug(string $shopName): string
    {
        do {
            $token = \Illuminate\Support\Str::slug($shopName).'-'.\Illuminate\Support\Str::lower(\Illuminate\Support\Str::random(6));
        } while (Bakery::query()->where('public_slug', $token)->exists());

        return $token;
    }
}

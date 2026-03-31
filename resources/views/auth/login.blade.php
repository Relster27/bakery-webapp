@extends('layouts.app')

@section('content')
    <div class="auth-shell">
        <div class="card auth-card stack">
            <div class="stack-tight">
                <span class="eyebrow" style="color: var(--text);">Owner Access</span>
                <h1>Sign in to your bakery workspace</h1>
                <p class="muted">Track inventory, manage products, process counter sales, and handle customer pre-orders from one clean dashboard.</p>
            </div>

            <div class="surface-note">
                Use the owner account for internal management only. The customer-facing order page is a separate public link.
            </div>

            <form action="{{ route('login.store') }}" method="POST" class="stack">
                @csrf
                <div>
                    <label for="email">Email</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" required>
                </div>

                <div>
                    <label for="password">Password</label>
                    <input id="password" name="password" type="password" required>
                </div>

                <button class="button" type="submit">Login to Dashboard</button>
            </form>

            <p class="muted">No owner account yet? <a href="{{ route('register') }}">Create one here.</a></p>
        </div>
    </div>
@endsection

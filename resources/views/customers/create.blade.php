@extends('layouts.app')

@section('content')
    <section class="card stack">
        <div>
            <h1>Add Customer</h1>
            <p class="muted">Use this if you want to register a regular customer before they place an order.</p>
        </div>

        <form action="{{ route('customers.store') }}" method="POST" class="stack">
            @csrf

            <div class="form-grid">
                <div>
                    <label for="name">Name</label>
                    <input id="name" name="name" type="text" value="{{ old('name') }}" required>
                </div>

                <div>
                    <label for="email">Email</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}">
                </div>

                <div>
                    <label for="phone">Phone</label>
                    <input id="phone" name="phone" type="text" value="{{ old('phone') }}">
                </div>
            </div>

            <div class="actions">
                <button class="button-inline" type="submit">Save Customer</button>
                <a class="button-inline button-secondary" href="{{ route('customers.index') }}">Back</a>
            </div>
        </form>
    </section>
@endsection

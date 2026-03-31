@extends('layouts.app')

@section('content')
    <section class="card stack">
        <div>
            <h1>Edit Customer</h1>
            <p class="muted">Update the saved customer contact details here.</p>
        </div>

        <form action="{{ route('customers.update', $customer) }}" method="POST" class="stack">
            @csrf
            @method('PUT')

            <div class="form-grid">
                <div>
                    <label for="name">Name</label>
                    <input id="name" name="name" type="text" value="{{ old('name', $customer->name) }}" required>
                </div>

                <div>
                    <label for="email">Email</label>
                    <input id="email" name="email" type="email" value="{{ old('email', $customer->email) }}">
                </div>

                <div>
                    <label for="phone">Phone</label>
                    <input id="phone" name="phone" type="text" value="{{ old('phone', $customer->phone) }}">
                </div>
            </div>

            <div class="actions">
                <button class="button-inline" type="submit">Update Customer</button>
                <a class="button-inline button-secondary" href="{{ route('customers.index') }}">Back</a>
            </div>
        </form>
    </section>
@endsection

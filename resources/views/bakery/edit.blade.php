@extends('layouts.app')

@section('content')
    <section class="card stack">
        <div>
            <h1>Bakery Profile</h1>
            <p class="muted">This page stores the bakery identity used by the owner dashboard and public menu.</p>
        </div>

        <form action="{{ route('bakery.update') }}" method="POST" class="stack">
            @csrf
            @method('PUT')

            <div class="form-grid">
                <div>
                    <label for="shop_name">Bakery Name</label>
                    <input id="shop_name" name="shop_name" type="text" value="{{ old('shop_name', $bakery->shop_name) }}" required>
                </div>

                <div>
                    <label for="phone">Phone</label>
                    <input id="phone" name="phone" type="text" value="{{ old('phone', $bakery->phone) }}">
                </div>

                <div>
                    <label for="email">Public Email</label>
                    <input id="email" name="email" type="email" value="{{ old('email', $bakery->email) }}">
                </div>
            </div>

            <div>
                <label for="address">Address</label>
                <textarea id="address" name="address">{{ old('address', $bakery->address) }}</textarea>
            </div>

            <div>
                <label for="bank_details">Bank Details</label>
                <textarea id="bank_details" name="bank_details">{{ old('bank_details', $bakery->bank_details) }}</textarea>
            </div>

            <div class="card" style="background: #fff;">
                <strong>QR Target Link</strong>
                <p><a href="{{ route('menu.show', $bakery->qr_token) }}" target="_blank">{{ route('menu.show', $bakery->qr_token) }}</a></p>
            </div>

            <button class="button" type="submit">Save Bakery Profile</button>
        </form>
    </section>
@endsection

@extends('layouts.app')

@section('content')
    <section class="hero">
        <div class="hero-grid">
            <div>
                <span class="eyebrow">Live Bakery Menu</span>
                <h1>{{ $bakery->shop_name }}</h1>
                <p class="muted">Browse the current menu, check live stock, and place a pickup order without calling the shop.</p>
            </div>

            <div class="hero-aside">
                <span class="eyebrow">Visit</span>
                @if ($bakery->address)
                    <p><strong>Address:</strong> {{ $bakery->address }}</p>
                @endif
                @if ($bakery->phone)
                    <p><strong>Phone:</strong> {{ $bakery->phone }}</p>
                @endif
                @if ($bakery->email)
                    <p><strong>Email:</strong> {{ $bakery->email }}</p>
                @endif
            </div>
        </div>
    </section>

    <section class="grid grid-2">
        <div class="card">
            <h2>Live Menu</h2>
            <table>
                <thead>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Stock</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($products as $product)
                    <tr>
                        <td>
                            <strong>{{ $product->name }}</strong><br>
                            <span class="muted">{{ $product->category }}</span>
                        </td>
                        <td>Rp {{ number_format((float) $product->price, 0, ',', '.') }}</td>
                        <td>{{ $product->inventory?->quantity_on_hand ?? 0 }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="card stack">
            <div>
                <h2>Place a Pre-order</h2>
                <p class="muted">Enter customer details, choose pickup time, then fill only the quantities you want.</p>
            </div>

            <form action="{{ route('menu.order.store', $bakery->qr_token) }}" method="POST" class="stack">
                @csrf

                <div class="form-grid">
                    <div>
                        <label for="customer_name">Name</label>
                        <input id="customer_name" name="customer_name" type="text" value="{{ old('customer_name') }}" required>
                    </div>

                    <div>
                        <label for="customer_email">Email</label>
                        <input id="customer_email" name="customer_email" type="email" value="{{ old('customer_email') }}">
                    </div>

                    <div>
                        <label for="customer_phone">Phone</label>
                        <input id="customer_phone" name="customer_phone" type="text" value="{{ old('customer_phone') }}" required>
                    </div>
                </div>

                <div>
                    <label for="pickup_time">Pickup Time</label>
                    <input id="pickup_time" name="pickup_time" type="datetime-local" value="{{ old('pickup_time') }}" required>
                </div>

                <div>
                    <label for="notes">Notes</label>
                    <textarea id="notes" name="notes">{{ old('notes') }}</textarea>
                </div>

                <div class="card subcard">
                    <h3>Choose Products</h3>
                    <table>
                        <thead>
                        <tr>
                            <th>Product</th>
                            <th>Available</th>
                            <th>Quantity</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($products as $product)
                            <tr>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->inventory?->quantity_on_hand ?? 0 }}</td>
                                <td>
                                    <input
                                        name="quantities[{{ $product->id }}]"
                                        type="number"
                                        min="0"
                                        max="{{ $product->inventory?->quantity_on_hand ?? 0 }}"
                                        value="{{ old('quantities.'.$product->id, 0) }}"
                                    >
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                <button class="button" type="submit">Send Pre-order</button>
            </form>
        </div>
    </section>
@endsection

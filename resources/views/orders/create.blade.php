@extends('layouts.app')

@section('content')
    <section class="card stack">
        <div>
            <span class="eyebrow" style="color: var(--text);">New Sale</span>
            <h1>Create Order</h1>
            <p class="muted">Use this single form for both counter sales and pre-orders. Put quantities only on the products being ordered.</p>
        </div>

        <form action="{{ route('orders.store') }}" method="POST" class="stack">
            @csrf

            <div class="form-grid">
                <div>
                    <label for="order_type">Order Type</label>
                    <select id="order_type" name="order_type" required>
                        <option value="counter" @selected(old('order_type') === 'counter')>Counter Sale</option>
                        <option value="preorder" @selected(old('order_type', 'preorder') === 'preorder')>Pre-order</option>
                    </select>
                </div>

                <div>
                    <label for="customer_id">Existing Customer</label>
                    <select id="customer_id" name="customer_id">
                        <option value="">Choose later or leave empty</option>
                        @foreach ($customers as $customer)
                            <option value="{{ $customer->id }}" @selected((string) old('customer_id') === (string) $customer->id)>{{ $customer->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="pickup_time">Pickup Time</label>
                    <input id="pickup_time" name="pickup_time" type="datetime-local" value="{{ old('pickup_time') }}">
                </div>
            </div>

            <div class="form-grid">
                <div>
                    <label for="customer_name">New Customer Name</label>
                    <input id="customer_name" name="customer_name" type="text" value="{{ old('customer_name') }}">
                </div>

                <div>
                    <label for="customer_email">New Customer Email</label>
                    <input id="customer_email" name="customer_email" type="email" value="{{ old('customer_email') }}">
                </div>

                <div>
                    <label for="customer_phone">New Customer Phone</label>
                    <input id="customer_phone" name="customer_phone" type="text" value="{{ old('customer_phone') }}">
                </div>
            </div>

            <div>
                <label for="notes">Notes</label>
                <textarea id="notes" name="notes">{{ old('notes') }}</textarea>
            </div>

            <div class="card subcard">
                <h2>Select Products</h2>
                <table>
                    <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Order Quantity</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($products as $product)
                        <tr>
                            <td>{{ $product->name }}</td>
                            <td>Rp {{ number_format((float) $product->price, 0, ',', '.') }}</td>
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

            <div class="actions">
                <button class="button-inline" type="submit">Create Order</button>
                <a class="button-inline button-secondary" href="{{ route('orders.index') }}">Back</a>
            </div>
        </form>
    </section>
@endsection

@extends('layouts.app')

@section('content')
    <section class="hero">
        <div class="actions">
            <div>
                <h1>Orders</h1>
                <p class="muted">Orders include both quick counter sales and customer pre-orders.</p>
            </div>
            <a class="button-inline" href="{{ route('orders.create') }}">Create Order</a>
        </div>
    </section>

    <section class="card">
        @if ($orders->isEmpty())
            <p class="muted">No orders yet.</p>
        @else
            <table>
                <thead>
                <tr>
                    <th>Order</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th>Total</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach ($orders as $order)
                    <tr>
                        <td>
                            <strong>{{ $order->order_number }}</strong><br>
                            <span class="muted">{{ $order->customer?->name ?? 'Walk-in customer' }}</span>
                        </td>
                        <td>{{ strtoupper($order->order_type) }}</td>
                        <td><span class="badge">{{ strtoupper($order->order_status) }}</span></td>
                        <td>Rp {{ number_format((float) $order->total_amount, 0, ',', '.') }}</td>
                        <td><a href="{{ route('orders.show', $order) }}">Details</a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </section>
@endsection

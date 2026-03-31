@extends('layouts.app')

@section('content')
    <section class="hero">
        <div class="actions" style="justify-content: space-between;">
            <div>
                <span class="eyebrow">Menu Management</span>
                <h1>Products</h1>
                <p class="muted">Manage bakery menu items and selling prices here.</p>
            </div>
            <a class="button-inline" href="{{ route('products.create') }}">Add Product</a>
        </div>
    </section>

    <section class="card">
        @if ($products->isEmpty())
            <p class="muted">No products yet. Start by adding the first menu item.</p>
        @else
            <table>
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Status</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach ($products as $product)
                    <tr>
                        <td>
                            <strong>{{ $product->name }}</strong><br>
                            <span class="muted">{{ $product->description }}</span>
                        </td>
                        <td>{{ $product->category }}</td>
                        <td>Rp {{ number_format((float) $product->price, 0, ',', '.') }}</td>
                        <td>{{ $product->inventory?->quantity_on_hand ?? 0 }}</td>
                        <td>
                            <span class="badge">{{ $product->is_active ? 'ACTIVE' : 'HIDDEN' }}</span>
                        </td>
                        <td><a href="{{ route('products.edit', $product) }}">Edit</a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </section>
@endsection

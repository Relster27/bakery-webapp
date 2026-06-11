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
            <div class="product-list">
                @foreach ($products as $product)
                    <article class="product-row">
                        <div class="product-main" style="display: flex; gap: 1rem; align-items: center;">
                            @if ($product->image_path)
                                <img src="{{ \Illuminate\Support\Facades\Storage::url($product->image_path) }}" alt="{{ $product->name }}" style="width: 48px; height: 48px; object-fit: cover; border-radius: 10px; border: 1px solid rgba(176, 146, 121, 0.16); flex-shrink: 0;">
                            @endif
                            <div>
                                <strong>{{ $product->name }}</strong>
                                <p class="product-copy">{{ $product->description ?: 'No product description yet.' }}</p>
                            </div>
                        </div>

                        <div class="product-meta">
                            <span class="product-label">Category</span>
                            <span class="product-value">{{ $product->category }}</span>
                        </div>

                        <div class="product-meta">
                            <span class="product-label">Price</span>
                            <span class="product-value">Rp {{ number_format((float) $product->price, 0, ',', '.') }}</span>
                        </div>

                        <div class="product-meta">
                            <span class="product-label">Stock</span>
                            <span class="product-value">{{ $product->inventory?->quantity_on_hand ?? 0 }}</span>
                        </div>

                        <div class="product-actions">
                            <div class="stack-tight" style="justify-items: end;">
                                <span class="badge {{ $product->is_active ? '' : 'badge-muted' }}">{{ $product->is_active ? 'ACTIVE' : 'HIDDEN' }}</span>
                                <a href="{{ route('products.edit', $product) }}">Edit product</a>
                                <form
                                    action="{{ route('products.destroy', $product) }}"
                                    method="POST"
                                    onsubmit="return confirm('Delete {{ addslashes($product->name) }}? This action cannot be undone. If this product is already used in an order, deletion will be blocked.');"
                                >
                                    @csrf
                                    @method('DELETE')
                                    <button class="button-inline button-danger" type="submit">Delete product</button>
                                </form>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        @endif
    </section>
@endsection

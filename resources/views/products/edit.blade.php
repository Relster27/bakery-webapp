@extends('layouts.app')

@section('content')
    <section class="card stack">
        <div>
            <h1>Edit Product</h1>
            <p class="muted">Update the product details here. Stock count is managed on the Inventory page.</p>
        </div>

        <form action="{{ route('products.update', $product) }}" method="POST" class="stack">
            @csrf
            @method('PUT')

            <div class="form-grid">
                <div>
                    <label for="name">Product Name</label>
                    <input id="name" name="name" type="text" value="{{ old('name', $product->name) }}" required>
                </div>

                <div>
                    <label for="category">Category</label>
                    <input id="category" name="category" type="text" value="{{ old('category', $product->category) }}" required>
                </div>

                <div>
                    <label for="price">Price</label>
                    <input id="price" name="price" type="number" min="0" step="0.01" value="{{ old('price', $product->price) }}" required>
                </div>
            </div>

            <div>
                <label for="description">Description</label>
                <textarea id="description" name="description">{{ old('description', $product->description) }}</textarea>
            </div>

            <div>
                <label for="is_active">Status</label>
                <select id="is_active" name="is_active" required>
                    <option value="1" @selected(old('is_active', (int) $product->is_active) == 1)>Active</option>
                    <option value="0" @selected(old('is_active', (int) $product->is_active) == 0)>Hidden</option>
                </select>
            </div>

            <p class="muted">Current stock: {{ $product->inventory?->quantity_on_hand ?? 0 }}</p>

            <div class="actions">
                <button class="button-inline" type="submit">Update Product</button>
                <a class="button-inline button-secondary" href="{{ route('products.index') }}">Back</a>
            </div>
        </form>
    </section>
@endsection

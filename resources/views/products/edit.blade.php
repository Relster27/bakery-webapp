@extends('layouts.app')

@section('content')
    <section class="card stack">
        <div>
            <h1>Edit Product</h1>
            <p class="muted">Update the product details here. Stock count is managed on the Inventory page.</p>
        </div>

        <form action="{{ route('products.update', $product) }}" method="POST" enctype="multipart/form-data" class="stack">
            @csrf
            @method('PUT')

            <div class="form-grid">
                <div>
                    <label for="name">Product Name</label>
                    <input id="name" name="name" type="text" value="{{ old('name', $product->name) }}" required>
                </div>

                <div>
                    <label for="category">Category</label>
                    <select id="category" name="category" required>
                        <option value="Bread" @selected(old('category', $product->category) == 'Bread')>Bread</option>
                        <option value="Cake" @selected(old('category', $product->category) == 'Cake')>Cake</option>
                        <option value="Pastry" @selected(old('category', $product->category) == 'Pastry')>Pastry</option>
                    </select>
                </div>

                <div>
                    <label for="price">Price</label>
                    <input id="price" name="price" type="number" min="0" step="0.01" value="{{ old('price', $product->price) }}" required>
                </div>
            </div>
            
            <div class="form-grid">
                <div>
                    <label for="image">Replace Image (Optional)</label>
                    <input id="image" name="image" type="file" accept="image/png, image/jpeg, image/jpg, image/webp" style="background: var(--paper); padding: 0.6rem; width: 100%;">
                </div>
                @if($product->image_path)
                    <div>
                        <label>Current Image</label>
                        <img src="{{ \Illuminate\Support\Facades\Storage::url($product->image_path) }}" alt="{{ $product->name }}" style="width: 80px; height: 80px; object-fit: cover; border-radius: 12px; display: block; border: 1px solid rgba(176, 146, 121, 0.16);">
                    </div>
                @endif
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

        <div class="surface-note">
            Deleting a product is permanent. If this product is already used in order history, the system will block deletion to protect old order data.
        </div>

        <form
            action="{{ route('products.destroy', $product) }}"
            method="POST"
            onsubmit="return confirm('Delete {{ addslashes($product->name) }}? This action cannot be undone. If this product is already used in an order, deletion will be blocked.');"
        >
            @csrf
            @method('DELETE')
            <button class="button-inline button-danger" type="submit">Delete Product</button>
        </form>
    </section>
@endsection

<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(): View
    {
        $products = $this->currentBakery()->products()
            ->with('inventory')
            ->orderBy('category')
            ->orderBy('name')
            ->get();

        return view('products.index', [
            'products' => $products,
        ]);
    }

    public function create(): View
    {
        return view('products.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:100'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'quantity_on_hand' => ['required', 'integer', 'min:0'],
            'reorder_level' => ['required', 'integer', 'min:0'],
        ]);

        $bakery = $this->currentBakery();

        $product = $bakery->products()->create([
            'name' => $validated['name'],
            'category' => $validated['category'],
            'description' => $validated['description'] ?? null,
            'price' => $validated['price'],
            'is_active' => true,
        ]);

        $product->inventory()->create([
            'bakery_id' => $bakery->id,
            'quantity_on_hand' => $validated['quantity_on_hand'],
            'reorder_level' => $validated['reorder_level'],
        ]);

        return redirect()
            ->route('products.index')
            ->with('success', 'Product created.');
    }

    public function edit(Product $product): View
    {
        abort_unless($product->bakery_id === $this->currentBakery()->id, 404);

        return view('products.edit', [
            'product' => $product->load('inventory'),
        ]);
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        abort_unless($product->bakery_id === $this->currentBakery()->id, 404);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:100'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'is_active' => ['required', 'boolean'],
        ]);

        $product->update($validated);

        return redirect()
            ->route('products.index')
            ->with('success', 'Product updated.');
    }
}

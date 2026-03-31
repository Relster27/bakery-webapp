<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class InventoryController extends Controller
{
    public function index(): View
    {
        $inventories = $this->currentBakery()->inventories()
            ->with('product')
            ->orderBy('quantity_on_hand')
            ->get();

        return view('inventories.index', [
            'inventories' => $inventories,
        ]);
    }

    public function update(Request $request, Inventory $inventory): RedirectResponse
    {
        abort_unless($inventory->bakery_id === $this->currentBakery()->id, 404);

        $validated = $request->validate([
            'quantity_on_hand' => ['required', 'integer', 'min:0'],
            'reorder_level' => ['required', 'integer', 'min:0'],
        ]);

        $inventory->update($validated);

        return redirect()
            ->route('inventories.index')
            ->with('success', 'Inventory updated.');
    }
}

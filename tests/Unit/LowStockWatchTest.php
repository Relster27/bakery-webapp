<?php

namespace Tests\Unit;

use App\Models\Bakery;
use App\Models\Inventory;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LowStockWatchTest extends TestCase
{
    use RefreshDatabase;

    public function test_product_at_reorder_level_is_included_in_low_stock_watch(): void
    {
        $owner = User::factory()->create();

        $bakery = Bakery::create([
            'user_id' => $owner->id,
            'shop_name' => 'Low Stock Test Bakery',
            'public_slug' => 'low-stock-test-bakery-'.$owner->id,
            'qr_token' => 'low-stock-test-bakery-'.$owner->id,
            'revenue_ledger' => 0,
        ]);

        $lowStockProduct = Product::create([
            'bakery_id' => $bakery->id,
            'name' => 'Butter Croissant',
            'category' => 'Pastry',
            'price' => 18000,
            'is_active' => true,
        ]);

        $safeProduct = Product::create([
            'bakery_id' => $bakery->id,
            'name' => 'Milk Bun',
            'category' => 'Bread',
            'price' => 15000,
            'is_active' => true,
        ]);

        $lowStockInventory = Inventory::create([
            'bakery_id' => $bakery->id,
            'product_id' => $lowStockProduct->id,
            'quantity_on_hand' => 4,
            'reorder_level' => 5,
        ]);

        Inventory::create([
            'bakery_id' => $bakery->id,
            'product_id' => $safeProduct->id,
            'quantity_on_hand' => 6,
            'reorder_level' => 5,
        ]);
        // ========== //

        $lowStockItems = $bakery->inventories()
            ->with('product')
            ->atOrBelowReorderLevel()
            ->get();

        $this->assertTrue($lowStockInventory->fresh()->isAtOrBelowReorderLevel());

        $this->assertCount(1, $lowStockItems);
        $this->assertSame('Butter Croissant', $lowStockItems->first()->product->name);
    }
}

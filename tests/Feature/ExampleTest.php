<?php

namespace Tests\Feature;

use App\Models\Bakery;
use App\Models\Inventory;
use App\Models\Product;
use App\Models\User;
use App\Services\OrderPlacementService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Root should send guests to owner login.
     */
    public function test_guest_is_redirected_to_login_from_root(): void
    {
        $response = $this->get('/');

        $response->assertRedirect(route('login'));
    }

    public function test_preorder_creation_reduces_inventory(): void
    {
        $owner = User::factory()->create();

        $bakery = Bakery::create([
            'user_id' => $owner->id,
            'shop_name' => 'Test Bakery',
            'revenue_ledger' => 0,
            'qr_token' => 'test-bakery-menu',
        ]);

        $product = Product::create([
            'bakery_id' => $bakery->id,
            'name' => 'Test Bread',
            'category' => 'Bread',
            'price' => 15000,
            'is_active' => true,
        ]);

        Inventory::create([
            'bakery_id' => $bakery->id,
            'product_id' => $product->id,
            'quantity_on_hand' => 10,
            'reorder_level' => 2,
        ]);

        $order = app(OrderPlacementService::class)->place($bakery, [
            'order_type' => 'preorder',
            'customer_name' => 'Rani',
            'customer_phone' => '0813-0000-0000',
            'pickup_time' => now()->addHour()->toDateTimeString(),
            'quantities' => [
                $product->id => 2,
            ],
        ]);

        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'order_type' => 'preorder',
            'order_status' => 'pending',
        ]);

        $this->assertDatabaseHas('inventories', [
            'product_id' => $product->id,
            'quantity_on_hand' => 8,
        ]);
    }

    public function test_public_menu_page_loads(): void
    {
        $owner = User::factory()->create();

        $bakery = Bakery::create([
            'user_id' => $owner->id,
            'shop_name' => 'Test Bakery',
            'revenue_ledger' => 0,
            'qr_token' => 'test-bakery-page',
        ]);

        $response = $this->get(route('menu.show', $bakery->qr_token));

        $response
            ->assertOk()
            ->assertSee('Test Bakery');
    }
}

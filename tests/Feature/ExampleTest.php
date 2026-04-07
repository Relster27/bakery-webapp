<?php

namespace Tests\Feature;

use App\Models\Bakery;
use App\Models\DiscountRule;
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
            'public_slug' => 'test-bakery-menu',
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
            'public_slug' => 'test-bakery-page',
            'qr_token' => 'test-bakery-page',
        ]);

        $response = $this->get(route('menu.show', $bakery->public_slug));

        $response
            ->assertOk()
            ->assertSee('Test Bakery');
    }

    public function test_active_discount_rule_changes_order_total(): void
    {
        $owner = User::factory()->create();

        $bakery = Bakery::create([
            'user_id' => $owner->id,
            'shop_name' => 'Discount Bakery',
            'revenue_ledger' => 0,
            'public_slug' => 'discount-bakery-menu',
            'qr_token' => 'discount-bakery-menu',
        ]);

        $product = Product::create([
            'bakery_id' => $bakery->id,
            'name' => 'Late Bread',
            'category' => 'Bread',
            'price' => 20000,
            'is_active' => true,
        ]);

        Inventory::create([
            'bakery_id' => $bakery->id,
            'product_id' => $product->id,
            'quantity_on_hand' => 8,
            'reorder_level' => 2,
        ]);

        DiscountRule::create([
            'bakery_id' => $bakery->id,
            'name' => 'Evening Bread Discount',
            'scope' => 'category',
            'category' => 'Bread',
            'start_time' => '00:00:00',
            'end_time' => '23:59:59',
            'discount_percent' => 20,
            'is_active' => true,
        ]);

        $order = app(OrderPlacementService::class)->place($bakery, [
            'order_type' => 'counter',
            'quantities' => [
                $product->id => 2,
            ],
        ]);

        $this->assertEquals(32000.0, (float) $order->total_amount);
        $this->assertEquals(8000.0, (float) $order->discount_total);
        $this->assertEquals(960.0, (float) $order->platform_fee);
    }

    public function test_public_custom_cake_request_can_be_submitted(): void
    {
        $owner = User::factory()->create();

        $bakery = Bakery::create([
            'user_id' => $owner->id,
            'shop_name' => 'Cake Bakery',
            'revenue_ledger' => 0,
            'public_slug' => 'cake-bakery-menu',
            'qr_token' => 'cake-bakery-menu',
        ]);

        $response = $this->post(route('menu.custom-cake.store', $bakery->public_slug), [
            'customer_name' => 'Sinta',
            'customer_email' => 'sinta@example.com',
            'customer_phone' => '0812-0000-2222',
            'pickup_date' => now()->addDays(2)->toDateString(),
            'occasion' => 'Birthday',
            'servings' => 18,
            'size' => '8-inch',
            'sponge' => 'Chocolate',
            'filling' => 'Fresh Cream',
            'frosting' => 'Buttercream',
            'decoration' => 'Floral decoration',
            'inscription' => 'Happy Birthday Sinta',
            'notes' => 'Blue and white theme.',
        ]);

        $response->assertRedirect(route('menu.custom-cake.show', $bakery->public_slug));

        $this->assertDatabaseHas('custom_cake_requests', [
            'bakery_id' => $bakery->id,
            'customer_name' => 'Sinta',
            'size' => '8-inch',
        ]);
    }

    public function test_dashboard_auto_creates_bakery_for_authenticated_user_without_one(): void
    {
        $owner = User::factory()->create([
            'name' => 'Fallback Owner',
        ]);

        $response = $this->actingAs($owner)->get('/dashboard');

        $response
            ->assertOk()
            ->assertSee("Fallback Owner&#039;s Bakery", false);

        $this->assertDatabaseHas('bakeries', [
            'user_id' => $owner->id,
            'shop_name' => "Fallback Owner's Bakery",
        ]);
    }
}

<?php

namespace Database\Seeders;

use App\Models\Bakery;
use App\Models\Customer;
use App\Models\Inventory;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $owner = User::query()->updateOrCreate(
            ['email' => 'owner@bakery.test'],
            [
                'name' => 'Bakery Owner',
                'password' => Hash::make('password'),
            ]
        );

        $bakery = Bakery::query()->updateOrCreate(
            ['user_id' => $owner->id],
            [
                'shop_name' => 'Morning Crumbs Bakery',
                'phone' => '0812-3456-7890',
                'email' => 'hello@morningcrumbs.test',
                'address' => 'Jl. Roti Hangat No. 12',
                'bank_details' => 'Bank BCA - 1234567890 - Morning Crumbs Bakery',
                'revenue_ledger' => 0,
                'qr_token' => 'morning-crumbs-demo',
            ]
        );

        $products = [
            [
                'name' => 'Butter Croissant',
                'category' => 'Pastry',
                'description' => 'Layered pastry for morning customers.',
                'price' => 18000,
                'stock' => 25,
            ],
            [
                'name' => 'Chocolate Bun',
                'category' => 'Bread',
                'description' => 'Soft bun with chocolate filling.',
                'price' => 15000,
                'stock' => 20,
            ],
            [
                'name' => 'Strawberry Tart',
                'category' => 'Cake',
                'description' => 'Small tart for pre-order pickup.',
                'price' => 22000,
                'stock' => 12,
            ],
            [
                'name' => 'Sourdough Loaf',
                'category' => 'Bread',
                'description' => 'Large loaf for daily counter sales.',
                'price' => 35000,
                'stock' => 10,
            ],
        ];

        foreach ($products as $productData) {
            $product = Product::query()->updateOrCreate(
                [
                    'bakery_id' => $bakery->id,
                    'name' => $productData['name'],
                ],
                [
                    'category' => $productData['category'],
                    'description' => $productData['description'],
                    'price' => $productData['price'],
                    'is_active' => true,
                ]
            );

            Inventory::query()->updateOrCreate(
                [
                    'bakery_id' => $bakery->id,
                    'product_id' => $product->id,
                ],
                [
                    'quantity_on_hand' => $productData['stock'],
                    'reorder_level' => 5,
                ]
            );
        }

        $customer = Customer::query()->updateOrCreate(
            [
                'bakery_id' => $bakery->id,
                'phone' => '0813-1111-2222',
            ],
            [
                'name' => 'Rani',
                'email' => 'rani@example.com',
            ]
        );

        $completedOrder = Order::query()->updateOrCreate(
            ['order_number' => 'ORD-DEMO-001'],
            [
                'bakery_id' => $bakery->id,
                'customer_id' => null,
                'order_type' => 'counter',
                'order_status' => 'completed',
                'total_amount' => 33000,
                'platform_fee' => 990,
                'notes' => 'Walk-in customer order.',
                'ordered_at' => now()->subHours(3),
                'fulfilled_at' => now()->subHours(3),
            ]
        );

        $croissant = Product::query()
            ->where('bakery_id', $bakery->id)
            ->where('name', 'Butter Croissant')
            ->first();

        $bun = Product::query()
            ->where('bakery_id', $bakery->id)
            ->where('name', 'Chocolate Bun')
            ->first();

        if ($croissant && $bun) {
            OrderItem::query()->updateOrCreate(
                [
                    'order_id' => $completedOrder->id,
                    'product_id' => $croissant->id,
                ],
                [
                    'quantity' => 1,
                    'unit_price' => 18000,
                    'subtotal_item' => 18000,
                ]
            );

            OrderItem::query()->updateOrCreate(
                [
                    'order_id' => $completedOrder->id,
                    'product_id' => $bun->id,
                ],
                [
                    'quantity' => 1,
                    'unit_price' => 15000,
                    'subtotal_item' => 15000,
                ]
            );
        }

        $preorder = Order::query()->updateOrCreate(
            ['order_number' => 'ORD-DEMO-002'],
            [
                'bakery_id' => $bakery->id,
                'customer_id' => $customer->id,
                'order_type' => 'preorder',
                'order_status' => 'ready',
                'total_amount' => 22000,
                'platform_fee' => 660,
                'notes' => 'Customer will pick up this afternoon.',
                'pickup_time' => now()->addHours(3),
                'expires_at' => now()->addHours(5),
                'ordered_at' => now()->subHour(),
            ]
        );

        $tart = Product::query()
            ->where('bakery_id', $bakery->id)
            ->where('name', 'Strawberry Tart')
            ->first();

        if ($tart) {
            OrderItem::query()->updateOrCreate(
                [
                    'order_id' => $preorder->id,
                    'product_id' => $tart->id,
                ],
                [
                    'quantity' => 1,
                    'unit_price' => 22000,
                    'subtotal_item' => 22000,
                ]
            );
        }

        $bakery->update([
            'revenue_ledger' => 33000,
        ]);
    }
}

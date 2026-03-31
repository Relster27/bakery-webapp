<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bakery_id')->constrained()->cascadeOnDelete();
            $table->foreignId('customer_id')->nullable()->constrained()->nullOnDelete();
            $table->string('order_number')->unique();
            $table->string('order_type');
            $table->string('order_status')->default('pending');
            $table->decimal('total_amount', 10, 2)->default(0);
            $table->decimal('platform_fee', 10, 2)->default(0);
            $table->text('notes')->nullable();
            $table->dateTime('pickup_time')->nullable();
            $table->dateTime('expires_at')->nullable();
            $table->dateTime('fulfilled_at')->nullable();
            $table->dateTime('stock_restored_at')->nullable();
            $table->dateTime('ordered_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};

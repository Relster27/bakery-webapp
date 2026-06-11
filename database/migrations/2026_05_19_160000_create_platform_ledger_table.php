<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('platform_ledger', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->foreignId('bakery_id')->constrained()->onDelete('cascade');
            $table->decimal('gross_amount', 12, 2);      // 100% — total customer paid
            $table->decimal('platform_cut', 12, 2);      //   3% — platform earnings
            $table->decimal('bakery_settlement', 12, 2); //  97% — bakery net revenue
            $table->string('source')->default('payment'); // 'payment' | 'counter' | 'completed'
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('platform_ledger');
    }
};

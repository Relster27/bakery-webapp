<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('bakeries')) {
            Schema::create('bakeries', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();
                $table->string('shop_name');
                $table->string('phone')->nullable();
                $table->string('email')->nullable();
                $table->text('address')->nullable();
                $table->text('bank_details')->nullable();
                $table->decimal('revenue_ledger', 12, 2)->default(0);
                $table->string('qr_token')->unique();
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('custom_cake_requests')) {
            Schema::create('custom_cake_requests', function (Blueprint $table) {
                $table->id();
                $table->foreignId('bakery_id')->constrained()->cascadeOnDelete();
                $table->string('customer_name');
                $table->string('customer_email')->nullable();
                $table->string('customer_phone');
                $table->date('pickup_date');
                $table->unsignedInteger('servings')->default(12);
                $table->string('size');
                $table->string('sponge');
                $table->string('filling');
                $table->string('frosting');
                $table->string('decoration');
                $table->string('occasion')->nullable();
                $table->string('inscription')->nullable();
                $table->text('notes')->nullable();
                $table->string('status')->default('requested');
                $table->timestamps();
            });

            return;
        }

        if (! $this->foreignKeyExists('custom_cake_requests', 'custom_cake_requests_bakery_id_foreign')) {
            Schema::table('custom_cake_requests', function (Blueprint $table) {
                $table->foreign('bakery_id')
                    ->references('id')
                    ->on('bakeries')
                    ->cascadeOnDelete();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('custom_cake_requests');
    }

    protected function foreignKeyExists(string $table, string $constraint): bool
    {
        if (DB::getDriverName() === 'sqlite') {
            return false;
        }

        $result = DB::selectOne(
            'select count(*) as aggregate from information_schema.table_constraints where table_schema = database() and table_name = ? and constraint_name = ? and constraint_type = ?',
            [$table, $constraint, 'FOREIGN KEY']
        );

        return (int) ($result->aggregate ?? 0) > 0;
    }
};

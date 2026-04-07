<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('bakeries', 'public_slug')) {
            Schema::table('bakeries', function (Blueprint $table) {
                $table->string('public_slug')->nullable()->after('shop_name');
            });
        }

        DB::table('bakeries')->orderBy('id')->get()->each(function ($bakery) {
            DB::table('bakeries')
                ->where('id', $bakery->id)
                ->update([
                    'public_slug' => $bakery->public_slug ?: ($bakery->qr_token ?: 'bakery-'.$bakery->id),
                ]);
        });

        if (! $this->indexExists('bakeries', 'bakeries_public_slug_unique')) {
            Schema::table('bakeries', function (Blueprint $table) {
                $table->unique('public_slug');
            });
        }
    }

    public function down(): void
    {
        if ($this->indexExists('bakeries', 'bakeries_public_slug_unique')) {
            Schema::table('bakeries', function (Blueprint $table) {
                $table->dropUnique('bakeries_public_slug_unique');
            });
        }

        if (Schema::hasColumn('bakeries', 'public_slug')) {
            Schema::table('bakeries', function (Blueprint $table) {
                $table->dropColumn('public_slug');
            });
        }
    }

    protected function indexExists(string $table, string $index): bool
    {
        if (DB::getDriverName() === 'sqlite') {
            return false;
        }

        $result = DB::selectOne(
            'select count(*) as aggregate from information_schema.statistics where table_schema = database() and table_name = ? and index_name = ?',
            [$table, $index]
        );

        return (int) ($result->aggregate ?? 0) > 0;
    }
};

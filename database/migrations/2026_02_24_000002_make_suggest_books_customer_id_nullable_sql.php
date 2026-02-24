<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Makes customer_id nullable so guest suggestions work (no doctrine/dbal needed).
     */
    public function up(): void
    {
        $driver = DB::getDriverName();
        if ($driver === 'mysql') {
            Schema::table('suggest_books', function (Blueprint $table) {
                $table->dropForeign(['customer_id']);
            });
            DB::statement('ALTER TABLE suggest_books MODIFY customer_id BIGINT UNSIGNED NULL');
            Schema::table('suggest_books', function (Blueprint $table) {
                $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $driver = DB::getDriverName();
        if ($driver === 'mysql') {
            Schema::table('suggest_books', function (Blueprint $table) {
                $table->dropForeign(['customer_id']);
            });
            DB::statement('ALTER TABLE suggest_books MODIFY customer_id BIGINT UNSIGNED NOT NULL');
            Schema::table('suggest_books', function (Blueprint $table) {
                $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            });
        }
    }
};

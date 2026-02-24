<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Allows guest suggestions for testing (customer_id nullable).
     */
    public function up(): void
    {
        Schema::table('suggest_books', function (Blueprint $table) {
            $table->dropForeign(['customer_id']);
        });
        DB::statement('ALTER TABLE suggest_books MODIFY customer_id BIGINT UNSIGNED NULL');
        Schema::table('suggest_books', function (Blueprint $table) {
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('suggest_books', function (Blueprint $table) {
            $table->dropForeign(['customer_id']);
        });
        DB::statement('ALTER TABLE suggest_books MODIFY customer_id BIGINT UNSIGNED NOT NULL');
        Schema::table('suggest_books', function (Blueprint $table) {
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
        });
    }
};

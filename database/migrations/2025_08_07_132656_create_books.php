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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->char('ISBN', 13)->unique();
            $table->string('title', 70)->index();
            $table->decimal('price', 4, 2)->default(0);
            $table->decimal('mortgage', 6, 2)->comment('restored when returned');
            $table->integer('pages')->nullable();
            $table->integer('borrow_duration')->nullable(); // مدة الاستعارة بالأيام
            $table->integer('total_copies')->default(0);
            $table->integer('stock')->default(0);

            $table->date('authorship_date')->nullable();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};

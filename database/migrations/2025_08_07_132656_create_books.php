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
            $table->char('ISBN' , 13);
            $table->string('title' , 70)->index() ;
            $table->decimal('price', 4, 2)->default(0);
            $table->decimal('mortgage' , 6,2 )->comment('restored when returned');
            $table->date('authorship_date')->nullable();
            // $table->unsignedBigInteger('category_id');
            $table->foreignId('category_id');
            $table->foreign('category_id')->references('id')->on('categories');
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

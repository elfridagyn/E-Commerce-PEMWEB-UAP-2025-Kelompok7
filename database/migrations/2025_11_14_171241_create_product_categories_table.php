<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use function Laravel\Prompts\text;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('product_categories', function (Blueprint $table) {
    $table->id();

    // kategori milik toko tertentu
    $table->foreignId('store_id')
          ->constrained('stores')
          ->onDelete('cascade');

    // optional
    $table->string('image')->nullable();

    $table->string('name');
    $table->string('slug')->unique();

    $table->string('tagline')->nullable();
    $table->text('description')->nullable();

    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_categories');
    }
};

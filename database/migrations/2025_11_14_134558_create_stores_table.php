<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
 // File: database/migrations/xxxx_xx_xx_xxxxxx_create_stores_table.php

public function up(): void
{
    Schema::create('stores', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');

        $table->string('name', 100);
        $table->string('city', 50);
        $table->string('phone');
        $table->text('address');
        $table->string('postal_code', 10);

        // TAMBAHAN UNTUK FITUR SELLER
        $table->string('logo')->nullable();  // untuk upload logo toko
        $table->text('about');               // deskripsi toko
        $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
        $table->string('bank_name')->nullable();
        $table->string('bank_account_name')->nullable();
        $table->string('bank_account_number')->nullable();
        $table->boolean('is_verified')->default(false);

        $table->timestamps();
    });
}
};
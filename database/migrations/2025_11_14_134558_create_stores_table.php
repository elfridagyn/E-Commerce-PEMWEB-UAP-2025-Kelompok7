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
        
        // TAMBAHKAN KOLOM-KOLOM INI:
        $table->string('name', 100);    // Untuk menampung 'Toko Seller 1' (Error 2)
        $table->string('city', 50);     // Untuk menampung 'Malang' (Error 1)
        
        // Asumsi kolom lain yang Anda gunakan di seeder juga perlu ditambahkan:
        $table->string('phone');
        $table->text('address');
        $table->string('postal_code', 10);
        $table->boolean('is_verified')->default(false);
        
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stores');
    }
};

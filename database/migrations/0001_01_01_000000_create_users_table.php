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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();

            // 💡 PERBAIKAN UTAMA: Menggunakan string dengan batasan yang jelas, 
            // dan menambahkan role 'member' dan 'seller' yang Anda gunakan di seeder.
            $table->string('role', 20)->default('member'); // Contoh: Gunakan 'member' sebagai default
            
            // 💡 TAMBAHAN: Umumnya user memiliki alamat
            $table->text('address')->nullable(); 

            $table->string('profile_picture')->nullable();
            $table->string('phone_number')->nullable();
            
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        // Bagian password_reset_tokens dan sessions tidak diubah karena sudah standar
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
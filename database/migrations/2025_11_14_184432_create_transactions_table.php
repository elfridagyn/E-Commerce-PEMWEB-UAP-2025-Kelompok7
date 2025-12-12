<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            
            // Menggunakan buyer_id sebagai pengganti user_id
            $table->foreignId('buyer_id')->constrained('users')->cascadeOnDelete(); 
            $table->foreignId('store_id')->constrained('stores')->cascadeOnDelete();
            
            $table->text('address');
            $table->string('phone', 15);
            
            // Foreign Key Wajib
            $table->foreignId('shipping_type_id')->constrained('shipping_types')->cascadeOnDelete(); 
            $table->string('shipping_type');
            $table->decimal('shipping_cost', 10, 2);
            $table->string('tracking_number')->nullable();
            
            $table->decimal('subtotal', 10, 2);
            $table->decimal('tax', 10, 2);
            $table->decimal('grand_total', 10, 2);

            $table->enum('payment_method', ['wallet', 'va']);
            $table->enum('payment_status', ['unpaid', 'paid'])->default('unpaid');
            $table->enum('status', ['pending', 'processing', 'shipped', 'delivered', 'completed', 'canceled'])->default('pending');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
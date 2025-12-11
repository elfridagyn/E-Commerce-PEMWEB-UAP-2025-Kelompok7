<?php
// File: database/migrations/2025_12_09_175230_add_bank_fields_to_stores_table.php

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
        Schema::table('stores', function (Blueprint $table) {
            // Cek apakah kolom sudah ada sebelum menambahkannya
            if (!Schema::hasColumn('stores', 'bank_name')) {
                $table->string('bank_name')->nullable();
            }
            // Lakukan pengecekan yang sama untuk kolom-kolom bank lainnya (jika ada)
            // if (!Schema::hasColumn('stores', 'bank_account_number')) {
            //     $table->string('bank_account_number')->nullable();
            // }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // ... (Pastikan metode down() juga menghapus kolom jika ada)
    }
};
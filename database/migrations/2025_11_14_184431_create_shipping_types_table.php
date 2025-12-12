<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('shipping_types', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('estimate'); // contoh: "2-4 hari"
        $table->integer('cost'); // dalam rupiah
        $table->timestamps();
    });
}

public function down()
{
    Schema::dropIfExists('shipping_types');
}
};

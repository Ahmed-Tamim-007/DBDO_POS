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
        Schema::create('p_o_s_sales', function (Blueprint $table) {
            $table->id();
            $table->string('sale_id');
            $table->unsignedBigInteger('product_id');
            $table->string('batch_no');
            $table->decimal('price', 10, 2);
            $table->integer('quantity');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('p_o_s_sales');
    }
};

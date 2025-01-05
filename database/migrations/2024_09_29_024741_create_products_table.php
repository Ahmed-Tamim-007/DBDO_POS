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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->integer('barcode');
            $table->string('title');
            $table->string('category');
            $table->string('sub_category')->nullable();
            $table->string('brand');
            $table->string('unit');
            $table->decimal('b_price', 10, 2);
            $table->decimal('s_price', 10, 2);
            $table->string('vatable');
            $table->integer('min_s');
            $table->integer('max_s');
            $table->string('supplier')->nullable();
            $table->string('image');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};

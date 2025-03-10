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
        Schema::create('hold_sales', function (Blueprint $table) {
            $table->id();
            $table->string('invoiceNo');
            $table->integer('product_id');
            $table->string('product_name');
            $table->integer('batch_no');
            $table->decimal('so_qty', 10, 2);
            $table->decimal('price', 10, 2);
            $table->decimal('total', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hold_sales');
    }
};

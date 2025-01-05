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
        Schema::create('p_o_s_orders', function (Blueprint $table) {
            $table->id();
            $table->string('sale_id');
            $table->string('customer_name');
            $table->integer('total_amount');
            $table->integer('paid_amount');
            $table->string('payment_note');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('p_o_s_orders');
    }
};

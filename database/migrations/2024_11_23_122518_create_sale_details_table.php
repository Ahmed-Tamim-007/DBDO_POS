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
        Schema::create('sale_details', function (Blueprint $table) {
            $table->id();
            $table->string('user');
            $table->string('customer')->nullable();
            $table->decimal('cash_total', 10, 2);
            $table->decimal('cash_dis', 10, 2)->nullable();
            $table->decimal('cash_round', 10, 2)->nullable();
            $table->decimal('cash_due', 10, 2)->nullable();
            $table->decimal('cash_amt', 10, 2);
            $table->decimal('cash_paid', 10, 2);
            $table->decimal('cash_change', 10, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sale_details');
    }
};

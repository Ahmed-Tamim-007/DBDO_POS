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
        Schema::create('office_transactions', function (Blueprint $table) {
            $table->id();
            $table->integer('transactionNO')->nullable();
            $table->string('type');
            $table->string('exp_type');
            $table->decimal('amt_paid', 10, 2);
            $table->string('pay_date');
            $table->string('account');
            $table->string('description')->nullable();
            $table->string('doc_name')->nullable();
            $table->string('doc_description')->nullable();
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('office_transactions');
    }
};

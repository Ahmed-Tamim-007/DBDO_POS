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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('member_code');
            $table->string('type');
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('phone');
            $table->string('gender')->nullable();
            $table->date('dob')->nullable();
            $table->string('merital_st')->nullable();
            $table->date('anv_date')->nullable();
            $table->string('adrs_type')->nullable();
            $table->string('address')->nullable();
            $table->string('image')->nullable();
            $table->decimal('due_limit', 10, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};

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
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->string('acc_name')->nullable();
            $table->string('acc_no')->nullable();
            $table->string('acc_uses')->nullable();
            $table->string('acc_branch')->nullable();
            $table->string('mob_acc_type')->nullable();
            $table->decimal('trans_chrg', 10, 2)->nullable();
            $table->string('address')->nullable();
            $table->string('description')->nullable();
            $table->decimal('ini_balance', 10, 2)->nullable();
            $table->decimal('crnt_balance', 10, 2)->nullable();
            $table->string('account_type')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accounts');
    }
};

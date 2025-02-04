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
        Schema::create('employee_accesses', function (Blueprint $table) {
            $table->id();
            $table->string('users')->default('no');
            $table->string('customer')->default('no');
            $table->string('customer_type')->default('no');
            $table->string('classifications')->default('no');
            $table->string('products')->default('no');
            $table->string('suppliers')->default('no');
            $table->string('stockin')->default('no');
            $table->string('stockout')->default('no');
            $table->string('sales')->default('no');
            $table->string('sale_returns')->default('no');
            $table->string('accounts')->default('no');
            $table->string('banks_cards')->default('no');
            $table->string('expense_cat')->default('no');
            $table->string('transactions')->default('no');
            $table->string('fund_transfer')->default('no');
            $table->string('profit_loss')->default('no');
            $table->string('daily_summ')->default('no');
            $table->string('sale_invoice')->default('no');
            $table->string('product_sale_summ')->default('no');
            $table->string('sale_return_report')->default('no');
            $table->string('stock_report')->default('no');
            $table->string('stock_in_summ')->default('no');
            $table->string('stock_out_report')->default('no');
            $table->string('emp_trans_report')->default('no');
            $table->string('office_trans_report')->default('no');
            $table->string('supplier_trans_report')->default('no');
            $table->string('fund_transfer_report')->default('no');
            $table->string('customer_ladger_report')->default('no');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_accesses');
    }
};

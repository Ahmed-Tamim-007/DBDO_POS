<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeAccess extends Model
{
    use HasFactory;
    protected $fillable = [
        'users',
        'customer',
        'customer_type',
        'classifications',
        'products',
        'suppliers',
        'stockin',
        'stockout',
        'sales',
        'sale_returns',
        'accounts',
        'banks_cards',
        'expense_cat',
        'transactions',
        'fund_transfer',
        'profit_loss',
        'daily_summ',
        'sale_invoice',
        'product_sale_summ',
        'sale_return_report',
        'stock_report',
        'stock_in_summ',
        'stock_out_report',
        'emp_trans_report',
        'office_trans_report',
        'supplier_trans_report',
        'fund_transfer_report',
        'customer_ladger_report',
    ];
}

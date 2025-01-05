<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleReturn extends Model
{
    use HasFactory;
    protected $fillable = [
        'sales_ID',
        'product_id',
        'product_name',
        'batch_no',
        'so_qty',
        'returned',
        'price',
        'total',
    ];
}

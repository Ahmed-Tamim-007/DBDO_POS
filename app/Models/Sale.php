<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'sales_ID',
        'product_id',
        'batch_no',
        'so_qty',
        'price',
        'total'
    ];
}

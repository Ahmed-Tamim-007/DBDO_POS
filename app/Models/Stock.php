<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;
    protected $fillable = [
        'batch_no',
        'product_id',
        'product_name',
        'supplier',
        'rack_id',
        'quantity',
        'expiration_date',
        'alert_date',
        'purchase_price',
        'sale_price'
    ];
}

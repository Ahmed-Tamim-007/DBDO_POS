<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HoldSale extends Model
{
    use HasFactory;
    protected $fillable = [
        'invoiceNo',
        'product_id',
        'product_name',
        'batch_no',
        'so_qty',
        'price',
        'total'
    ];
}

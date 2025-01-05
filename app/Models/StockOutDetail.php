<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockOutDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'user',
        'stock_date',
        'image_path',
        'stock_invoice',
        'stock_note'
    ];
}

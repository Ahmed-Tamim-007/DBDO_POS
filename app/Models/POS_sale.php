<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class POS_sale extends Model
{
    use HasFactory;
    protected $fillable = [
        'sale_id',
        'product_id',
        'batch_no',
        'price',
        'quantity'
    ];

    public function product() {
        return $this->belongsTo('App\Models\Product');
    }

    public function inventory() {
        return $this->belongsTo('App\Models\Inventory', 'batch_no', 'batch_no');
    }
}

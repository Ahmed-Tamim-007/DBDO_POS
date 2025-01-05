<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'quantity',
        'selling_price',
        'batch_no',
        'name',
        'rec_address',
        'phone'
    ];

    public function user() {
        return $this->belongsTo('App\Models\User');
    }

    public function product() {
        return $this->belongsTo('App\Models\Product');
    }

    public function inventory() {
        return $this->belongsTo('App\Models\Inventory', 'batch_no', 'batch_no');
    }
}

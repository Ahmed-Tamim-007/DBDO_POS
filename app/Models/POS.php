<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class POS extends Model
{
    use HasFactory;

    public function product()
    {
        return $this->belongsTo('App\Models\Product', 'product_id');
    }

    // Get the inventory details for the product in the cart
    public function inventory()
    {
        return $this->hasMany('App\Models\Inventory', 'product_id', 'product_id')
                    ->where('quantity', '>', 0)
                    ->orderBy('batch_no');
    }
}

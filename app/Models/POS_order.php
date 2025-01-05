<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class POS_order extends Model
{
    use HasFactory;
    protected $fillable = [
        'sale_id',
        'customer_name',
        'total_amount',
        'paid_amount',
        'payment_note'
    ];

    public function product() {
        return $this->belongsTo('App\Models\Product');
    }

    public function inventory() {
        return $this->belongsTo('App\Models\Inventory', 'batch_no', 'batch_no');
    }
}

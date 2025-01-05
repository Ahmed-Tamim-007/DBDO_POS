<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'user',
        'customerID',
        'cash_total',
        'cash_dis',
        'cash_round',
        'cash_due',
        'cash_amt',
        'cash_paid',
        'cash_change'
    ];
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customerID', 'id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerPoint extends Model
{
    use HasFactory;
    protected $fillable = [
        'earn_rate',
        'redeem_rate',
    ];
}

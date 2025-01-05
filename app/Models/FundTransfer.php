<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FundTransfer extends Model
{
    use HasFactory;
    protected $fillable = [
        'accountFrom',
        'accountTo',
        'amount',
        'description',
        'user',
    ];
}

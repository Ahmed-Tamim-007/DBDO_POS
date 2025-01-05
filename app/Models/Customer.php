<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $fillable = [
        'member_code',
        'type',
        'name',
        'email',
        'phone',
        'gender',
        'dob',
        'merital_st',
        'anv_date',
        'adrs_type',
        'address',
        'image',
        'due_limit',
    ];
}

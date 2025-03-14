<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerType extends Model
{
    use HasFactory;
    protected $fillable = [
        'type_name',
        'discount',
        'target_sale',
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfficeTransaction extends Model
{
    use HasFactory;
    protected $fillable = [
        'transactionNO',
        'type',
        'exp_type',
        'amt_paid',
        'pay_date',
        'account',
        'description',
        'doc_name',
        'doc_description',
        'image',
    ];
}

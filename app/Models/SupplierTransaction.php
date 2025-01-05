<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierTransaction extends Model
{
    use HasFactory;
    protected $fillable = [
        'transactionNO',
        'supplierID',
        'amt_paid',
        'pay_date',
        'account',
        'description',
        'doc_name',
        'doc_description',
        'image',
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeTransaction extends Model
{
    use HasFactory;
    protected $fillable = [
        'transactionNO',
        'employee',
        'trans_type',
        'emp_trans_type',
        'amt_paid',
        'pay_date',
        'account',
        'description',
        'doc_name',
        'doc_description',
        'image',
    ];
}

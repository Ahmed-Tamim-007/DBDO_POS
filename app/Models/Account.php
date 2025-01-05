<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;
    protected $fillable = [
        'acc_name',
        'acc_no',
        'acc_uses',
        'acc_branch',
        'mob_acc_type',
        'trans_chrg',
        'address',
        'description',
        'ini_balance',
        'crnt_balance',
        'account_type',
    ];
}

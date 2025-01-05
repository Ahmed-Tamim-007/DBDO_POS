<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PosUser extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'email',
        'phone',
        'job_title',
        'dob',
        'jod',
        'salary',
        'nid',
        'blood_group',
        'address',
        'image',
        'type',
    ];
}

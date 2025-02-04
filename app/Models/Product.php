<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Product extends Model
{
    use HasFactory;
    use Sluggable;

    protected $fillable = [
        'barcode',
        'title',
        'category',
        'sub_category',
        'brand',
        'unit',
        'b_price',
        's_price',
        'vatable',
        'min_s',
        'max_s',
        'supplier',
        'image',
    ];

    public function Sluggable():array {
        return [
            'slug' => [
                'source'=>'title'
            ]
        ];
    }

    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }
}

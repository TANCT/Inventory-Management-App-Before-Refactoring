<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends AbstractProduct
{
    use HasFactory;

    protected $table = 'products';
    protected $fillable = [
        'name',
        'detail',
        'quantity',
        'price',
        'discount',
        'totalPrice',
        'isClearance',
        'isDisposed'
    ];
}
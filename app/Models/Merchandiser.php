<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Merchandiser extends Model
{
    use HasFactory;

    protected $table = 'merchandisers';
    protected $fillable = [
        'name',
        'phone',
        'address',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class, 'merchandiser_id');
    }
}

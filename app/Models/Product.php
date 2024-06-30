<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'product_category_id',
        'image',
        'product_sub_category_id',
        'quantity',
        'price',
        'unit',
        'description',
    ];

    protected $appends = ['imagepath'];

    public function getImagePathAttribute()
    {
        return url('storage/'.$this->image);
    }
}

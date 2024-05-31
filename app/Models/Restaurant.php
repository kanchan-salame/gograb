<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'image',
        'latitude',
        'longitude',
        'min_order_price',
        'delivery_fee',
        'delivery_max_time',
        'delivery_min_time',
    ];

    protected $appends = ['imagepath'];

    public function getImagePathAttribute()
    {
        return url('storage/'.$this->image);
    }
}

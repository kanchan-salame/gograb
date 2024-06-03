<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RestaurantMenu extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'restaurant_id',
        'image',
        'active',
        'has_menu_item',
        'index',
    ];

    protected $appends = ['imagepath'];

    public function getImagePathAttribute()
    {
        return url('storage/'.$this->image);
    }
}

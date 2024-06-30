<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\RestaurantMenu;

class RestaurantMenuItem extends Model
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
        'price',
        'restaurant_menu_id',
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

    public function cart()
    {
        return $this->hasMany('Cart');
    }

    public function restaurantMenu()
    {
        return $this->belongsTo('App\Models\RestaurantMenu');
    }
}

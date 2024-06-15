<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\RestaurantMenuItem;
use App\Models\RestaurantMenu;
use App\Models\PackageSize;

class Cart extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'restaurant_menu_item_id',
        'package_size_id',
        'restaurant_menu_id',
        'restaurant_id',
        'quantity',
    ];

    public function restaurantMenuItem()
    {
        return $this->belongsTo('App\Models\RestaurantMenuItem');
    }

    public function restaurantMenu()
    {
        return $this->belongsTo('App\Models\RestaurantMenu');
    }

    public function packageSize()
    {
        return $this->belongsTo('App\Models\PackageSize');
    }


}

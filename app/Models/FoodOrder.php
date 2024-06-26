<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FoodOrder extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'driver_id',
        'restaurant_id',
        'restaurant_menu_id',
        'restaurant_menu_item_id',
        'status',
        'status_reason',
        'quantity',
        'price',
        'delivery_charge',
        'delivery_type',
        'payment_type',
        'payment_status',
        'tax',
        'instructions',
        'discount',
        'sub_total',
        'total',
    ];

    public function restaurantMenuItem()
    {
        return $this->belongsTo('App\Models\RestaurantMenuItem');
    }

    public function restaurantMenu()
    {
        return $this->belongsTo('App\Models\RestaurantMenu');
    }

    public function restaurant()
    {
        return $this->belongsTo('App\Models\Restaurant');
    }


}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
        'user_id',
        'email',
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

    /**
     * Get the categories for the restaurant.
     */
    public function restaurantCategories(): HasMany
    {
        return $this->hasMany(RestaurantCategories::class);
    }

    /**
     * Get the categories for the restaurant.
     */
    public function restaurantTimings(): HasMany
    {
        return $this->hasMany(RestaurantTiming::class);
    }

     /**
     * Get the phone associated with the restaurant.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'url',
        'image',
    ];

    protected $appends = ['path'];

    public function getPathAttribute()
    {
        return url('storage/app/public/'.$this->image);
    }
}

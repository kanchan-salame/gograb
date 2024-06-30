<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
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
        'icon',
    ];

    protected $appends = ['imagepath', 'iconpath'];

    public function getImagePathAttribute()
    {
        return url('storage/'.$this->image);
    }

    public function getIconPathAttribute()
    {
        return url('storage/'.$this->icon);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Location extends Model
{
    protected $fillable = ['parent_id', 'name', 'slug', 'description', 'postal_code'];

    use HasFactory;

    public function properties()
    {
        return $this->belongsToMany(Property::class);
    }

    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }
}

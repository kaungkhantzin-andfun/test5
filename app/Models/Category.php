<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    protected $fillable = ['parent_id', 'name', 'slug', 'of'];
    use HasFactory;

    public function blogs()
    {
        return $this->morphedByMany(Blog::class, 'categorizable');
    }

    public function properties()
    {
        // return $this->morphedByMany(Property::class, 'categorizable');
        return $this->hasMany(Property::class, 'type_id');
    }

    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    protected $fillable = ['name'];

    use HasFactory;

    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }
}

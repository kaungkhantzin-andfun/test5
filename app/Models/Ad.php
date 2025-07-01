<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ad extends Model
{
    protected $fillable = ['name', 'placement', 'link', 'expiry'];
    protected $casts = ['expiry' => 'date:Y-m-d'];

    use HasFactory;

    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }
}

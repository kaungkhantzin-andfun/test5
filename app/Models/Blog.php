<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'title', 'slug', 'body', 'stat'];

    public function getShortDetailAttribute()
    {
        if (!empty($this->body)) {
            return Str::limit(nl2br(strip_tags($this->body)), 250);
        }
    }

    public function getSeoDescriptionAttribute()
    {
        if (!empty($this->body)) {
            return Str::limit(nl2br(strip_tags($this->body)), 150);
        }
    }

    public function categories()
    {
        return $this->morphToMany(Category::class, 'categorizable');
    }

    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

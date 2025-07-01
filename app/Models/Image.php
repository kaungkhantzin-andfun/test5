<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Image extends Model
{
    protected $fillable = ['user_id', 'path', 'imageable_id', 'imageable_type', 'caption', 'order'];

    use HasFactory;

    protected static function boot()
    {
        parent::boot();

        // add global order scope for images
        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('order', 'asc');
        });
    }


    /**
     * Get the parent imageable model (blog or property).
     */
    public function imageable()
    {
        return $this->morphTo();
    }
}

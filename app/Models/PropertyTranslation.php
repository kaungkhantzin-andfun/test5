<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PropertyTranslation extends Model
{
    protected $fillable = ['property_id', 'locale', 'title', 'detail', 'address'];

    public $timestamps = false;

    use HasFactory;

    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}

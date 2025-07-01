<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Property extends Model
{
    protected $fillable = ['user_id', 'slug', 'price', 'type_id', 'property_purpose_id', 'parking', 'area', 'beds', 'baths', 'installment', 'featured', 'featured_expiry', 'soldout', 'stat', 'created_at'];

    protected $casts = [
        'featured' => 'datetime:Y-m-d',
        'soldout' => 'datetime:Y-m-d',
    ];

    use HasFactory;

    public function getShortDetailAttribute()
    {
        $localizedContent = $this->detail->where('locale', app()->getLocale())->first();

        if (!empty($localizedContent)) {
            // find detail with current locale
            return Str::limit(nl2br(strip_tags($localizedContent->detail)), 150);
        } else {
            // else return the other language because Myanmar language is always required to fill
            return Str::limit(nl2br(strip_tags($this->detail->first()?->detail)), 150);
        }
    }

    public function getTranslationAttribute()
    {
        $localizedContent = $this->detail->where('locale', app()->getLocale())->first();

        return $localizedContent ?: $this->detail->first();
    }

    // For property type
    public function type()
    {
        return $this->belongsTo(Category::class, 'type_id');
    }

    // Mainly for property's facilities
    public function categories()
    {
        return $this->morphToMany(Category::class, 'categorizable');
    }

    public function reactions()
    {
        return $this->morphToMany(User::class, 'savable');
        // return $this->morphToMany(User::class, 'savable')->withPivot('reaction');
    }

    public function purpose()
    {
        return $this->belongsTo(PropertyPurpose::class, 'property_purpose_id');
    }

    public function location()
    {
        return $this->belongsToMany(Location::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function detail()
    {
        return $this->hasMany(PropertyTranslation::class, 'property_id', 'id');
    }

    public function enquiries()
    {
        return $this->hasMany(Enquiry::class);
    }
}

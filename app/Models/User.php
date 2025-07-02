<?php

namespace App\Models;

use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Jetstream\HasProfilePhoto;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

// class User extends Authenticatable implements MustVerifyEmail
class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    public function getShortAboutAttribute()
    {
        if (!empty($this->about)) {
            return Str::limit(nl2br(strip_tags($this->about)), 100);
        }
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'slug', 'phone', 'email', 'credit', 'password', 'role', 'status', 'service_region_id', 'service_township_id', 'address', 'about', 'facebook_user_id', 'google_user_id', 'twitter_user_id', 'linkedin_user_id'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'partner' => 'datetime',
        'featured' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function location()
    {
        return $this->belongsTo(Location::class, 'service_region_id');
    }

    public function properties()
    {
        return $this->hasMany(Property::class);
    }

    public function reactions()
    {
        return $this->morphedByMany(Property::class, 'savable');
    }

    public function shortUrls()
    {
        return $this->hasMany(ShortUrl::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}

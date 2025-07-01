<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enquiry extends Model
{
    protected $fillable = ['property_id', 'package_id', 'agent', 'contacted_by', 'name', 'title', 'phone', 'email', 'message', 'status'];

    use HasFactory;

    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function agent()
    {
        return $this->belongsTo(User::class, 'agent');
    }
}

<?php

namespace App\Http\Models;
use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    protected $fillable = [
        'province',
        'city',
        'district',
        'address',
        'zip',
        'contact_name',
        'contact_phone',
        'last_used_at',
    ];
    protected $dates = ['last_used_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getFullAddressAttribute()
    {
        return "{$this->province}{$this->city}{$this->district}{$this->address}";
    }

    public function addresses()
    {
        return $this->hasMany(UserAddress::class);
    }
}

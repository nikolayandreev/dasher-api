<?php

namespace App\Models\Vendors;

use App\Models\Client;
use App\Models\Reservations\Reservation;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    protected $fillable = [
        'owner_id',
        'address_id',
        'name',
    ];

    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    public function owner()
    {
        return $this->belongsTo(User::class);
    }

    public function schedule()
    {
        return $this->hasMany(Schedule::class);
    }

    public function clients()
    {
        return $this->hasMany(Client::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}

<?php

namespace App\Models;

use App\Models\Reservations\Reservation;
use App\Models\Vendors\Vendor;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'vendor_id',
        'first_name',
        'last_name',
        'phone',
        'sex',
    ];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}

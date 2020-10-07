<?php

namespace App\Models\Reservations;

use App\Models\Client;
use App\Models\Services\Service;
use App\Models\Vendors\Vendor;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reservation extends Model
{
    use SoftDeletes;

    protected $table = 'reservations';

    protected $fillable = [
        'status',
        'vendor_id',
        'client_id',
        'notes',
        'date',
        'time',
        'time_to',
    ];

    protected $casts = [
        'date'      => 'date:d.m.Y',
        'time' => 'time',
        'time_to'   => 'time',
    ];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function services()
    {
        return $this->hasMany(Service::class);
    }
}

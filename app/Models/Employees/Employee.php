<?php

namespace App\Models\Employees;

use App\Models\Reservations\Services;
use App\Models\Services\Service;
use App\Models\User;
use App\Models\Vendors\Vendor;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = [
        'user_id',
        'vendor_id',
        'color',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function vendors()
    {
        return $this->belongsTo(Vendor::class, 'vendor_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function schedule()
    {
        return $this->hasMany(Schedule::class);
    }

    public function holiday()
    {
        return $this->hasMany(Holiday::class);
    }

    public function services()
    {
        return $this->belongsToMany(Service::class, 'service_employees');
    }

    public function reservations()
    {
        return $this->hasMany(Services::class, 'employee_id', 'id');
    }
}

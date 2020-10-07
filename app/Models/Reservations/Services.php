<?php

namespace App\Models\Reservations;

use App\Models\Employees\Employee;
use App\Models\Services\Service;
use Illuminate\Database\Eloquent\Model;

class Services extends Model
{
    protected $table = 'reservation_services';

    protected $fillable = [
        'reservation_id',
        'service_id',
        'employee_id',
        'quantity',
    ];

    public $timestamps = false;

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function service()
    {
        return $this->hasOne(Service::class);
    }

    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }
}

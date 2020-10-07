<?php

namespace App\Models\Employees;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $table = 'employee_schedules';

    public $timestamps = false;

    protected $fillable = [
        'employee_id',
        'day_of_week',
        'starts_at',
        'ends_at',
    ];

    protected $casts = [
        'starts_at' => 'time',
        'ends_at'   => 'time',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

}

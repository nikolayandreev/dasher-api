<?php

namespace App\Models\Employees;

use Illuminate\Database\Eloquent\Model;

class Holiday extends Model
{
    protected $table = 'employee_holidays';

    public $timestamps = false;

    protected $fillable = [
        'type',
        'employee_id',
        'date_from',
        'date_to',
    ];

    protected $casts = [
        'date_from' => 'date:d.m.Y',
        'date_to'   => 'date:d.m.Y',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}

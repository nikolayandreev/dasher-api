<?php

namespace App\Models\Vendors;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $table = 'vendor_schedules';


    protected $fillable = [
        'vendor_id',
        'day_of_week',
        'opens_at',
        'closes_at',
    ];

    public $timestamps = false;

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }
}

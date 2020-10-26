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

    public function getOpensAtAttribute($value)
    {
        return date("H:i", strtotime($value));
    }

    public function getClosesAtAttribute($value)
    {
        return date("H:i", strtotime($value));
    }

    public static function displaySchedule($vendorId)
    {
        $arr = [];

        foreach (range(0, 6) as $day) {
            $matchDay   = self::where('vendor_id', $vendorId)
                              ->where('day_of_week', $day);
            $matchedDay = $matchDay->first();

            if ($matchDay->exists()) {
                $arr[$day] = [
                    'active' => true,
                    'from'   => $matchedDay->opens_at,
                    'to'     => $matchedDay->closes_at,
                ];
            } else {
                $arr[$day] = [
                    'active' => false,
                    'from'   => '08:00',
                    'to'     => '20:00',
                ];
            }
        }

        return $arr;
    }
}

<?php

namespace App\Models\Vendors;

use App\Models\Area;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $table = 'vendor_addresses';

    public $timestamps = false;

    protected $fillable = [
        'vendor_id',
        'area_id',
        'street',
        'additional',
    ];

    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }
}

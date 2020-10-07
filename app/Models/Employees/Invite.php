<?php

namespace App\Models\Employees;

use App\Models\Vendors\Vendor;
use Illuminate\Database\Eloquent\Model;

class Invite extends Model
{
    protected $table = 'employee_invites';

    public $timestamps = false;

    protected $fillable = [
        'vendor_id',
        'email',
        'is_registered',
        'sent_at',
    ];

    protected $casts = [
        'is_registered' => 'boolean',
        'sent_at'       => 'datetime:d.m.Y H:i:s',
    ];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }
}

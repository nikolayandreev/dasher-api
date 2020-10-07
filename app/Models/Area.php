<?php

namespace App\Models;

use App\Models\Vendors\Address;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    protected $fillable = [
        'name',
    ];

    public $timestamps = false;

    public function addresses()
    {
        return $this->hasOne(Address::class);
    }
}

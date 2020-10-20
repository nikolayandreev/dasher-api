<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Vendors\Address;
use App\Models\Vendors\Vendor;

class VendorsController extends Controller
{
    public function addresses($vendorId)
    {
        if ($vendorId) {
            return Vendor::where('id', $vendorId)->first()->address()->with('area')->get();
        }
    }
}

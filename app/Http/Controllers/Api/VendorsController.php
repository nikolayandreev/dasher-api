<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Vendors\Address;
use App\Models\Vendors\Vendor;
use Illuminate\Http\Response;

class VendorsController extends Controller
{
    public function addresses($vendorId)
    {
        if ($vendorId) {
            return Vendor::where('id', $vendorId)->first()->address()->with('area')->get();
        }
    }

    public function show(Vendor $vendor)
    {
        return responder()->success($vendor->with('address'))->respond(Response::HTTP_OK);
    }
}

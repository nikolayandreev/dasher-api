<?php

namespace App\Http\Controllers\Api\Vendors;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Vendors\VendorAddressCreateRequest;
use App\Http\Requests\Api\Vendors\VendorCreateRequest;
use App\Models\Vendors\Address;
use App\Models\Vendors\Vendor;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

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

    public function store(VendorCreateRequest $request)
    {
        $address = Address::create($request->validated());
        $address->save();

        $vendor = new Vendor($request->validated());
        $vendor->owner_id = Auth::id();
        $vendor->address_id = $address->id;
        $vendor->save();

        return responder()->success($vendor)->respond(Response::HTTP_OK);
    }

    public function storeAddress(VendorAddressCreateRequest $request)
    {
        $address = Address::create($request->validated());
        $address->save();

        return responder()->success($request->only(['name', 'price']))->respond(Response::HTTP_OK);
    }
}

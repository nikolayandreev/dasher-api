<?php

namespace App\Http\Controllers\Api\Vendors;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Vendors\EmployeeInviteRequest;
use App\Http\Requests\Api\Vendors\VendorCreateRequest;
use App\Models\Vendors\Address;
use App\Models\Vendors\Schedule;
use App\Models\Vendors\Vendor;
use App\Transformers\Vendors\VendorTransformer;
use Illuminate\Http\Request;
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

    public function show($id)
    {
        $vendor = Vendor::where('id', $id)->first();

        return responder()->success($vendor, VendorTransformer::class)->respond(Response::HTTP_OK);
    }

    public function store(VendorCreateRequest $request)
    {
        $vendor       = Vendor::firstOrNew(['owner_id' => Auth::id()]);
        $vendor->name = $request->name;
        $vendor->save();

        $address             = Address::firstOrNew(['vendor_id' => $vendor->id]);
        $address->area_id    = $request->area_id;
        $address->street     = $request->street;
        $address->additional = $request->additional;
        $address->save();


        return responder()->success([
            'vendor_id'  => $vendor->id,
            'address_id' => $address->id,
        ])->respond(Response::HTTP_OK);
    }

    public function showSchedule($id)
    {
        $schedule = Schedule::displaySchedule($id);

        return responder()->success($schedule)->respond(Response::HTTP_OK);
    }

    public function storeSchedule(Request $request)
    {
        $vendor = Vendor::where('id', $request->vendor_id)->firstOrFail();

        foreach ($request->worktime as $key => $values) {
            if ($values['active']) {
                $schedule            = Schedule::firstOrNew(
                    ['day_of_week' => $key],
                    ['vendor_id' => $vendor->id]
                );
                $schedule->opens_at  = $values['from'];
                $schedule->closes_at = $values['to'];
                $schedule->save();
            } else {
                Schedule::where('vendor_id', $vendor->id)
                        ->where('day_of_week', $key)
                        ->delete();
            }
        }

        $result = Schedule::displaySchedule($request->vendor_id);

        return responder()->success($result)->respond(Response::HTTP_OK);
    }

    public function inviteEmployee(EmployeeInviteRequest $request)
    {
        $vendor = Vendor::find($request->vendor_id)->firstOrFail();

        return $vendor->employees;
    }
}

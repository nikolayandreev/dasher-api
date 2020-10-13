<?php

namespace App\Http\Controllers\Api\Cruds;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Cruds\ServiceRequest;
use App\Models\Services\Service;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Cknow\Money\Money;

class ServicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $services = Service::all();

        return responder()->success($services)->respond(Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ServiceRequest $request
     * @return Response
     * @throws AuthorizationException
     */
    public function store(ServiceRequest $request)
    {
        $this->authorize('create', Service::class);

        $service = Service::create($request->validated());
        $service->save();

        return responder()->success($request->only(['name', 'price']))->respond(Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int     $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Area;
use Illuminate\Http\Response;

class CoreController extends Controller
{
    public function areas()
    {
        return responder()->success(Area::all())->respond(Response::HTTP_OK);
    }
}

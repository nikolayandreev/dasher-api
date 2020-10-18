<?php

namespace App\Http\Controllers\Api\Cruds;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;

class ClientsController extends Controller
{
    public function index($vendor, Request $request)
    {
        $filters = $request->filters;
        $sort = $request->sort;


//        ->when($filters['date_to'], function ($q, $dateTo) {
//        return $q->whereDate('created_at', '<=', Carbon::createFromFormat('d.m.Y', $dateTo)
//            ->endOfDay());
//    })

        $clients = Client::where('vendor_id', $vendor)
            ->when($filters['id'], function ($q, $id) {
                return $q->where('id', $id);
            })
            ->when($filters['first_name'], function ($q, $firstName) {
                return $q->where('first_name', 'LIKE', '%' . $firstName . '%');
            })
            ->when($filters['last_name'], function ($q, $lastName) {
                return $q->where('last_name', 'LIKE', '%' . $lastName . '%');
            })
            ->when($filters['phone'], function ($q, $phone) {
                return $q->where('phone', 'LIKE', '%' . $phone . '%');
            })
            ->when($filters['sex'], function($q, $sex) {
                return $q->where('sex', $sex);
            })
            ->orderBy($sort['by'], $sort['dir'])
            ->orderBy('id', 'asc')
            ->paginate($request->perPage);
//            ->paginate($request->perPage);

        return responder()->success($clients)->respond(200);
    }
}

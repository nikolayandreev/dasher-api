<?php

namespace App\Http\Controllers\Api\Cruds;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Transformers\Clients\ClientsCrudTransformer;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use League\Fractal\Pagination\Cursor;
use League\Fractal\Pagination\DoctrinePaginatorAdapter;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\Serializer\JsonApiSerializer;

class ClientsController extends Controller
{
    public function index($vendor, Request $request)
    {
        $filters = $request->filters;
        $sort    = $request->sort;

        $results = Client::where('vendor_id', $vendor)->when($filters['id'], function ($q, $id) {
            return $q->where('id', $id);
        })->when($filters['first_name'], function ($q, $firstName) {
            return $q->where('first_name', 'LIKE', '%' . $firstName . '%');
        })->when($filters['last_name'], function ($q, $lastName) {
            return $q->where('last_name', 'LIKE', '%' . $lastName . '%');
        })->when($filters['phone'], function ($q, $phone) {
            return $q->where('phone', 'LIKE', '%' . $phone . '%');
        })->when($filters['sex'], function ($q, $sex) {
            return $q->where('sex', $sex);
        })
                         ->withCount('reservations')
                         ->orderBy($sort['by'], $sort['dir'])
                         ->orderBy('id', 'asc')
                         ->paginate($request->perPage);

        return responder()->success($results, ClientsCrudTransformer::class)
                          ->meta([
                              'results' => [
                                  'from' => $results->firstItem(),
                                  'to'   => $results->lastItem(),
                              ],
                          ])
                          ->respond(Response::HTTP_OK);
    }

    public function destroy(Client $client)
    {
        $client->delete();
        $client->save();

        return responder()->success()->respond(Response::HTTP_OK);
    }
}

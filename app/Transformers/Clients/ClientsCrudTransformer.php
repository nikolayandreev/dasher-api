<?php

namespace App\Transformers\Clients;

use App\Models\Client;
use Flugg\Responder\Transformers\Transformer;

class ClientsCrudTransformer extends Transformer
{
    /**
     * List of available relations.
     *
     * @var string[]
     */
    protected $relations = [
        'reservations',
    ];

    /**
     * List of autoloaded default relations.
     *
     * @var array
     */
    protected $load = [
        'reservations',
    ];

    /**
     * Transform the model.
     *
     * @param Client $client
     * @return array
     */
    public function transform(Client $client)
    {
        return [
            'id'         => (int)$client->id,
            'first_name' => (string)$client->first_name,
            'last_name'  => (string)$client->last_name,
            'total_visits' => (int) $client->reservations()->count(),
            'phone'      => (string)$client->phone,
            'sex'        => (int) $client->sex,
            'created_at' => $client->created_at->format('d.m.Y H:i:s'),
            'updated_at' => $client->updated_at->format('d.m.Y H:i:s'),
        ];
    }
}

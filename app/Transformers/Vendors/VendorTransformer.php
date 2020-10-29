<?php

namespace App\Transformers\Vendors;

use App\Models\Vendors\Vendor;
use Flugg\Responder\Transformers\Transformer;

class VendorTransformer extends Transformer
{
    /**
     * List of available relations.
     *
     * @var string[]
     */
    protected $relations = [
        'address',
        'schedule',
    ];

    /**
     * List of autoloaded default relations.
     *
     * @var array
     */
    protected $load = [
    ];

    /**
     * Transform the model.
     *
     * @param Vendor $vendor
     * @return array
     */
    public function transform(Vendor $vendor)
    {
        return [
            'id'         => (int)$vendor->id,
            'name'       => (string)$vendor->name,
            'created_at' => (string)$vendor->created_at,
            'updated_at' => (string)$vendor->updated_at,
        ];
    }
}

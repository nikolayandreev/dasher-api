<?php

namespace App\Transformers;

use App\Models\User;
use Flugg\Responder\Transformers\Transformer;

class UserTransformer extends Transformer
{
    /**
     * List of available relations.
     *
     * @var string[]
     */
    protected $relations = [
        'vendors',
        'vendor.address',
        'vendors.owner'
    ];

    /**
     * List of autoloaded default relations.
     *
     * @var array
     */
    protected $load = [
        'vendors',
        'vendors.address',
    ];

    /**
     * Transform the model.
     *
     * @param User $user
     * @return array
     */
    public function transform(User $user)
    {
        return [
            'id' => (int) $user->id,
            'first_name' => (string) $user->first_name,
            'last_name' => (string) $user->last_name,
            'email' => (string) $user->email,
            'last_active' => (string) $user->last_active,
            'subscribed' => $user->subscribed('main', 'basic') || $user->subscribed('main', 'pro'),
        ];
    }
}

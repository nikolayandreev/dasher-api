<?php

namespace App\Policies;

use App\Models\Services\Service;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ServicePolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @param User $user
     * @return bool
     */
    public function before(User $user)
    {
//        return $user->subscribed('main');
    }

    public function create(User $user)
    {
        return $user->can('services.create');
    }

    public function deactivate(User $user)
    {
        return $user->can('services.deactivate');
    }

    public function update(User $user, Service $service)
    {
        if ($service->employees()->find($user->id)) {
            return true;
        }

        if ($user->can('services.edit')) {
            return true;
        }

        return false;
    }

    public function destroy(User $user)
    {
        if ($user->can('services.delete')) {
            return true;
        }
    }
}

/*
Permission::create(['name' => 'reservations.view',]);
Permission::create(['name' => 'reservations.view.own',]);
Permission::create(['name' => 'reservations.view.all']);
Permission::create(['name' => 'reservations.create']);
Permission::create(['name' => 'reservations.edit']);
Permission::create(['name' => 'reservations.cancel']);
Permission::create(['name' => 'reservations.delete']);

Permission::create(['name' => 'employees.view']);
Permission::create(['name' => 'employees.create']);
Permission::create(['name' => 'employees.edit']);
Permission::create(['name' => 'employees.deactivate']);
Permission::create(['name' => 'employees.delete']);

Permission::create(['name' => 'employees.holidays.view']);
Permission::create(['name' => 'employees.holidays.add']);
Permission::create(['name' => 'employees.holidays.remove']);
Permission::create(['name' => 'employees.holidays.edit']);

Permission::create(['name' => 'services.view']);
Permission::create(['name' => 'services.create']);
Permission::create(['name' => 'services.edit']);
Permission::create(['name' => 'services.deactivate']);
Permission::create(['name' => 'services.delete']);
Permission::create(['name' => 'services.categories.view']);
Permission::create(['name' => 'services.categories.create']);
Permission::create(['name' => 'services.categories.edit']);
Permission::create(['name' => 'services.categories.delete']);

Permission::create(['name' => 'clients.view']);
Permission::create(['name' => 'clients.create']);
Permission::create(['name' => 'clients.edit']);
Permission::create(['name' => 'clients.deactivate']);
Permission::create(['name' => 'clients.delete']);

Permission::create(['name' => 'clients.segments.view']);
Permission::create(['name' => 'clients.segments.query']);
Permission::create(['name' => 'clients.segments.download']);
Permission::create(['name' => 'clients.segments.notify']);

Permission::create(['name' => 'analysis.view']);
Permission::create(['name' => 'analysis.download']);

Permission::create(['name' => 'billing.view']);
Permission::create(['name' => 'billing.invoices.view']);
Permission::create(['name' => 'billing.invoices.download']);
*/

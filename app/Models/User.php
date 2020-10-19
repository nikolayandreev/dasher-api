<?php

namespace App\Models;

use App\Models\Employees\Employee;
use App\Models\Vendors\Vendor;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Cashier\Billable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, Billable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function taxPercentage()
    {
        return 20;
    }

    public function mollieCustomerFields()
    {
        return [
            'email' => $this->email,
            'name'  => $this->first_name . $this->last_name,
        ];
    }

    public function vendors()
    {
        return $this->hasMany(Vendor::class, 'owner_id', 'id');
    }

    public function employed()
    {
        //TODO!
        return $this->hasManyThrough(Vendor::class, Employee::class);
    }

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }
}

<?php

namespace App\Models;

use App\Models\Employees\Employee;
use App\Models\Vendors\Vendor;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Cashier\Billable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable, Billable, HasRoles, HasApiTokens;

    public const TYPE_OWNER    = 1;
    public const TYPE_EMPLOYEE = 2;

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
        'type',
        'last_active',
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

    public function employee()
    {
        return $this->hasMany(Employee::class, 'user_id', 'id');
    }

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }

    public function getVendors()
    {
        if (!$this->vendors()->exists()) {
            if ($this->employee()->exists()) {
                return $this->employee()->first()->vendors()->with('address')->get();
            } else {
                return false;
            }
        }

        return $this->vendors()->with('address')->get();
    }

    public function scopeEmployees($query)
    {
        return $query->where('type', self::TYPE_EMPLOYEE);
    }

    public function scopeOwners($query)
    {
        return $query->where('type', self::TYPE_OWNER);
    }
}

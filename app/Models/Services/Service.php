<?php

namespace App\Models\Services;

use App\Models\Employees\Employee;
use App\Models\Reservations\Services;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $table = 'services';

    protected $fillable = [
        'vendor_id',
        'category_id',
        'name',
        'price',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function employees()
    {
        return $this->belongsToMany(Employee::class, 'service_employees');
    }

    public function reservations()
    {
        return $this->hasMany(Services::class);
    }
}

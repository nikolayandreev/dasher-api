<?php

namespace App\Models\Services;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'service_categories';

    protected $fillable = [
        'name',
        'color',
    ];

    public $timestamps = false;

    public function services()
    {
        return $this->hasMany(Service::class);
    }
}

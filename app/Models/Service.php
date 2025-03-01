<?php

namespace App\Models;

use App\Casts\EncryptArrayObject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Facades\Services as ServicesFacade;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'credentials',
        'user_id'
    ];

    protected $casts = [
        'credentials' => EncryptArrayObject::class
    ];

    protected $hidden = [
        'credentials'
    ];

    public $timestamps = false;

    protected static function booted()
    {
        static::saved(function ($service) {
            ServicesFacade::put($service->name, $service->credentials->toArray());
        });

        static::deleted(function ($service) {
            ServicesFacade::forget($service->name);
        });
    }
}

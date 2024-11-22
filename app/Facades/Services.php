<?php

namespace App\Facades;

use App\Abstracts\ServiceForm;
use App\Services as AppServices;
use Illuminate\Support\Facades\Facade;

/**
 * @method static array|ServiceForm|null services(?string $name = null)
 * @method static mixed get(string $name, null|string $credentialKey = null, mixed $default = null)
 * @method static getFromCache(string $name)
 * @method static array all()
 * @method static array configs()
 * @method static array|bool isConfigured(?string $service = null)
 * @method static void forgetAll()
 * @method static void put(string $name, array $value)
 * @method static void forget(string $name)
 *
 * @see \App\Services
 */
class Services extends Facade
{
    protected static function getFacadeAccessor()
    {
        return AppServices::class;
    }
}

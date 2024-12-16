<?php

namespace App\Abstracts;

use App\Contracts\ServiceForm as ServiceFormRulesInterface;

abstract class ServiceForm implements ServiceFormRulesInterface
{
    /**
     * The attributes that should be considered as an additional configuration.
     */
    public static array $configs = [];
}

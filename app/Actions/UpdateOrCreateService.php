<?php

namespace App\Actions;

use App\Models\Service;
use App\Models\User;

class UpdateOrCreateService
{
    public function __invoke(string $name, array $value, User $user = null): Service
    {
        return Service::updateOrCreate(['name' => $name], [
            'credentials' => $value,
            'user_id' => $user?->id
        ]);
    }
}

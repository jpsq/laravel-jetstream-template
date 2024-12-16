<?php

namespace App;

use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Crypt;
use App\Abstracts\ServiceForm;
use App\Models\Service;
use App\ServiceForm\BunnyStorageServiceForm;
use App\ServiceForm\TenorServiceForm;
use App\ServiceForm\UnsplashServiceForm;
use App\Support\Log;
use Illuminate\Foundation\Auth\User;

class Services
{
    protected mixed $config;
    private User|null $auth;

    public function __construct(Container $container)
    {
        $this->config = $container->make('config');
        $this->auth = auth()->user();
    }

    public function setAuth(User $auth): self
    {
        $this->auth = $auth;
        return $this;
    }

    public function services(?string $name = null): array|ServiceForm|null
    {
        $services = [
            'unsplash' => UnsplashServiceForm::class,
            'tenor' => TenorServiceForm::class,
            'bunnyStorage' => BunnyStorageServiceForm::class
        ];

        foreach ($services as $service) {
            if (!app($service) instanceof ServiceForm) {
                throw new \Exception("The `$service` must be an instance of Abstracts\ServiceForm");
            }
        }

        if ($name) {
            return app($services[$name]) ?? null;
        }

        return $services;
    }

    // TODO - implement `isActive` instead `isConfigured`
    public function isConfigured(?string $service = null): array|bool
    {
        $list = Arr::map($this->services(), function ($_, $provider) {
            return !!$this->get($provider, 'client_id');
        });

        if ($service) {
            return $list[$service];
        }

        return $list;
    }

    public function put(string $name, array $value): void
    {
        Cache::put($this->resolveCacheKey($name), Crypt::encryptString(json_encode($value)));
    }

    public function get(string $name, null|string $credentialKey = null, $default = null)
    {
        $serviceClass = $this->services($name);
        $defaultPayload = $serviceClass ? $serviceClass::form() : [];

        $value = $this->getFromCache($name, function () use ($name, $defaultPayload) {
            // $dbRecord = Service::where('name', $name)->first();
            $dbRecord =   $this->auth->services()->where('name', $name)->first();

            try {
                $payload = $dbRecord ? array_merge($defaultPayload, $dbRecord->credentials->toArray()) : $defaultPayload;

                $this->put($name, $payload);

                return $payload;
            } catch (DecryptException $exception) {
                $this->logDecryptionError($name, $exception);

                return $defaultPayload;
            }
        });

        if (!is_array($value)) {
            try {
                $value = json_decode(Crypt::decryptString($value), true);
            } catch (DecryptException $exception) {
                $this->logDecryptionError($name, $exception);

                $value = $defaultPayload;
            }
        }


        if ($credentialKey) {
            return Arr::get($value, $credentialKey) ? Arr::get($value, $credentialKey) : $default;
        }

        return $value;
    }

    public function all(): array
    {
        return Arr::map($this->services(), function ($payload, $name) {
            return $this->get($name);
        });
    }

    public function configs(): array
    {
        return Arr::map($this->all(), function ($payload, $name) {
            return Arr::only($payload, $this->services($name)::$configs);
        });
    }

    public function getFromCache(string $name, mixed $default = null)
    {
        return Cache::get($this->resolveCacheKey($name), $default);
    }

    public function forget($name): void
    {
        Cache::forget($this->resolveCacheKey($name));
    }

    public function forgetAll(): void
    {
        foreach (array_keys($this->services()) as $name) {
            $this->forget($name);
        }
    }

    private function resolveCacheKey(string $key): string
    {
        if (!$this->auth) throw new \Exception('Cannot resolve cache key without user');
        return $this->config->get('cache.cache_prefix') . ':' . $this->auth->id . ":services:$key";
    }

    private function logDecryptionError($name, DecryptException $exception): void
    {
        Log::error("The application key cannot decrypt the service credentials: {$exception->getMessage()}", [
            'name' => $name
        ]);
    }
}

<?php

namespace App\Http\Middleware;

use App\Facades\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Inertia\Middleware;
use Tighten\Ziggy\Ziggy;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return [
            ...parent::share($request),
            'ziggy' => fn() => [
                // ...(new Ziggy)->toArray(),
                'location' => $request->url(),
            ],
            'mixpost' => function () use ($request) {
                if (!$request->user()) return;
                return [
                    'docs_link' => 'https://docs.mixpost.app',
                    'mime_types' => Config::get('mixpost.mime_types'),
                    'settings' => [
                        'timezone' => Settings::get('timezone'),
                        'time_format' => Settings::get('time_format'),
                        'week_starts_on' => Settings::get('week_starts_on'),
                    ]
                ];
            }
        ];
    }
}

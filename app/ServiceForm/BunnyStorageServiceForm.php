<?php

namespace App\ServiceForm;

use App\Abstracts\ServiceForm;

class BunnyStorageServiceForm extends ServiceForm
{
    static function form(): array
    {
        return [
            'zone' => '',
            'api_key' => '',
            'pull_zone' => ''
        ];
    }

    public static function rules(): array
    {
        return [
            "zone" => ['required', 'string'],
            "api_key" => ['required', 'string'],
            "pull_zone" => ['required', 'url']
        ];
    }

    public static function messages(): array
    {
        return [
            // "zone" => 'The zone is required.',
            // "api_key" => 'The API Key is required.'
        ];
    }
}

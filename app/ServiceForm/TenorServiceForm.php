<?php

namespace App\ServiceForm;

use App\Abstracts\ServiceForm;

class TenorServiceForm extends ServiceForm
{
        /**
     * The attributes that should be considered as an additional configuration.
     */
    public static array $configs = [
        'documentation' => 'https://tenor.com/gifapi',
    ];
    static function form(): array
    {
        return [
            'client_id' => ''
        ];
    }

    public static function rules(): array
    {
        return [
            "client_id" => ['required']
        ];
    }

    public static function messages(): array
    {
        return [
            'client_id' => 'The API Key is required.'
        ];
    }
}

<?php

namespace App\Support;

use Illuminate\Support\Str;
use Spatie\TemporaryDirectory\TemporaryDirectory as BaseTemporaryDirectory;

class MediaTemporaryDirectory
{
    public static function create(): BaseTemporaryDirectory
    {
        return new BaseTemporaryDirectory(static::getTemporaryDirectoryPath());
    }

    protected static function getTemporaryDirectoryPath(): string
    {
        $path = (config('mixpost.temporary_directory_path') ?? storage_path('app/temp')) . DIRECTORY_SEPARATOR . Str::random(32);
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }
        return $path ;
    }
}

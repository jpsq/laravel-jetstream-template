<?php

namespace App\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Media;

class MediaFactory extends Factory
{
    protected $model = Media::class;

    public function definition()
    {
        $size = $this->faker->randomDigit();

        return [
            'name' => $this->faker->domainName,
            'mime_type' => $this->faker->mimeType(),
            'disk' => 'public',
            'path' => '',
            'size' => $size,
            'size_total' => $size,
            'conversions' => []
        ];
    }
}

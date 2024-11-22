<?php

namespace App\MediaConversions;

use App\Abstracts\MediaConversion;
use App\Support\MediaConversionData;
use Intervention\Image\ImageManager;

class MediaImageResizeConversion extends MediaConversion
{
    protected float|null $width;
    protected float|null $height = null;

    public function getEngineName(): string
    {
        return 'ImageResize';
    }

    public function canPerform(): bool
    {
        return $this->isImage() && !$this->isGifImage();
    }

    public function getPath(): string
    {
        return $this->getFilePathWithSuffix();
    }

    public function width(float|null $value = null): static
    {
        $this->width = $value;

        return $this;
    }

    public function height(float|null $value = null): static
    {
        $this->height = $value;

        return $this;
    }

    public function handle(): MediaConversionData|null
    {
        // TODO: Check if works with S3 driver
        $content = $this->filesystem($this->getFromDisk())->get($this->getFilepath());

        // $image = Image::make($content);
        // $image = ImageManager::imagick()->read($content);

        // $convert = $image->resize($this->width, $this->height, function ($constraint) {
        //     $constraint->aspectRatio();
        //     $constraint->upsize();
        // })->encode();

        // $this->filesystem()->put($this->getPath(), $convert->getEncoded(), 'public');

        return MediaConversionData::conversion($this);
    }
}

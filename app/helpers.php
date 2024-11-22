<?php

if (!function_exists('banner')) {
    function banner(string $message, string $style = 'success'): void
    {
        session()->flash('flash.banner', $message);
        session()->flash('flash.bannerStyle', $style);
    }
}

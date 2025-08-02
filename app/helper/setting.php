<?php

use App\Services\Setting\SettingService;

if (!function_exists('setting')) {
    function setting(string $key, $default = null)
    {
        static $settings;

        if (!$settings) {
            $settings = app(SettingService::class)->getSettings();
        }

        return $settings[$key] ?? $default;
    }
}

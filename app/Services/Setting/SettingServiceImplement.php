<?php

namespace App\Services\Setting;

use LaravelEasyRepository\Service;
use Illuminate\Support\Facades\Storage;
use App\Repositories\Setting\SettingRepository;

class SettingServiceImplement extends Service implements SettingService
{

    /**
     * don't change $this->mainRepository variable name
     * because used in extends service class
     */


    protected string $settingFile;

    public function __construct()
    {
        $this->settingFile = 'settings.json';
    }

    public function getSettings(): array
    {
        return cache()->remember('settings_data', now()->addHours(2), function () {
            if (!Storage::exists($this->settingFile)) {
                return $this->defaultSettings();
            }

            $settings = json_decode(Storage::get($this->settingFile), true);

            if (!is_array($settings)) {
                return $this->defaultSettings();
            }

            if (isset($settings['app_logo']) && !str_starts_with($settings['app_logo'], '/storage')) {
                $settings['app_logo'] = '/storage' . str_replace('public', '', $settings['app_logo']);
            }

            return $settings;
        });
    }


    public function updateSettings(array $newData): void
    {
        $existing = $this->getSettings();
        $merged = array_merge($existing, $newData);

        Storage::put($this->settingFile, json_encode($merged, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));

        cache()->forget('settings_data'); // clear cache biar ambil yang baru
    }


    private function defaultSettings(): array
    {
        return [
            'app_title' => 'Stockify',
            'app_logo' => '/storage/app/public/images/logo/stockify_logo.jpg',
        ];
    }

    // Define your custom methods :)
}

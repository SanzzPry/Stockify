<?php

namespace App\Services\Setting;

use LaravelEasyRepository\BaseService;

interface SettingService extends BaseService
{

    public function getSettings(): array;
    public function updateSettings(array $data): void;
    // Write something awesome :)
}

<?php

namespace App\Listeners;

use App\Events\ActivityLogged;
use Illuminate\Support\Facades\Storage;

class StoreActivityToJson
{
    public function handle(ActivityLogged $event): void
    {
        $filePath = 'logs/activity_log.json';

        $data = [
            'activity' => $event->activity,
            'user' => $event->user,
            'role' => $event->role,
            'timestamp' => $event->timestamp,
        ];

        // Pastikan folder logs/ ada
        if (!Storage::exists('logs')) {
            Storage::makeDirectory('logs');
        }

        // Ambil data yang sudah ada
        $existing = Storage::exists($filePath)
            ? json_decode(Storage::get($filePath), true)
            : [];

        $existing[] = $data;

        // Simpan kembali ke file
        Storage::put($filePath, json_encode($existing, JSON_PRETTY_PRINT));
    }
}

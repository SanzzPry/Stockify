<?php

namespace App\Repositories\User;

use App\Models\User;
use App\Events\ActivityLogged;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use LaravelEasyRepository\Implementations\Eloquent;

class UserRepositoryImplement extends Eloquent implements UserRepository
{
    protected $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model->all();
    }

    public function find($id)
    {
        return $this->model->findOrFail($id);
    }

    public function create($data)
    {
        $users = $this->model->create($data);

        event(new ActivityLogged(
            activity: 'Menambahkan user: ' . $users->name,
            user: Auth::user()?->name ?? 'Guest',
            role: Auth::user()?->role ?? 'unknown'
        ));

        return $users;
    }

    public function update($id, $data)
    {
        $users = $this->find($id);
        $users->update($data);

        event(new ActivityLogged(
            activity: 'Memperbarui user: ' . $users->name,
            user: Auth::user()?->name ?? 'Guest',
            role: Auth::user()?->role ?? 'unknown'
        ));

        return $users;
    }

    public function delete($id)
    {
        $users = $this->find($id);
        $name = $users->name;
        $result = $users->delete();

        event(new ActivityLogged(
            activity: 'Menghapus user: ' . $name,
            user: Auth::user()?->name ?? 'Guest',
            role: Auth::user()?->role ?? 'unknown'
        ));

        return $result;
    }

    public function userActivities()
    {
        $file = storage_path('app/logs/activity_log.json');

        if (!file_exists($file)) {
            return [];
        }

        $data = json_decode(file_get_contents($file), true);

        return is_array($data) ? $data : [];
    }

    public function userActivityReport()
    {
        $file = storage_path('app/logs/activity_log.json');

        if (!file_exists($file)) {
            return collect();
        }

        // Baca seluruh konten file JSON
        $json = file_get_contents($file);

        // Decode JSON menjadi array, default kosong jika gagal
        $data = json_decode($json, true) ?: [];

        // Kembalikan koleksi yang sudah diurutkan berdasarkan timestamp terbaru
        return collect($data)
            ->sortByDesc('timestamp')
            ->values();
    }
}

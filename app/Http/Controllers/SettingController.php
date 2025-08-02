<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Services\Setting\SettingService;

class SettingController extends Controller
{
    protected SettingService $settingService;

    public function __construct(SettingService $settingService)
    {
        $this->settingService = $settingService;
    }

    public function index()
    {
        $settings = $this->settingService->getSettings();
        return view('pages.admin.setting.index', [
            'settings' => $settings,
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'app_title' => 'required|string|max:100',
            'app_logo' => 'nullable|image|mimes:png,jpg,jpeg,svg|max:2048',
        ]);

        $data = ['app_title' => $request->input('app_title')];

        if ($request->hasFile('app_logo')) {
            // delete old file
            $old = $this->settingService->getSettings()['app_logo'] ?? null;
            if ($old && Storage::exists(str_replace('/storage/app', '', $old))) {
                Storage::delete(str_replace('/storage/app', '', $old));
            }

            // save new file
            $path = $request->file('app_logo')->store('public/images/logo');
            $data['app_logo'] = '/' . $path;
        }

        $this->settingService->updateSettings($data);

        return redirect()->back()->with('success', 'Pengaturan berhasil diperbarui.');
    }
}

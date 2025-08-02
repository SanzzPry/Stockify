<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use App\Services\Setting\SettingService;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    protected SettingService $settingService;

    public function __construct(SettingService $settingService)
    {
        $this->settingService = $settingService;
    }
    public function index()
    {
        return view('authentication.sign-up');
    }

    public function loginView()
    {

        return view('authentication.sign-in');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (!empty(Auth::attempt($credentials))) {
            $request->session()->regenerate();

            if (Auth::user()->role == 'Admin') {
                return redirect()->route('admin.dashboard');
            } elseif (Auth::user()->role == 'Manager Gudang') {
                return redirect()->route('manager.dashboard');
            } elseif (Auth::user()->role == 'Staff Gudang') {
                return redirect()->route('staff.dashboard');
            }
        } else {
            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ])->withInput($request->only('email'));
        }
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            // 'role' => 'required|in:Admin,Manager Gudang,Staff Gudang',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            // 'role' => $request->input('role'),
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'User registered successfully',
                'user' => $user,
            ], 201);
        } else {
            return redirect()->route('auth.login')->with('success', 'User registered successfully, please login.');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('auth.login');
    }
}

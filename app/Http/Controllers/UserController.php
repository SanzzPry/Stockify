<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Services\User\UserService;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    private function Validation($id = null)
    {
        return [
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => $id ? 'nullable|string' : 'required|string',
            'role' => 'required|in:Admin,Staff Gudang,Manager Gudang',
        ];
    }
    public function index()
    {
        $user = $this->userService->getAllUser();
        return view('pages.admin.user.index', [
            'user' => $user,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate($this->Validation());
        $validated['password'] = Hash::make($data['password']);

        $this->userService->createUser($data);

        return redirect()->route('user.index')->with('success', 'User data created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $user = $this->userService->getUserById($id);
        return view('pages.admin.user.user-edit', [
            'user' => $user,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate($this->Validation($id));

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user = $this->userService->getUserById($id);
        $user->role = $validated['role'];

        $this->userService->updateUser($id, $validated);


        return redirect()->route('user.index')->with('success', 'updating user data was successful!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $this->userService->deleteUser($id);

        return redirect()->route('user.index')->with('success', 'delete user data successfully');
    }

    public function activityLogPdf()
    {
        $logs = $this->userService->getUserActivityReport();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pages.report.pdfbyuser', compact('logs'))
            ->setPaper('a4', 'portrait');

        return $pdf->download('laporan-aktivitas-user.pdf');
    }
}

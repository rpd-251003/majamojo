<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    public function index()
    {
        return view('admin.users.index');
    }

    public function getData(Request $request)
    {
        if ($request->ajax()) {
            $query = User::query();

            // Filter by role
            if ($request->has('role') && $request->role != '') {
                $query->where('role', $request->role);
            }

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('role_badge', function ($row) {
                    $badges = [
                        'admin' => 'bg-danger',
                        'membership' => 'bg-primary',
                        'reguler' => 'bg-success'
                    ];
                    $badge = $badges[$row->role] ?? 'bg-secondary';
                    return '<span class="badge ' . $badge . '">' . ucfirst($row->role) . '</span>';
                })
                ->addColumn('status', function ($row) {
                    if ($row->email_verified_at) {
                        return '<span class="badge bg-light-success">Verified</span>';
                    }
                    return '<span class="badge bg-light-warning">Not Verified</span>';
                })
                ->addColumn('action', function ($row) {
                    // Don't allow editing/deleting the current logged-in admin
                    if (auth()->id() === $row->id) {
                        return '<span class="badge bg-light-info">Current User</span>';
                    }

                    return '<div class="btn-group" role="group">
                                <button type="button" class="btn btn-sm btn-outline-primary edit-btn" data-id="' . $row->id . '">
                                    <i class="ti ti-edit"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-danger delete-btn" data-id="' . $row->id . '">
                                    <i class="ti ti-trash"></i>
                                </button>
                            </div>';
                })
                ->rawColumns(['role_badge', 'status', 'action'])
                ->make(true);
        }
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', Rules\Password::defaults()],
            'role' => ['required', 'in:admin,membership,reguler'],
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['email_verified_at'] = now(); // Auto verify for admin-created users

        User::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'User created successfully!'
        ]);
    }

    public function show($id)
    {
        $user = User::findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $user
        ]);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $id],
            'password' => ['nullable', Rules\Password::defaults()],
            'role' => ['required', 'in:admin,membership,reguler'],
        ]);

        // Only update password if provided
        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'User updated successfully!'
        ]);
    }

    public function destroy($id)
    {
        // Prevent deleting self
        if (auth()->id() === (int)$id) {
            return response()->json([
                'success' => false,
                'message' => 'You cannot delete your own account!'
            ], 403);
        }

        $user = User::findOrFail($id);
        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'User deleted successfully!'
        ]);
    }

    public function resetPassword(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'password' => ['required', Rules\Password::defaults(), 'confirmed'],
        ]);

        $user->update([
            'password' => Hash::make($validated['password'])
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Password reset successfully!'
        ]);
    }
}

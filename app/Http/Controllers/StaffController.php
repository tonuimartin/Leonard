<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class StaffController extends Controller
{    // Fetch all users with role_id = 2 (API endpoint)
    public function index()
    {
        $staff = User::where('role_id', 2)
            ->active()
            ->select('id', 'name', 'email', 'role_id', 'phone_number')
            ->with('role')
            ->get()
            ->map(function ($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'phone_number' => $user->phone_number,
                    'role' => $user->role->role_name ?? '',
                ];
            });
        return response()->json($staff);
    }

    // Show the staff view (for Inertia/Vue)
    public function showStaffView()
    {
        $staff = User::where('role_id', 2)
            ->active()
            ->select('id', 'name', 'email', 'role_id', 'phone_number')
            ->with('role')
            ->get()
            ->map(function ($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'phone_number' => $user->phone_number,
                    'role' => $user->role->role_name ?? '',
                ];
            })
            ->toArray(); // Ensure it's a plain array

        return Inertia::render('AdminStaffViewModal', [
            'staff' => $staff
        ]);
    }

    // Create a new staff member
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone_number' => 'nullable|string|max:20',
            'password' => 'required|string|min:8',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'password' => bcrypt($request->password),
            'role_id' => 2, // Staff role
            'deleted' => 0, // Default to active
        ]);

        return redirect()->route('staff.view')->with('success', 'Staff member created successfully.');
    }

    // Soft delete a staff member
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->softDelete(); // This will set deleted = 1

        return response()->json(['success' => true, 'message' => 'Staff member deleted successfully.']);
    }    // Update a staff member
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone_number' => 'nullable|string|max:20',
        ]);

        $user->update($validated);

        return response()->json(['success' => true, 'message' => 'Staff member updated successfully.']);
    }
}

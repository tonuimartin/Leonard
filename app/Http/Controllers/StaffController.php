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
        \Log::info('=== STAFF REGISTRATION STARTED ===', [
            'request_data' => $request->all(),
            'user_id' => auth()->id(),
            'user_email' => auth()->user()->email ?? 'unknown'
        ]);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone_number' => 'nullable|string|max:20',
            'password' => 'required|string|min:8',
        ]);

        \Log::info('Validation passed, creating user...');

        try {
            // Create the user
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'password' => bcrypt($request->password),
                'role_id' => 2, // Staff role (automatically assigned)
                'deleted' => 0, // Default to active
                'admin_approved' => true, // Auto-approve since admin is creating them
                'admin_approved_at' => now(),
                'approved_by' => auth()->id(), // Current admin
            ]);

            \Log::info('User created successfully by admin', [
                'user_id' => $user->id,
                'email' => $user->email,
                'created_by_admin' => auth()->id()
            ]);

            // Send email verification notification (user still needs to verify email)
            $user->sendEmailVerificationNotification();
            \Log::info('Email verification sent to user');

            // No need to notify admins since an admin is creating this user

            return redirect()->route('staff.view')->with(
                'success',
                'Staff member created successfully. They will receive an email verification link and can login once they verify their email.'
            );
        } catch (\Exception $e) {
            \Log::error('Error creating staff member', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return redirect()->back()->with('error', 'Failed to create staff member: ' . $e->getMessage());
        }
    }

    /**
     * Notify all admins about new user registration
     */
    private function notifyAdminsAboutNewRegistration($user, $approvalToken)
    {
        try {
            $admins = User::where('role_id', 1)->active()->get();
            \Log::info('Found admin users for notification', ['count' => $admins->count()]);

            foreach ($admins as $admin) {
                \Log::info('Sending admin approval notification', ['admin_email' => $admin->email]);
                $admin->notify(new \App\Notifications\AdminApprovalRequired($user, $approvalToken));
                \Log::info('Admin approval notification sent successfully', ['admin_email' => $admin->email]);
            }
        } catch (\Exception $e) {
            \Log::error('Error sending admin notifications', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
        }
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

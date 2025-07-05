<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\UserApproved;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;

class AdminApprovalController extends Controller
{
    /**
     * Show the approval page
     */
    public function showApprovalPage(Request $request)
    {
        $token = $request->get('token');
        $userId = $request->get('user');

        \Log::info('Admin approval link accessed', [
            'token' => $token,
            'user_id' => $userId,
            'request_url' => $request->fullUrl()
        ]);

        // Find the user with the matching token
        $user = User::where('id', $userId)
            ->where('admin_approval_token', $token)
            ->where('admin_approved', false)
            ->first();

        if (!$user) {
            \Log::warning('Admin approval failed: User not found or already approved', [
                'token' => $token,
                'user_id' => $userId
            ]);
            return response()->view('admin.approval-error', [
                'message' => 'User not found or already approved.'
            ], 404);
        }

        // Check if user has verified email
        if (!$user->hasVerifiedEmail()) {
            \Log::warning('Admin approval failed: User email not verified', [
                'user_id' => $user->id,
                'user_email' => $user->email
            ]);
            return response()->view('admin.approval-error', [
                'message' => 'This user has not yet verified their email address.'
            ], 400);
        }

        // Get admin_email from the link
        $adminEmail = $request->get('admin_email');
        $admin = null;
        if ($adminEmail) {
            $admin = User::where('email', $adminEmail)
                ->where('role_id', 1)
                ->where('deleted', 0)
                ->first();
        }
        if (!$admin) {
            return response()->view('admin.approval-error', [
                'message' => 'Invalid or unauthorized admin for approval.'
            ], 403);
        }
        $adminId = $admin->id;
        $adminName = $admin->name;

        // Approve the user
        $user->approveByAdmin($adminId);

        // Send approval notification to the user
        $user->notify(new UserApproved($admin));

        \Log::info('User approved successfully', [
            'user_id' => $user->id,
            'user_email' => $user->email,
            'approved_by' => $adminId
        ]);

        // Return a simple success page
        return response()->view('admin.approval-success', [
            'user' => $user,
            'admin' => $adminName,
            'message' => 'User has been approved successfully!'
        ]);
    }

    /**
     * Approve the user
     */
    public function approveUser(Request $request)
    {
        // Verify the signed URL
        if (!URL::hasValidSignature($request)) {
            abort(403, 'Invalid or expired approval link.');
        }

        $token = $request->get('token');
        $userId = $request->get('user');

        // Find the user with the matching token
        $user = User::where('id', $userId)
            ->where('admin_approval_token', $token)
            ->where('admin_approved', false)
            ->first();

        if (!$user) {
            return redirect()->route('admin.approval-error')->with('error', 'User not found or already approved.');
        }

        // Check if user has verified email
        if (!$user->hasVerifiedEmail()) {
            return redirect()->route('admin.approval-error')->with('error', 'This user has not yet verified their email address.');
        }

        // Get admin_email from the link
        $adminEmail = $request->get('admin_email');
        $admin = null;
        if ($adminEmail) {
            $admin = User::where('email', $adminEmail)
                ->where('role_id', 1)
                ->where('deleted', 0)
                ->first();
        }
        if (!$admin) {
            return response()->view('admin.approval-error', [
                'message' => 'Invalid or unauthorized admin for approval.'
            ], 403);
        }
        $adminId = $admin->id;
        $adminName = $admin->name;

        // Approve the user
        $user->approveByAdmin($adminId);

        // Send approval notification to the user
        $user->notify(new UserApproved($admin));

        \Log::info('User approved successfully', [
            'user_id' => $user->id,
            'user_email' => $user->email,
            'approved_by' => $adminId
        ]);

        // Return a simple success page
        return response()->view('admin.approval-success', [
            'user' => $user,
            'admin' => $adminName,
            'message' => 'User has been approved successfully!'
        ]);
    }

    /**
     * Show pending approvals for admin dashboard
     */
    public function showPendingApprovals()
    {
        // Only admins can view this
        if (!Auth::user() || !Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized access.');
        }

        $pendingUsers = User::pendingApproval()
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.pending-approvals', [
            'pendingUsers' => $pendingUsers
        ]);
    }

    /**
     * Approve user from admin dashboard
     */
    public function approveFromDashboard(Request $request, $userId)
    {
        // Only admins can do this
        if (!Auth::user() || !Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized access.');
        }

        $user = User::where('id', $userId)
            ->where('admin_approved', false)
            ->first();

        if (!$user) {
            return back()->with('error', 'User not found or already approved.');
        }

        // Check if user has verified email
        if (!$user->hasVerifiedEmail()) {
            return back()->with('error', 'This user has not yet verified their email address.');
        }

        // Approve the user
        $user->approveByAdmin(Auth::id());

        // Send approval notification to the user
        $user->notify(new UserApproved(Auth::user()));

        return back()->with('success', 'User approved successfully.');
    }
}

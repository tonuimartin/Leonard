<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\AdminApprovalRequired;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:' . User::class,
            'phone_number' => 'nullable|string|max:20',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        Log::info('=== USER SELF-REGISTRATION STARTED ===', [
            'name' => $request->name,
            'email' => $request->email
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'password' => Hash::make($request->password),
            'role_id' => 2, // Automatically assign staff role
            'admin_approved' => false, // Requires admin approval
            'deleted' => 0, // Active by default
        ]);

        Log::info('User created successfully for self-registration', [
            'user_id' => $user->id,
            'email' => $user->email
        ]);

        // Generate admin approval token
        $approvalToken = $user->generateAdminApprovalToken();
        Log::info('Approval token generated for self-registered user', ['token' => $approvalToken]);

        // Send email verification
        event(new Registered($user));
        Log::info('Email verification event triggered');

        // Notify all admins about the new self-registration
        $this->notifyAdminsAboutNewRegistration($user, $approvalToken);

        // Do NOT log the user in automatically since they need approval
        // Auth::login($user);

        // Redirect to a pending approval page instead of dashboard
        return redirect()->route('login')->with(
            'status',
            'Registration successful! Please check your email to verify your address. Your account will be activated once an administrator approves it.'
        );
    }

    /**
     * Notify all admins about new user self-registration
     */
    private function notifyAdminsAboutNewRegistration($user, $approvalToken)
    {
        try {
            $admins = User::where('role_id', 1)->active()->get();
            Log::info('Found admin users for self-registration notification', ['count' => $admins->count()]);

            foreach ($admins as $admin) {
                Log::info('Sending admin approval notification for self-registration', ['admin_email' => $admin->email]);
                $admin->notify(new AdminApprovalRequired($user, $approvalToken));
                Log::info('Admin approval notification sent successfully for self-registration', ['admin_email' => $admin->email]);
            }
        } catch (\Exception $e) {
            Log::error('Error sending admin notifications for self-registration', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }
}

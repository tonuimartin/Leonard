<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class VerifyEmailController extends Controller
{
    /**
     * Mark the user's email address as verified (without requiring login).
     */
    public function __invoke($id, $hash): RedirectResponse
    {
        $user = User::findOrFail($id);

        if (!hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
            return redirect()->route('login')->with('status', 'Invalid verification link.');
        }

        if ($user->hasVerifiedEmail()) {
            if ($user->admin_approved) {
                return redirect()->intended(route('dashboard', absolute: false) . '?verified=1');
            } else {
                return redirect()->route('login')->with('status', 'Email already verified! Your account is pending admin approval.');
            }
        }

        $user->markEmailAsVerified();
        event(new Verified($user));

        \Log::info('User email verified (no login required)', [
            'user_id' => $user->id,
            'email' => $user->email,
            'admin_approved' => $user->admin_approved
        ]);

        if ($user->admin_approved) {
            return redirect()->intended(route('dashboard', absolute: false) . '?verified=1');
        } else {
            return redirect()->route('login')->with('status', 'Email verified successfully! Your account is pending admin approval. You will receive an email once approved.');
        }
    }
}

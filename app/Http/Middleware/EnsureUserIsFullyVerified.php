<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsFullyVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        // Check if user's email is verified
        if (!$user->hasVerifiedEmail()) {
            return redirect()->route('verification.notice')
                ->with('status', 'Please verify your email address to continue.');
        }

        // Check if user is admin approved
        if (!$user->admin_approved) {
            // If user is an admin, automatically approve them
            if ($user->isAdmin()) {
                $user->approveByAdmin($user->id);
                return $next($request);
            }

            // For non-admin users, show pending approval message
            Auth::logout();
            return redirect()->route('login')
                ->with('status', 'Your account is pending admin approval. You will receive an email once approved.');
        }

        return $next($request);
    }
}

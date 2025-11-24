<?php

namespace App\Http\Controllers;

use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

/**
 * AuthController
 * 
 * Handles admin authentication including login and logout
 * Features:
 * - Admin-only authentication (prevents regular users from logging in)
 * - Session management with CSRF protection
 * - Secure password validation
 * - Session regeneration for security
 * 
 * Note: Admin credentials are seeded in UserSeeder
 * Email: admin@wisata.com, Password: password
 */
class AuthController extends Controller
{
    /**
     * Display admin login form
     * 
     * Shows the login page for admin users only
     * Session must not be authenticated (RedirectIfAuthenticated middleware)
     *
     * @return \Illuminate\View\View Login page view
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Handle admin login with role verification
     * 
     * Process:
     * 1. Validate email and password
     * 2. Attempt authentication via Auth::attempt()
     * 3. Verify user has admin role (security check)
     * 4. Regenerate session ID to prevent session fixation
     * 5. Redirect to admin dashboard on success
     *
     * Security Features:
     * - Email format validation (prevents invalid emails)
     * - Minimum password length (6 characters)
     * - Role-based access control (admin only)
     * - Session regeneration (prevents session hijacking)
     * - CSRF token protection (via VerifyCsrfToken middleware)
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse Redirect to dashboard or back to login
     */
    public function login(Request $request)
    {
        // ===== VALIDATE CREDENTIALS =====
        // Email: required, must be valid email format
        // Password: required, minimum 6 characters
        $credentials = $request->validate([
            'email' => 'required|email',                                // Valid email format required
            'password' => 'required|min:6',                             // Min 6 chars for security
        ]);

        // ===== ATTEMPT AUTHENTICATION =====
        // Uses 'web' guard by default (configured in config/auth.php)
        // Checks email and password against Users table
        if (Auth::attempt($credentials)) {
            // ===== REGENERATE SESSION =====
            // Create new session ID to prevent session fixation attacks
            $request->session()->regenerate();
            
            // ===== FETCH AUTHENTICATED USER =====
            $user = Auth::user();

            // ===== VERIFY ADMIN ROLE =====
            // SECURITY: Only allow users with 'admin' role
            // Regular users ('user' role) cannot access admin panel
            if ($user->role !== 'admin') {
                // ===== REJECT NON-ADMIN USER =====
                Auth::logout();                                         // Clear authentication
                $request->session()->invalidate();                      // Invalidate session
                return back()->withErrors([
                    'email' => 'Hanya admin yang dapat login.',         // Indonesian: "Only admin can login"
                ])->onlyInput('email');
            }

            // ===== LOGIN SUCCESS - REDIRECT TO DASHBOARD =====
            // @intended: redirects to requested page if available, else admin dashboard
            return redirect()->intended(route('admin.dashboard'))
                ->with('success', 'Selamat datang Admin!');             // Indonesian: "Welcome Admin!"
        }

        // ===== LOGIN FAILED =====
        // Return generic error message (doesn't reveal if email exists)
        // Prevents user enumeration attacks
        return back()->withErrors([
            'email' => 'Email atau password salah.',                    // Indonesian: "Invalid email or password"
        ])->onlyInput('email');
    }

    /**
     * Handle admin logout
     * 
     * Process:
     * 1. Clear authentication state
     * 2. Invalidate current session
     * 3. Regenerate CSRF token (new token for next login)
     * 4. Redirect to home page
     *
     * Security Features:
     * - Session invalidation (prevents session reuse)
     * - CSRF token regeneration (invalidates old tokens)
     * - Clears all session data
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse Redirect to home page
     */
    public function logout(Request $request)
    {
        // ===== CLEAR AUTHENTICATION =====
        // Remove authenticated user from memory
        Auth::logout();

        // ===== INVALIDATE SESSION =====
        // Remove all session data from storage
        // Prevents use of existing session token
        $request->session()->invalidate();

        // ===== REGENERATE CSRF TOKEN =====
        // Create new CSRF token for next request
        // Old tokens become invalid (security measure)
        $request->session()->regenerateToken();

        // ===== REDIRECT HOME =====
        return redirect('/')->with('success', 'Anda telah logout.');    // Indonesian: "You have logged out"
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Auth\Events\Verified;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            return redirect()->route('employee.dashboard');
        }

        return back()->withErrors(['email' => 'Invalid credentials']);
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);

        $user = User::create([
            'first_name' => $validated['first_name'] ?? 'Default First Name',
            'last_name' => $validated['last_name'] ?? 'Default Last Name',
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'company' => $validated['company'] ?? 'Default Company',
            'position' => $validated['position'] ?? 'Default Position',
            'department' => $validated['department'] ?? 'Default Department',
            'branch' => $validated['branch'] ?? json_encode(['Default Branch']),
        ]);

        Auth::login($user);

        if ($user) {
            return view('employee.dashboard')
            ->with('status', 'Registration successful! Please select your company mode.');
        } else {
            return back()->withErrors(['registration' => 'Registration failed. Please try again.']);
        }
        
    }

    // public function showCompanyModeSelection()
    // {
    //     return view('auth.select_company_mode');
    // }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login.form');
    }


    
// Show forgot password form
public function showForgotPasswordForm()
{
    return view('auth.forgot-password');
}

// Send reset link email
public function sendResetLinkEmail(Request $request)
{
    $request->validate(['email' => 'required|email']);

    $status = Password::sendResetLink($request->only('email'));

    return $status === Password::RESET_LINK_SENT
        ? back()->with('status', __($status))
        : back()->withErrors(['email' => __($status)]);
}

// Show password reset form
public function showResetForm(Request $request, $token)
{
    return view('auth.reset-password', ['token' => $token, 'email' => $request->email]);
}

// Handle password reset
public function resetPassword(Request $request)
{
    $request->validate([
        'token' => 'required',
        'email' => 'required|email',
        'password' => 'required|confirmed|min:6',
    ]);

    $status = Password::reset(
        $request->only('email', 'password', 'password_confirmation', 'token'),
        function ($user, $password) {
            $user->forceFill([
                'password' => Hash::make($password),
                'remember_token' => Str::random(60),
            ])->save();

            event(new PasswordReset($user));
        }
    );

    return $status === Password::PASSWORD_RESET
        ? redirect()->route('login.form')->with('status', __($status))
        : back()->withErrors(['email' => [__($status)]]);
}

// Send email verification link
public function sendEmailVerification(Request $request)
{
    if ($request->user()->hasVerifiedEmail()) {
        return redirect()->route('dashboard');
    }

    $request->user()->sendEmailVerificationNotification();

    return back()->with('status', 'Verification link sent!');
}

// Handle email verification
public function verifyEmail(Request $request)
{
    if ($request->user()->hasVerifiedEmail()) {
        return redirect()->route('dashboard');
    }

    if ($request->user()->markEmailAsVerified()) {
        event(new Verified($request->user()));
    }

    return redirect()->route('dashboard')->with('status', 'Email verified!');
}

}

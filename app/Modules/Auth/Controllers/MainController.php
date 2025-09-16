<?php

namespace App\Modules\Auth\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;

use App\Modules\Auth\Models\User;

class MainController extends Controller
{
    public function vLogin()
    {
        return view('source::Auth.Views.login');
    }

    public function vRegister()
    {
        return view('source::Auth.Views.register');
    }

    public function loginValidate(Request $request)
    {
        $executed = RateLimiter::attempt(
            'login-attempt:' . $request->ip(),
            $perMinute = 5,
            function() {
                // Callback kosong, untuk hit counting
            },
            $decayRate = 60
        );

        if (!$executed) {
            Log::channel('audit')->warning('Rate limit exceeded for login', [
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'action' => 'rate_limit_exceeded',
                'timestamp' => now()
            ]);

            return back()->withErrors([
                'email' => 'Terlalu banyak percobaan login. Silakan coba lagi dalam 1 menit.',
            ])->withInput();
        }

        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:8',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            $emailExecuted = RateLimiter::attempt(
                'login-failed:' . $request->email,
                $perMinute = 3,
                function() {},
                $decayRate = 300 // 5 menit
            );

            if (!$emailExecuted) {
                Log::channel('audit')->warning('Rate limit exceeded for failed login attempts', [
                    'email' => $request->email,
                    'ip_address' => $request->ip(),
                    'action' => 'failed_login_rate_limit',
                    'timestamp' => now()
                ]);
            }

            Log::channel('audit')->warning('Login attempt failed', [
                'email' => $request->email,
                'action' => 'login_failed',
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'timestamp' => now()
            ]);

            throw ValidationException::withMessages([
                'email' => ['Email atau password salah.'],
            ]);
        }

        RateLimiter::clear('login-failed:' . $request->email);
        RateLimiter::clear('login-attempt:' . $request->ip());

        Auth::login($user);

        $request->session()->regenerate();

        Log::channel('audit')->info('User logged in successfully', [
            'user_id' => $user->id,
            'user_email' => $user->email,
            'user_name' => $user->name,
            'action' => 'login_success',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'timestamp' => now()
        ]);

        return redirect('/task-todos');
    }

    public function registerValidate(Request $request)
    {
        $executed = RateLimiter::attempt(
            'register-attempt:' . $request->ip(),
            $perMinute = 3,
            function() {},
            $decayRate = 3600 // 1 jam
        );

        if (!$executed) {
            Log::channel('audit')->warning('Rate limit exceeded for registration', [
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'action' => 'registration_rate_limit',
                'timestamp' => now()
            ]);

            return back()->withErrors([
                'email' => 'Terlalu banyak percobaan registrasi. Silakan coba lagi dalam 1 jam.',
            ])->withInput();
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255|min:3',
            'email' => 'required|email|unique:users,email',
            'password' => [
                'required',
                'min:8',
                'confirmed',
                'regex:/^(?=.*[a-z])(?=.*[A-Z]).+$/', // positive lookahead untuk huruf besar dan kecil
            ],
            'terms' => 'required|accepted'
        ], [
            'terms.required' => 'Anda harus menyetujui syarat dan ketentuan',
            'terms.accepted' => 'Anda harus menyetujui syarat dan ketentuan',
            'password.confirmed' => 'Konfirmasi password tidak sesuai',
            'password.regex' => 'Password harus mengandung minimal 1 huruf besar, 1 huruf kecil, dan 1 angka'
        ]);
        
        $user = User::create([
            'id' => (string) Str::uuid(),
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'email_verified_at' => null 
        ]);

        RateLimiter::clear('register-attempt:' . $request->ip());

        Log::channel('audit')->info('User registered successfully', [
            'user_id' => $user->id,
            'user_email' => $user->email,
            'user_name' => $user->name,
            'action' => 'registration_success',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'timestamp' => now()
        ]);

        //Auto Login Setelah Daftar
        // auth()->login($user);
        
        return redirect()->route('login')
            ->with('status', 'Registrasi berhasil! Silakan login.');
    }

    public function logout(Request $request)
    {
        try {
            $userId = Auth::id();
            $userEmail = Auth::user()->email;

            Auth::logout();

            $request->session()->invalidate();

            $request->session()->regenerateToken();

            Log::channel('audit')->info('User logged out successfully', [
                'user_id' => $userId,
                'user_email' => $userEmail,
                'action' => 'logout',
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'timestamp' => now()
            ]);

            return redirect()->route('login')
                ->with('status', 'You have been logged out successfully.');

        } catch (\Exception $e) {
            Log::channel('audit')->error('Error during logout', [
                'user_id' => Auth::id() ?? 'unknown',
                'error' => $e->getMessage(),
                'ip_address' => $request->ip(),
                'timestamp' => now()
            ]);

            return redirect()->route('login')
                ->with('error', 'Logout completed with some issues.');
        }
    }
}
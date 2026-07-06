<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Models\ActivityLog;

class LoginController extends Controller
{
    public function showLoginForm(): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
        ]);

        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            $user = Auth::user();

            // Validate status
            if ($user->status !== 'active') {
                Auth::logout();
                return redirect()->route('login')
                    ->with('error', 'Akun Anda telah dinonaktifkan. Hubungi Administrator.');
            }

            $request->session()->regenerate();

            // Log activity (boot observer will automatically enrich with user details)
            ActivityLog::create([
                'aktivitas' => "Login berhasil.",
                'user' => $user->name,
                'role' => $user->role,
            ]);

            return redirect()->intended(route('dashboard'));
        }

        return back()->with('error', 'Email atau Password yang Anda masukkan tidak sesuai.')->withInput();
    }

    public function logout(Request $request): RedirectResponse
    {
        if (Auth::check()) {
            $user = Auth::user();
            
            // Log activity before logging out
            ActivityLog::create([
                'aktivitas' => "Logout berhasil.",
                'user' => $user->name,
                'role' => $user->role,
            ]);

            Auth::logout();
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}

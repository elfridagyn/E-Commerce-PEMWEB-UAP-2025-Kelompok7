<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Tampilkan halaman login
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle login request
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // Authentikasi user
        $request->authenticate();

        // Regenerate session untuk keamanan
        $request->session()->regenerate();

        // Ambil user yang login
        $user = Auth::user();

        // Redirect sesuai role
        return $this->authenticated($request, $user);
    }

    /**
     * Redirect setelah login sesuai role
     */
    protected function authenticated(Request $request, $user): RedirectResponse
    {
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($user->role === 'user') {
            return redirect()->route('user.dashboard');
        } elseif ($user->role === 'seller') {
            return redirect()->route('seller.dashboard');
        }

        // fallback
        return redirect()->route('login');
    }

    /**
     * Logout user
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login'); // arahkan ke halaman login setelah logout
    }
}

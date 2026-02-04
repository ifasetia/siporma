<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\RoleEnum;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
public function store(LoginRequest $request): RedirectResponse
{
    $request->authenticate();

    $request->session()->regenerate();

    $user = auth()->user();
    return redirect()->route('dashboard');

    // return match ($user->role) {
    //     RoleEnum::SUPER_ADMIN => redirect('/super-admin/dashboard'),
    //     RoleEnum::ADMIN => redirect('/admin/dashboard'),
    //     RoleEnum::INTERN => redirect('/intern/dashboard'),
    //     default => redirect('dashboard'),
    //     return redirect()->intended(route('dashboard', absolute: false));
    // };
}

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}

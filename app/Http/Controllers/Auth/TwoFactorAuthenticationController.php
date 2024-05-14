<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\TwoFactorAuthenticationRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Inertia\Response;

class TwoFactorAuthenticationController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): Response|RedirectResponse
    {
        if (! auth()->check()) {
            return redirect()->route('login');
        }

        return Inertia::render('Auth/TwoFactorAuthentication', [
            'canResetPassword' => Route::has('password.request'),
            'status' => session('status'),
        ]);
    }

    /**
     * Check the two factor authentication code.
     */
    public function store(TwoFactorAuthenticationRequest $request): RedirectResponse
    {
        $request->session()->put('2fa:verified', true);
        $request->user()->update([
            'two_factor_code' => null,
            'two_factor_expires_at' => null,
        ]);

        return redirect()->intended(RouteServiceProvider::HOME);
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Services\Auth\Authentication;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(Authentication $authService)
    {
        $this->authService = $authService;
    }
    public function login()
    {
        return view('auth.login');
    }

    public function authenticate(LoginRequest $request)
    {
        $ip = request()->ip();
        $browser = request()->header('User-Agent');

        try {
            $user = $this->authService->authenticate($request->validated());

            activity()
                ->performedOn($user)
                ->causedBy($user)
                ->log('User ' . $user->first_name . ' ' . $user->last_name . " logged in successfully. ({$ip} - {$browser})");

            return redirect()
                ->route(Auth::user()->getRoleNames()->first() . '.dashboard')
                ->with('success', 'Logged in successfully!');
        } catch (AuthenticationException $e) {
            activity()
                ->log("Failed login attempt: ({$ip} - {$browser})");

            return redirect()
                ->route('login.index')
                ->with('failed', 'Invalid login credentials.');
        }
    }

    public function logout(Request $request)
    {
        $ip = $request->ip();
        $browser = $request->header('User-Agent');

        $user = Auth::user();
        if ($user) {
            activity()->performedOn($user)->causedBy($user)
                ->log('User '.$user->first_name.' '.$user->last_name." logged out successfully. ({$ip} - {$browser})");
        }

        $this->authService->logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login.index')->with('success', 'You have successfully logged out!');
    }
}
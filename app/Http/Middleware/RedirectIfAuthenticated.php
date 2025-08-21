<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, string ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $user = Auth::guard($guard)->user();
                
                $role = $user?->getRoleNames()->first();
                
                $routeName = match ($role) {
                    'superadmin' => 'superadmin.dashboard',
                    'admin'      => 'admin.dashboard',
                    'user'       => 'user.dashboard',
                    default      => 'login.index',
                };

                return redirect()->route($routeName);
            }
        }

        return $next($request);
    }
}

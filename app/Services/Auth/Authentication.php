<?php

namespace App\Services\Auth;
use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Auth;

class Authentication
{
    public function authenticate(array $data): User
    
    {
        if($user = Auth::attempt($data))
        {
            request()->session()->regenerate();
            return Auth::user();
        }

        throw new AuthenticationException('Invalid login credentials.');
    }

    public function logout():? User
    {
        $user = Auth::user();
        Auth::logout();
        return $user;
    }
}
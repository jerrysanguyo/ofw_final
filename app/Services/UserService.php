<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UserService
{
    public function userStore($data): User
    {
        $user = User::updateOrCreate(
            [
                'uuid' => Str::uuid()->toString(),
                'email' => $data['email'],
                'contact_number' =>$data['contact_number'],
            ],
            [
                'first_name' => $data['first_name'],
                'middle_name' => $data['middle_name'],
                'last_name' => $data['last_name'],
                'password'=> bcrypt($data['password']),
            ]
        );

        if ($user) {
            $user->assignRole($data['role']);
        }

        return $user ?: null;
    }

    public function userUpdate($data, $user): User
    {
        if (!empty($data['password'])) {
            $user->password = bcrypt($data['password']);
        }

        $user->update([
            'email' => $data['email'],
            'contact_number' =>$data['contact_number'],
            'first_name' => $data['first_name'],
            'middle_name' => $data['middle_name'],
            'last_name' => $data['last_name'],
            'password' => $user->password,
        ]);

        if($user) {
            $user->syncRoles([$data['role']]);
        }

        return $user ?: null;
    }

    public function destroyUser($user): User
    {
        DB::transaction(function () use ($user) {
            $user->syncRoles([]); 
            $user->delete();
        });

        return $user ?: null;
    }
}
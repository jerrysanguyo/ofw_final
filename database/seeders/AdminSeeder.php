<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use App\Models\User;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $superAdminRole = Role::firstOrCreate(['name' => 'superadmin']);
        
        $admin = User::firstOrCreate(
            ['email' => 'superadmin@gmail.com'],
            [
                'uuid' => Str::uuid(),
                'first_name' => 'Super',
                'middle_name' => '',
                'last_name' => 'Admin',
                'contact_number' => '09271852711',
                'email_verified_at' => now(),
                'password' => Hash::make('JSngSAdmin1998!'),
                'remember_token' => Str::random(10),
            ]
        );
        
        if (! $admin->hasRole($superAdminRole->name)) {
            $admin->assignRole($superAdminRole);
        }
    }
}

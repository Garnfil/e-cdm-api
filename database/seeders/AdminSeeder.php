<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Admin::create([
            'username' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('Test123!'),
            'firstname' => 'Main',
            'lastname' => 'Admin',
            'contact_no' => '639633987953',
            'gender' => 'Male',
            'status' => 'active',
            'admin_role' => 'super_admin',
        ]);
    }
}

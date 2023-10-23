<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        
        User::create([
            'username' => 'superadmin',
            'email' => 'superadmin@uni-siegen.de',
            'password' => Hash::make('123456'),
            'role' => 1, 
            'active' => true,
        ]);
    }

}

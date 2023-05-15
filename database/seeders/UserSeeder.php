<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::truncate();
        $exist = User::where('role', 'admin')->count();
        if (!$exist) {
            User::create([
                'name' => 'Administrator',
                'email' => "admin@bkk.com",
                'email_verified_at' => now(),
                'password' => Hash::make("123"),
                'role' => 'admin',
            ]);
        }
        // User::factory(2)->create();
    }
}

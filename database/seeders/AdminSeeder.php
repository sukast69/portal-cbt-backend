<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@cbt.test',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Guru 1',
            'email' => 'guru1@cbt.test',
            'password' => Hash::make('password'),
            'role' => 'guru',
            'nip' => '198001012010011001',
        ]);

        User::create([
            'name' => 'Guru 2',
            'email' => 'guru2@cbt.test',
            'password' => Hash::make('password'),
            'role' => 'guru',
            'nip' => '198501012015021002',
        ]);
    }
}

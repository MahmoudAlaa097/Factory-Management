<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => 'Mahmoud Alaa',
            'username' => 'eng',
            'management_id' => '1',
            'password' => Hash::make('123'),
            'serial' => '7474',
            'role_id' => '4',
        ]);
    }
}

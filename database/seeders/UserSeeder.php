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
        User::create([
            'name' => 'Christian Camacho',
            'username' => 'christiancam14',
            'email' => 'chriscamacho1045@gmail.com',
            'password' => Hash::make('camachos14'),
        ]);
    }
}

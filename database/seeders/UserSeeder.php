<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'nom' => 'Mbaye',
            'prenom' => 'Oumar',
            'email' => 'oumarmbaye004@gmail.com',
            'password' => Hash::make('passer1994'), // mot de passe sécurisé
            'role' => 'gestionnaire',
        ]);

        User::create([
            'nom' => 'Mbaye',
            'prenom' => 'Ngalla',
            'email' => 'ngallambaye390@gmail.com',
            'password' => Hash::make('passer3108'),
            'role' => 'client',
        ]);
    }
}

<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
          
        User::insert([[
            'name' => 'Politeknik Negeri Malang',
            'email' => 'pnm@gmail.com',
            'role' => 'operator',
            'pt_id' => 1,
            'password' => bcrypt('password'),
        ],
        [
        'name' => 'Universitas Teknokrat Indonesia',
        'email' => 'uti@gmail.com',
        'role' => 'operator',
        'pt_id' => 2,
        'password' => bcrypt('password'),
    ]
    ]);

        User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'role' => 'superadmin',
            'password' => bcrypt('password'),
        ]);
    }
}

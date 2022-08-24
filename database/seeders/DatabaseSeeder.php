<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Divisi;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Divisi::create([
            'nama' => 'Pemasaran'
        ]);

        User::create([
            'email' => 'admin@gmail.com',
            'name' => 'admin',
            'password' => \Hash::make('password'),
            'role' => 'admin',
            'divisi_id' => 1
        ]);

        \App\Models\User::factory(10)->create();
    }
}

<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'role_id' => 1,
            'name' => 'Franklin Fernandez',
            'email' => 'franklin@demo.com',
            'password' => bcrypt('password'),
            'status' => 1
        ]);
    }
}

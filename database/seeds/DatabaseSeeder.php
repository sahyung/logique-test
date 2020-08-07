<?php

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        User::create([
            'first_name' => 'Super Admin',
            'last_name' => 'Super Admin',
            'email' => 'superadmin@test.com',
            'password' => bcrypt('123456'),
            'role' => 'superadmin'
        ]);
        User::create([
            'first_name' => 'Admin',
            'last_name' => 'Admin',
            'email' => 'admin@test.com',
            'password' => bcrypt('123456'),
            'role' => 'admin'
        ]);
        User::create([
            'first_name' => 'User',
            'last_name' => 'User',
            'email' => 'user@test.com',
            'password' => bcrypt('123456'),
            'role' => 'user'
        ]);
    }
}

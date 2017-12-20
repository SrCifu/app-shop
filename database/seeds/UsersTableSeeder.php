<?php

use Illuminate\Database\Seeder;
use App\User;

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
            'name' => 'Ceci',
            'email' => 'ceci@angularsoftware.es',
            'password' => bcrypt('asdf,123'),
            'admin' => true
        ]);
    }
}

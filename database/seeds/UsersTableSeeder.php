<?php

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
        DB::table('users')->insert([
            'name' => 'Ayon',
            'email' => 'ayon@thecatalystindia.in',
            'password' => bcrypt('admin123$'),
            'role' => 0,
        ]);
    }
}

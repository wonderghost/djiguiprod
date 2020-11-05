<?php

use Illuminate\Database\Seeder;

class UserSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'admin@djiguiprod.com',
            'password' => Hash::make('bonjour'),
            'phone' =>  '624075702',
            'role'  =>  'admin',
            'state' =>  true
        ]);
    }
}

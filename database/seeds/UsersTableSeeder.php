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
            'name_surname' => str_random(10),
            'email' => str_random(10).'@gmail.com',
            'password' => bcrypt('secret'),
            'gender' => 'Erkek' || 'Kadın',
            'bdate' => '1996-02-01',
            'user_type_id' => '1',            
        ]);        
    }
}

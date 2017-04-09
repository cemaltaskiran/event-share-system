<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

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
            'name_surname' => 'Cemal Taşkıran',
            'username' => 'necrodancer',
            'email' => 'cemaltaskiran@gmail.com',
            'password' => bcrypt('123456'),
        ]);  
    }
}

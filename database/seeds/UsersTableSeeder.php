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
            'name' => 'Cemal Taşkıran',
            'email' => 'cemaltaskiran@gmail.com',
            'password' => bcrypt('123456'),
            'gender' => 'Erkek',
            'bdate' => '1996-02-01'
        ]);
    }
}

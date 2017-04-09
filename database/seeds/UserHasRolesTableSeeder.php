<?php

use Illuminate\Database\Seeder;

class UserHasRolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_has_roles')->insert([
            'user_id' => '1',
			'role_id' => '1',
        ]);  
    }
}

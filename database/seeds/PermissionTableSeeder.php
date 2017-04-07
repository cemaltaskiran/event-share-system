<?php

use Illuminate\Database\Seeder;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions= [
            [
        		'name' => 'role-list',        		
        		'description' => 'See only Listing Of Role'
        	],
        	[
        		'name' => 'role-create',        		
        		'description' => 'Create New Role'
        	],
        	[
        		'name' => 'role-edit',        		
        		'description' => 'Edit Role'
        	],
        	[
        		'name' => 'role-delete',        		
        		'description' => 'Delete Role'
        	]
        ];
        foreach ($permissions as $key => $value) {
        	Permission::create($value);
        }
    }
}

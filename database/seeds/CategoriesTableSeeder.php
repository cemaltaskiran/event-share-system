<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            'name' => 'Eğitim',
        ]);
        DB::table('categories')->insert([
            'name' => 'Festival',
        ]);
        DB::table('categories')->insert([
            'name' => 'Fuar',
        ]);
        DB::table('categories')->insert([
            'name' => 'Gezi',
        ]);
        DB::table('categories')->insert([
            'name' => 'Kamp',
        ]);
        DB::table('categories')->insert([
            'name' => 'Konferans',
        ]);
        DB::table('categories')->insert([
            'name' => 'Kongre',
        ]);
        DB::table('categories')->insert([
            'name' => 'Konser',
        ]);
        DB::table('categories')->insert([
            'name' => 'Sahne Sanatları',
        ]);
        DB::table('categories')->insert([
            'name' => 'Seminer',
        ]);
        DB::table('categories')->insert([
            'name' => 'Sempozyum',
        ]);
        DB::table('categories')->insert([
            'name' => 'Sergi',
        ]);
        DB::table('categories')->insert([
            'name' => 'Söyleşi',
        ]);
        DB::table('categories')->insert([
            'name' => 'Yarışma',
        ]);
        DB::table('categories')->insert([
            'name' => 'Zirve',
        ]);
    }
}

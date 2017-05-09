<?php

use Illuminate\Database\Seeder;

class CategoryEventTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $i=0;
      for($i=0;$i<15;$i++){
         DB::table('category_event')->insert([
             'category_id' => rand(1,15),
             'event_id' => rand(1,15),
         ]);
      }
    }
}

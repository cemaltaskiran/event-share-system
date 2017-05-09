<?php

use Illuminate\Database\Seeder;

class EventsTableSeeder extends Seeder
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
         DB::table('events')->insert([
             'name' => str_random(10),
             'city' => rand(1,81),
             'place' => str_random(10),
             'start_date' => '2017-04-28 09:00',
             'finish_date' => '2017-04-30 19:00',
             'last_attendance_date' => '2017-04-28 09:00',
             'publication_date' => '2017-04-14 09:00',
             'status' => '0',
             'creator_id' => '1',
             'description' => "Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."
         ]);
      }
    }
}

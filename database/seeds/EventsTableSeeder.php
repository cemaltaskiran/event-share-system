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
             'city' => str_random(7),
             'place' => str_random(10),
             'start_date' => '2017-04-28 09:00',
             'finish_date' => '2017-04-30 19:00',
             'last_attendance_date' => '2017-04-28 09:00',
             'publication_date' => '2017-04-14 09:00',
             'status' => '0',
         ]);
      }
    }
}

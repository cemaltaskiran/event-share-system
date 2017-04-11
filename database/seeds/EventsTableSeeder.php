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
             'name' => '12. Iltek Gunleri',
             'place' => 'Yildiz Teknik Universitesi Davutpasa Kampusu EEF Salonu',
             'start_date' => '2017-04-12 09:00',
             'finish_date' => '2017-04-14 19:00',
             'last_attendance_date' => '2017-04-12 09:00',
         ]);
      }
    }
}

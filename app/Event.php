<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    
    protected $table = 'events';

    // protected $fillable = [
    //     'name', 'place', 'quota', 'start_date', 'finish_date', 'last_attendance_date', 'attendance_price'
    //     ];
    protected $guarded = [];

}
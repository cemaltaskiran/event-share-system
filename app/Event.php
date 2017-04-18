<?php

namespace App;

use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class Event extends Model
{

    use Searchable;

    protected $table = 'events';


    // protected $fillable = [
    //     'name', 'place', 'quota', 'start_date', 'finish_date', 'last_attendance_date', 'attendance_price'
    //     ];
    protected $guarded = [];

}

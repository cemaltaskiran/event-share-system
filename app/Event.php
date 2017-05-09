<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class Event extends Model
{

    protected $table = 'events';


    // protected $fillable = ['name', 'place', 'quota', 'start_date', 'finish_date', 'last_attendance_date', 'attendance_price'];
    protected $guarded = [];

    public function categories()
    {
        return $this->belongsToMany('App\Category', 'category_event', 'event_id', 'category_id');
    }
    public function comments()
    {
        return $this->hasMany('App\Comment', 'event_id');
    }
    public function files()
    {
        return $this->hasMany('App\EventFile', 'event_id');
    }
    public function users()
    {
        return $this->belongsToMany('App\User');
    }
    public function eventable()
    {
        return $this->morphTo();
    }
}

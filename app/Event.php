<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class Event extends Model
{

    protected $table = 'events';

    protected $guarded = [];

    public function categories()
    {
        return $this->belongsToMany('App\Category', 'category_event', 'event_id', 'category_id');
    }
    public function comments()
    {
        return $this->hasMany('App\Comment');
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
    public function city()
    {
        return $this->belongsTo('App\City', 'city_id', 'code');
    }
    public function complaints()
    {
        return $this->hasMany('App\Complaint');
    }
    public function priority()
    {
        return $this->hasOne('App\Priority');
    }
}

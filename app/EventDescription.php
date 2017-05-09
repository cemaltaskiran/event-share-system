<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventDescription extends Model
{
    protected $table = 'event_descriptions';

    protected $guarded = [];

    public function event()
    {
        return $this->belongsTo('App\Event');
    }
}

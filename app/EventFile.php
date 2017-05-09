<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventFile extends Model
{
    protected $table = 'event_files';

    protected $guarded = [];

    public function event()
    {
        return $this->belongsTo('App\Event');
    }
    public function file_type()
    {
        return $this->hasOne('App\FileType');
    }
}

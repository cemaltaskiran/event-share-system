<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $table = 'cities';

    public function events()
    {
        return $this->hasMany('App\Event', 'code', 'city_id');
    }
}

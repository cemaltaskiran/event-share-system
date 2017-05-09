<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable, HasRoles;

    protected $fillable = [
        'name', 'email', 'password', 'gender', 'bdate'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function createdEvents()
    {
        return $this->morphMany('App\Event', 'eventable');
    }

    public function events()
    {
        return $this->belongsToMany('App\Event');
    }

}

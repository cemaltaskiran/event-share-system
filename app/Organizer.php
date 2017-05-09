<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\OrganizerResetPasswordNotification;

class Organizer extends Authenticatable
{
    use Notifiable;

    protected $guard = 'organizer';

    protected $fillable = [
        'name', 'email', 'password', 'address'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new OrganizerResetPasswordNotification($token));
    }

    public function events()
    {
        return $this->morphMany('App\Event', 'eventable');
    }
}

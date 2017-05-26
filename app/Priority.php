<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class Event extends Model
{

    protected $table = 'priority_events';

    protected $guarded = [];

}

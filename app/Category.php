<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class Category extends Model
{
    protected $table = 'categories';

    protected $guarded = [];

    public function events()
    {
        return $this->belongsToMany('App\Event', 'category_event', 'category_id', 'event_id');
    }
    public function getCountItsUsed($now)
    {
        return count($this->events()->where([
            ['category_id', '=', $this->id],
            ['status', '=', 1],
            ['finish_date', '>', $now],
            ])->get());
    }
}

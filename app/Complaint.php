<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    protected $table = "complaints";

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function event()
    {
        return $this->belongsTo('App\Event');
    }

    public function complaintType()
    {
        return $this->belongsTo('App\ComplaintType', 'type_id', 'id');
    }
}

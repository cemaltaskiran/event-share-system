<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ComplaintType extends Model
{
    protected $table = "complaint_types";

    protected $guarded = [];

    public function complaints()
    {
        return $this->hasMany('App\Complaint', 'id', 'type_id');
    }
}

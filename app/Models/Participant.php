<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    //
    public function projects()
    {
        return $this->belongsToMany('App\Models\Project');
    }
}

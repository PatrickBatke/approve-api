<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tagname',
    ];

    public function projects()
    {
        return $this->belongsToMany('App\Models\Project');
    }
}

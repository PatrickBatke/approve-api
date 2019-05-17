<?php

namespace App\Models\Authentification;

use Illuminate\Database\Eloquent\Model;

class Password_reset extends Model
{
    //
    protected $table = 'password_resets';
    public $timestamps = false;
}

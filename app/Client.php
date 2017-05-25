<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    public $timestamps = false;

    public function devices()
    {
        return $this->hasMany('App\Device');
    }
}

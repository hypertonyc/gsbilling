<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Billingdevice extends Model
{
    public $timestamps = false;

    public function billingclient()
    {
        return $this->belongsTo('App\Billingclient');
    }
}

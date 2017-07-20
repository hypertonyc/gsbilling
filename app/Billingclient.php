<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Billingclient extends Model
{
    public $timestamps = false;

    public function billing()
    {
        return $this->belongsTo('App\Billing');
    }

    public function billingdevices()
    {
        return $this->hasMany('App\Billingdevice');
    }
}

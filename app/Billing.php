<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Billing extends Model
{
  public function billingclients()
  {
    return $this->hasMany('App\Billingclient');
  }
}

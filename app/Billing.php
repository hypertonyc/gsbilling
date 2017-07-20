<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;

class Billing extends Model
{
  public function billingclients()
  {
    return $this->hasMany('App\Billingclient');
  }

  public function getCreatedAtAttribute($date)
  {
    if(isset($date)) {
      return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('d-m-Y');
    } else {
      return 'Нет данных';
    }
  }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;

class Device extends Model
{
  public $timestamps = false;

  public function client()
  {
      return $this->belongsTo('App\Client');
  }

  public function getLastDateAttribute($date)
  {
    if(isset($date)) {
      return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('d-m-Y H:i:s');
    } else {
      return 'Нет данных';
    }
  }
}

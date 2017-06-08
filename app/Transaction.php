<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;
use Cache;

class Transaction extends Model
{
  public function client()
  {
      return $this->belongsTo('App\Client');
  }

  public function user()
  {
      return $this->belongsTo('App\User');
  }

  public function getCreatedAtAttribute($date)
  {
    if(isset($date)) {
      $clock = Cache::get('settings.clock', 3);
      return Carbon::createFromFormat('Y-m-d H:i:s', $date)->addHours($clock)->format('d-m-Y H:i:s');
    } else {
      return 'Нет данных';
    }
  }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
  /**
   * The attributes that should be cast to native types.
   *
   * @var array
   */
  protected $casts = [
      'last_date' => 'timestamp',
  ];

  public $timestamps = false;

  public function client()
  {
      return $this->belongsTo('App\Client');
  }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Cache;

class SettingsController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
      $this->middleware('auth');
  }

  /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $clock = Cache::get('settings.clock', 3);

    $settings = array(
      'clock' => $clock,
    );

    return view('settings', ['settings' => $settings] );
  }

  public function saveSettings(Request $request)
  {
    $this->validate($request, [
        'clock' => 'required|integer',
    ]);

    $clock = $request->input('clock');
    Cache::put('settings.clock', $clock);

    $settings = array(
      'clock' => $clock,
    );

    $saved = array(
      'success' => true
    );

    return view('settings', ['settings' => $settings, 'saved' => $saved] );
  }
}

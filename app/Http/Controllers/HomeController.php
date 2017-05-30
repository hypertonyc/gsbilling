<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Cache;

class HomeController extends Controller
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
        $api_requests_dates = array(
          'authoruze' => Cache::get('last_get_auth_token', null),
          'update' => Cache::get('last_get_davices_data', null),
          'actualize' => Cache::get('last_get_actual_data', null),
        );
        return view('home', array('api_requests_dates' => $api_requests_dates));
    }
}

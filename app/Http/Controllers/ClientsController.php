<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Client;

class ClientsController extends Controller
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
        return view('clients');
    }

    public function getClients()
    {
      $clients_coll = Client::with('devices')->get();
      $clients = array();

      foreach ($clients_coll as $value) {
          $devices = $value->devices->sortByDesc('last_date');

          $clients[] = array(
              'id' => $value->id,
              'remote_id' => $value->remote_id,
              'name' => $value->name,
              'price' => $value->price,
              'balance' => $value->balance,
              'devices' => $devices
          );
      }

      return response()->json(['clients' => $clients]);
    }
}

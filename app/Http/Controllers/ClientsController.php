<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Client;
use App\Device;

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
      $clients = Client::with(['devices' => function($query) {
        $query->orderBy('devices.last_date', 'desc');
      }])->orderBy('name')->get();
      
      return response()->json(['clients' => $clients]);
    }

    public function updateClients($id, Request $request)
    {
      $client = Client::find($id);

      $client->name = $request->name;
      $client->price = $request->price;

      $client->save();

      return response()->json(
        array('result' => true)
      );
    }
}

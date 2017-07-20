<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Billing;
use App\Billingclient;
use App\Billingdevice;

class BillingsController extends Controller
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
      $billings = Billing::orderBy('created_at')->get();
      return view('billings', ['billings' => $billings]);
  }

  /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Http\Response
   */
  public function showBilling($id)
  {
      $billing = Billing::with('billingclients', 'billingclients.billingdevices')->find($id);

      foreach ($billing->billingclients as $key => $client) {
        $billing->billingclients[$key]->devices_count = $client->billingdevices->count();

        $billing->billingclients[$key]->active_devices_count = $client->billingdevices->filter(function ($value, $key) {
          return $value->amount > 0;
        })->count();

        $billing->billingclients[$key]->billing_amount = $client->billingdevices->sum('amount');
      }

      return view('billing', ['billing' => $billing]);
  }
}

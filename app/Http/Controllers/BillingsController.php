<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Billing;

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
      $billing = Billing::find($id);
      return view('billing', ['billing' => $billing]);
  }
}

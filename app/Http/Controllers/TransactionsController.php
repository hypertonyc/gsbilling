<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Auth;

use App\Client;
use App\Transaction;
use App\User;

class TransactionsController extends Controller
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
    return view('transactions');
  }

  /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Http\Response
   */
  public function getTransactions()
  {
    $clients = Client::orderBy('name')->get()->keyBy('id');
    $transactions = Transaction::orderBy('created_at', 'desc')->get()->keyBy('id');
    $users = User::all()->keyBy('id');

    return response()->json(['clients_with_transactions' => array(
      'clients' => $clients,
      'transactions' => $transactions,
      'users' => $users
    )]);
  }

  /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Http\Response
   */
  public function insertTransactions(Request $request)
  {
    DB::transaction(function () use ($request) {
      $transaction = new Transaction;

      $transaction->client_id = $request->client_id;
      $transaction->user_id = Auth::id();
      $transaction->amount = $request->amount;
      $transaction->description = $request->description;

      $transaction->save();

      $client = Client::find($request->client_id);

      $client->balance += $request->amount;

      $client->save();
    });


    return response()->json(
      array('result' => true)
    );
  }
}

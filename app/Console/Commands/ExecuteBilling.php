<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use Cache;

use App\Client;
use App\Transaction;

use App\Billing;
use App\BillingClient;
use App\BillingDevice;

use Carbon\Carbon;

class ExecuteBilling extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'billing:execute';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Execute billing action';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
      $clients = Client::with(['devices' => function($query) {
        $query->orderBy('devices.last_date', 'desc');
      }])->orderBy('name')->get();

      DB::transaction(function () use ($clients) {
        // Create empty row (will update it at the end)
        $billing = new Billing;
        $billing->save();

        // Date of the previous month's beginning
        $billdate = Carbon::now()->subMonth()->startOfMonth();

        $clients->each(function($client) use (&$billing, $billdate ) {

          $bilclient = new Billingclient;

          $bilclient->billing_id = $billing->id;
          $bilclient->name = $client->name;
          $bilclient->price = $client->price;
          $bilclient->balance = $client->balance;

          $bilclient->save();

          // Update amount of clients on billing row
          $billing->clients++;

          $bildevices = array();
          $debit_amount = 0;

          foreach ($client->devices as $device) {
            // Update amount of devices on billing row
            $billing->devices++;

            $bildevice = array(
              'billingclient_id' => $bilclient->id,
              'imei' => $device->imei,
              'number' => $device->number,
              'is_free' => $device->is_free,
              'last_date' => null,
              'amount' => 0.0
            );

            if ( $device->last_date != 'Нет данных' ) {

              $dev_last_date = Carbon::createFromFormat('d-m-Y H:i:s', $device->last_date);
              $bildevice['last_date'] = $dev_last_date;

              if (($dev_last_date > $billdate) && (!$device->is_free)) {
                $bildevice['amount'] = $client->price;

                // Update amount of active devices and total amount on billing row
                $billing->amount += $client->price;
                $billing->active_devices++;

                // Update amount to create a transaction later
                $debit_amount += $client->price;
              }
            }

            $bildevices[] = $bildevice;
          }
          // Insert all devices
          Billingdevice::insert($bildevices);

          // Make transaction if we need
          if ($debit_amount > 0) {
            $debit_transaction = new Transaction;
            $debit_transaction->client_id = $client->id;
            $debit_transaction->amount = -1 * $debit_amount;
            $debit_transaction->description = 'Автоматическая транзакция во время списания ' . Carbon::now()->format('d-m-Y');
            $debit_transaction->save();

            $debit_client = Client::find($client->id);
            $debit_client->balance += $debit_transaction->amount;
            $debit_client->save();
          }
        });

        // Save statistics        
        $billing->save();
      });
    }
}

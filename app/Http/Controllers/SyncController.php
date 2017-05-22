<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\GlonassoftApi\ApiRequest;

use Carbon\Carbon;
use Carbon\CarbonInterval;

class SyncController extends Controller
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
        return view('synclogs');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function request()
    {
        $view_params = array();        

        $view_params['auth'] = '';
        
        return view('syncrequest', $view_params);
    }


    public function updateDevices()
    {
        $retdata = array();

        $api = new ApiRequest();
        $devices = $api->getDevicesData();

        if (is_array($devices) && (count($devices) > 0)) {

            $dev_collections = collect($devices);

            $dev_collections->chunk(500)->each( function($items) {

                $devices_values_str = '';
                $clients_values_str = '';

                foreach($items as $item) {
                    $devices_values_str .= '('.$item['vehicleId'].',"'.$item['imei'].'","'.$item['number'].'","'.$item['owner'].'"), ';
                    $clients_values_str .= '("'.$item['owner'].'","'.$item['owner'].'"), ';
                }

                $devices_values_str = rtrim($devices_values_str, ", ");
                $clients_values_str = rtrim($clients_values_str, ", ");
                
                try {
                    \DB::insert("INSERT INTO devices (`remote_id`, `imei`, `number`, `remote_client_id`) VALUES $devices_values_str ON DUPLICATE KEY UPDATE `imei`=VALUES(`imei`), `number`=VALUES(`number`)");
                } catch (\Exception $e) {
                    Log::error('Devices update error: ' . $e->getMessage());
                }

                try {
                    \DB::insert("INSERT IGNORE INTO clients (`remote_id`, `name`) VALUES $clients_values_str");
                } catch (\Exception $e) {
                    Log::error('Devices update error: ' . $e->getMessage());
                }

                try {
                    \DB::insert("UPDATE devices left join clients on devices.remote_client_id = clients.remote_id set devices.client_id = clients.id");
                } catch (\Exception $e) {
                    Log::error('Devices update error: ' . $e->getMessage());
                }
            });
            
        
        }

        //return response()->json($devices);
    }

    public function actualizeDevices()
    {
        $retdata = array();

        $api = new ApiRequest();
        $devices = $api->getActualData();

        if (is_array($devices) && (count($devices) > 0)) {

            $dev_collections = collect($devices);

            $dev_collections->chunk(500)->each( function($items) {

                $devices_values_str = '';
                
                foreach($items as $item) {
                    $date = new \DateTime($item['ReceiveTime']);
                    $devices_values_str .= '('.$item['VehicleID'].',"'.$date->format('Y-m-d H:i:s').'"), ';                    
                }

                $devices_values_str = rtrim($devices_values_str, ", ");
                
                try {
                    \DB::insert("INSERT INTO devices (`remote_id`, `last_date`) VALUES $devices_values_str ON DUPLICATE KEY UPDATE `last_date`=VALUES(`last_date`)");
                } catch (\Exception $e) {
                    Log::error('Devices actualize error: ' . $e->getMessage());
                }                
            });
            
        
        }

        //return response()->json($devices);
    }
}

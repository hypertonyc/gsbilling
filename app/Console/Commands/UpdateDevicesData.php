<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\GlonassoftApi\ApiRequest;

class UpdateDevicesData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'devices:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update static info about devices & users';

    /**
 	 * GlonasSoft api wrapper
	 *
	 * @var DripEmailer
	 */
	protected $apiRequest;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(ApiRequest $apiRequest)
    {
        parent::__construct();
		
		$this->apiRequest = $apiRequest;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $devices = $this->apiRequest->getActualData();

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
    }
}

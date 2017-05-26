<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\GlonassoftApi\ApiRequest;
use Illuminate\Support\Facades\Log;

use Cache;

class ActualizeDevicesData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'devices:actualize';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update info about last data arriving';

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
        $clock = Cache::get('settings.clock', 3);

        $devices = $this->apiRequest->getActualData();

        if (is_array($devices) && (count($devices) > 0)) {

            $dev_collections = collect($devices);

            $dev_collections->chunk(500)->each( function($items) use ($clock) {

                $devices_values_str = '';

                foreach($items as $item) {
                    $date = new \DateTime($item['ReceiveTime']);
                    $date = $date->add(new \DateInterval('PT' . $clock . 'H'));
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
    }
}

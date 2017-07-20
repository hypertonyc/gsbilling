<?php

namespace App\GlonassoftApi;

use GuzzleHttp\Client;
use GuzzleHttp\Promise;
use GuzzleHttp\Psr7\Response;

use Carbon\Carbon;

use Cache;

class ApiRequest
{
	protected $token_expires = 720; // 12 hours

	protected $devices_url = '';
	protected $actual_data_url = '';

	public function __construct() {

		$this->devices_url = env('GLONASSOFT_API_URL', 'error_url') . 'vehicles_';
		$this->actual_data_url = env('GLONASSOFT_API_URL', 'error_url') . 'monitoringVehicles/update_';

	}

	public static function authorize() {

		$api_url = env('GLONASSOFT_API_URL', 'error_url');
		$api_login = env('GLONASSOFT_API_LOGIN', 'error_login');
		$api_password = env('GLONASSOFT_API_PASSWORD', 'error_password');

		$clock = Cache::get('settings.clock', 3);

		$headers = ['accept' => 'application/json', 'accept-encoding' => 'gzip, deflate', 'accept-language' => 'en-US,en;q=0.8'];

		$auth_token = '';
		$client = new Client();
	    $res = $client->request('GET', $api_url . 'auth/login?username=' . $api_login . '&password=' . $api_password, ['headers' => $headers]);
	    if ($res->getStatusCode() == 200)
	    {
	        $client_data = json_decode((string) $res->getBody(), true);

	        if(is_array($client_data) && array_key_exists('AuthId', $client_data)) {
	        	$auth_token = $client_data['AuthId'];
						Cache::forever('last_get_auth_token', Carbon::now($clock));
	        }

	    }
	    return $auth_token;
	}

	public function getDevicesData() {

		$ret_data = array();

		$auth_key = Cache::remember('glonassoft_auth_token', $this->token_expires, function () {
		    return ApiRequest::authorize();
		});

		$clock = Cache::get('settings.clock', 3);

		$headers = ['accept' => 'application/json', 'accept-encoding' => 'gzip, deflate', 'accept-language' => 'en-US,en;q=0.8', 'X-Auth' => $auth_key];

		$client = new Client();
	    $res = $client->request('GET', $this->devices_url, ['headers' => $headers]);
	    if ($res->getStatusCode() == 200)
	    {
	        $client_data = json_decode((string) $res->getBody(), true);

	        if(is_array($client_data)) {
	        	$ret_data = $client_data;
						Cache::forever('last_get_davices_data', Carbon::now($clock));
	        }

	    }
	    return $ret_data;
	}

	public function getActualData() {

		$ret_data = array();

		$auth_key = Cache::remember('glonassoft_auth_token', $this->token_expires, function () {
		    return ApiRequest::authorize();
		});

		$clock = Cache::get('settings.clock', 3);

		$headers = ['accept' => 'application/json', 'accept-encoding' => 'gzip, deflate', 'accept-language' => 'en-US,en;q=0.8', 'X-Auth' => $auth_key];

		$client = new Client();
	    $res = $client->request('GET', $this->actual_data_url, ['headers' => $headers]);
	    if ($res->getStatusCode() == 200)
	    {
	        $client_data = json_decode((string) $res->getBody(), true);

	        if(is_array($client_data)) {
	        	$ret_data = $client_data;
						Cache::forever('last_get_actual_data', Carbon::now($clock));
	        }

	    }
	    return $ret_data;
	}
}

<?php namespace Devnull\Main\Classes;

use App, Config;
use Google_Client, Google_Cache_File;
use Google_Service_Analytics, Google_Auth_AssertionCredentials;
use ApplicationException;
use Devnull\Main\Models\Settings;

class Analytics
{
	use \October\Rain\Support\Traits\Singleton;
	public $client;
	public $service;
	public $viewID;

	//----------------------------------------------------------------------//
	//	__construct Functions - Start
	//----------------------------------------------------------------------//

	//----------------------------------------------------------------------//
	//	Main Functions - Start
	//----------------------------------------------------------------------//

	protected function init()
	{
		$settings = Settings::instance();

		if (!strlen($settings->profile_id)) {
			throw new ApplicationException(trans('devnull.main::lang.classes.strings_not_configured'));
		}

		if (!$settings->gapi_key) {
			throw new ApplicationException(trans('devnull.main::lang.classes.key_not_uploaded'));
		}

		$client = new Google_Client();
		$cache = App::make(CacheItemPool::class);
		$client->setCache($cache);

		$auth = json_decode($settings->gapi_key->getContents(), true);
		$client->setAuthConfig($auth);
		$client->addScope(Google_Service_Analytics::ANALYTICS_READONLY);

		if ($client->isAccessTokenExpired()) {
			$client->refreshTokenWithAssertion();
		}

		$this->client = $client;
		$this->service = new Google_Service_Analytics($client);
		$this->viewId = 'ga:'.$settings->profile_id;

	}

	//----------------------------------------------------------------------//
	//	Overridden Functions - Start
	//----------------------------------------------------------------------//

	//----------------------------------------------------------------------//
	//	Shared Functions - Start
	//----------------------------------------------------------------------//

	//----------------------------------------------------------------------//
	//	Directive Functions - Ends
	//----------------------------------------------------------------------//

}
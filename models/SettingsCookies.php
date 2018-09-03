<?php namespace Devnull\Main\Models;

use Model, DB, BackendMenu;

class SettingsCookies extends Model
{
	public $implement               =   ['System.Behaviors.SettingsModel'];
	public $settingsCode            =   'devnull_main_cookies';
	public $settingsFields          =   'fields.yaml';

	public static $_table           =   'system_settings';
	public static $_system_plugin   =   'system_plugin_versions';

	//----------------------------------------------------------------------//
	//	__construct Functions - Start
	//----------------------------------------------------------------------//

	function __construct(){parent::__construct();}

	//----------------------------------------------------------------------//
	//	Main Functions - Start
	//----------------------------------------------------------------------//

	//----------------------------------------------------------------------//
	//	Overridden Functions - Start
	//----------------------------------------------------------------------//

	//----------------------------------------------------------------------//
	//	Shared Functions - Start
	//----------------------------------------------------------------------//

	public function getUseVerticalOptions($value, $formData)
	{
		return [
			'top'       =>  ['devnull.main::lang.models.cookies_top_label', 'devnull.main::lang.models.cookies_top_desc'],
			'bottom'    =>  ['devnull.main::lang.models.cookies_bottom_label', 'devnull.main::lang.models.cookies_bottom_desc']
		];
	}

	public function getUseHorizontalOptions($value, $formData)
	{
		return [
			'left'  => ['devnull.main::lang.models.cookies_left_label', 'devnull.main::lang.models.cookies_left_desc'],
			'right' => ['devnull.main::lang.models.cookies_right_label', 'devnull.main::lang.models.cookies_right_desc']
		];
	}

	public function getUseWhichOptions($value, $formData)
	{
		return [
			'notif_bar'     =>  ['devnull.main::lang.models.cookies_notif_label', 'devnull.main::lang.models.cookies_notif_desc'],
			'circle'        =>  ['devnull.main::lang.models.cookies_circle_label', 'devnull.main::lang.models.cookies_circle_desc'],
			'bouncy_flip'   =>  ['devnull.main::lang.models.cookies_bouncy_label', 'devnull.main::lang.models.cookies_bouncy_desc'],
			'simple'        =>  ['devnull.main::lang.models.cookies_simple_label', 'devnull.main::lang.models.cookies_simple_desc']

		];
	}

	//----------------------------------------------------------------------//
	//	SettingsCookies Functions - End
	//----------------------------------------------------------------------//
}
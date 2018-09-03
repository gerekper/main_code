<?php namespace Devnull\Main\Models;

use Model, DB, BackendMenu;
use Cms\Classes\Page;

class SettingsHuman extends Model
{
	public $implement               =   ['System.Behaviors.SettingsModel'];
	public $settingsCode            =   'devnull_main_humans';
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

	public function getRedirectpageOptions($keyvalue = null)
	{
		$this->_validator = (!Settings::get('use_redirect'))? false : True;
		$_value = Page::getNameList();

		if ($this->_validator == TRUE){ $_value = array_add($_value, 'robototrap', 'Roboto Traps (Robots.txt Trapping Mechanism)'); }
		return $_value;
	}

	//----------------------------------------------------------------------//
	//	Shared Functions - Start
	//----------------------------------------------------------------------//

	//----------------------------------------------------------------------//
	//	SettingsSeo Functions - End
	//----------------------------------------------------------------------//
}
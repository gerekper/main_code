<?php namespace Devnull\Main\Models;

use Model, DB, BackendMenu;

class SettingsDisqus extends Model
{
	public $implement               =   ['System.Behaviors.SettingsModel'];
	public $settingsCode            =   'devnull_main_disqus';
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

	//----------------------------------------------------------------------//
	//	SettingsDisqus Functions - End
	//----------------------------------------------------------------------//
}
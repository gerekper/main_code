<?php namespace Devnull\Main\Models;

use Model, Db, BackendMenu;

class SettingsCache extends Model
{
	public $implement               =   ['System.Behaviors.SettingsModel'];
	public $settingsCode            =   'devnull_main_clearcache';
	public $settingsFields          =   'fields.yaml';

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
	
	public function getCacheChartSizeOptions($value, $formData)
	{
		return [
			'100'   =>  ['100', '100'],
			'150'   =>  ['150', '150'],
			'200'   =>  ['200', '200'],
			'250'   =>  ['250', '250'],
			'300'   =>  ['300', '300'],
			'350'   =>  ['350', '350'],
			'400'   =>  ['400', '400'],
			'450'   =>  ['450', '450'],
			'500'   =>  ['500', '500'],
		];
	}

	public function getCacheDashboardWidthOptions($value, $formData)
	{
		return [
			'1'     =>  ['1 Columns', '1 Columns'],
			'2'     =>  ['2 Columns', '2 Columns'],
			'3'     =>  ['3 Columns', '3 Columns'],
			'4'     =>  ['4 Columns', '4 Columns'],
			'5'     =>  ['5 Columns', '5 Columns'],
			'6'     =>  ['6 Columns', '6 Columns'],
			'7'     =>  ['7 Columns', '7 Columns'],
			'8'     =>  ['8 Columns', '8 Columns'],
			'9'     =>  ['9 Columns', '9 Columns'],
			'10'    =>  ['10 Columns', '10 Columns']
		];
	}

	//----------------------------------------------------------------------//
	//	Shared Functions - Start
	//----------------------------------------------------------------------//

	//----------------------------------------------------------------------//
	//	SettingsCookies Functions - End
	//----------------------------------------------------------------------//
}
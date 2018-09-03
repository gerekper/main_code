<?php namespace Devnull\Main\Classes;

use Config, DB, Schema;
use DateTime, DateTimeZone;
use Devnull\Main\Models\Settings;

class InstallMain
{
	public $_table_engine = 'InnoDB';

	//----------------------------------------------------------------------//
	//	Main Functions - Start
	//----------------------------------------------------------------------//

	public function __construct()
	{
		$this->_schema_settings         =   'system_settings';
	}

	//----------------------------------------------------------------------//
	//	Shared Functions - Start
	//----------------------------------------------------------------------//

	public function time_now()
	{
		date_default_timezone_set(date_default_timezone_get());
		return Date('Y-m-d H:i:s', time());
	}

	public function set_date_now()
	{
		$date = new DateTime("now", new DateTimeZone(Config::get('app.timezone')));
		return $date->format('Y-m-d H:i:s');
	}

	public static function check_existing($_table)
	{
		(DB::table($_table)->count() > 0)? DB::table($_table)->truncate() : null;
	}

	public static function remove_table($_table) { Schema::dropIfExists($_table); }

	public static function optimize_table($_table) { DB::statement("OPTIMIZE TABLE `". $_table ."`"); }

	public function optimize_settings() { DB::statement("OPTIMIZE TABLE `". $this->_schema_settings ."`");}

	public static function truncate($_table)
	{
		self::check_existing($_table);
		self::optimize_table($_table);
	}

	public function setSettings($_value)
	{
		if(self::checkSettings() == FALSE)
			DB::Table(Settings::$_table)->insert($_value);
		return 1;
	}

	public function checkSettings($_value)
	{
		$_checkSettings = DB::table(Settings::$_table)->where($_value)->pluck('item');
		return (!$_checkSettings)? false : True;
	}

	public function schema_default() { return $this->_schema = []; }

	//----------------------------------------------------------------------//
	//	Shared Functions - End
	//----------------------------------------------------------------------//

}
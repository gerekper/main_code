<?php namespace Devnull\Main\Models;

use Model;
use Devnull\Main\Classes\InstallMain;
use Devnull\Main\Classes\Seeding;

class HumanConfig extends Model
{
	public $table           =   'gp_main_human_config';
	public static $_table   =   'gp_main_human_config';

	protected $primaryKey   =   'id';
	public $timestamps      =   true;
	public $exists          =   true;
	protected $dates        =   [];
	protected $jsonable     =   [];
	protected $visible      =   [];
	protected $hidden       =   [];

	//----------------------------------------------------------------------//
	//	Validation Values - Start
	//----------------------------------------------------------------------//

	use \October\Rain\Database\Traits\Validation;
	protected $guarded      =   [];
	protected $fillable     =   ['title', 'desc', 'value', 'url', 'status'];
	public $rules           =   [
		'title'     =>  'required|between:1,100',
		'desc'      =>  'required|between:1,255',
		'value'     =>  'required',
		'url'       =>  'between:1,255|url',
		'status'    =>  'required|boolean',
	];

	public $customMessages = [
		'required'  =>  'devnull.main::lang.customMessages.required',
		'boolean'   =>  'devnull.main::lang.customMessages.boolean',
		'url'       =>  'devnull.main::lang.customMessages.url',
	];

	//----------------------------------------------------------------------//
	//	__construct Functions - Start
	//----------------------------------------------------------------------//

	function _construct(){ parent::__construct();}

	//----------------------------------------------------------------------//
	//	Main Functions - Start
	//----------------------------------------------------------------------//

	//----------------------------------------------------------------------//
	//	Overridden Functions - Start
	//----------------------------------------------------------------------//

	//----------------------------------------------------------------------//
	//	Shared Functions - Start
	//----------------------------------------------------------------------//

	public static function getConfig($_value)
	{
		switch($_value)
		{
			case 'robots.txt':
				$_condition = "title = 'robots.txt' AND status = TRUE";
				break;
			case 'humans.txt':
				$_condition = "title = 'humans.txt' AND status = TRUE";
				break;
			default:
				$_condition = "title = '". $_value . "' AND status = TRUE";
				break;
		}
		return HumanConfig::whereRaw($_condition)->pluck('value');
	}

	public static function getURL()
	{
		$_condition = "title = 'robots.txt' AND status = TRUE";
		return HumanConfig::whereRaw($_condition)->pluck('url');
	}

	public static function getPopulate()
	{
		$_condition = "title = 'robots.url' AND status = TRUE";
		return HumanConfig::whereRaw($_condition)->pluck('value');
	}

	public static function getPopulateArray()
	{
		$_value = array(HumanConfig::getPopulate());
		$_fields = array_combine($_value, $_value);
		return $_fields;
	}

	//----------------------------------------------------------------------//
	//	onAjax Functions - Start
	//----------------------------------------------------------------------//

	public static function DoTruncate()
	{
		InstallMain::truncate(HumanConfig::$_table);
		return TRUE;
	}

	public static function DoDefault()
	{
		InstallMain::check_existing(HumanConfig::$_table);

		$_schema_human_config = Seeding::get_schema_human_config();
		foreach ($_schema_human_config as $_schema)
		{
			HumanConfig::updateOrCreate([
				'title' =>  $_schema['title'],
				'desc'  =>  $_schema['desc'],
				'value' =>  $_schema['value'],
				'status'=>  $_schema['status'],
				'url'   =>  $_schema['url']
			]);
		}
		InstallMain::optimize_table(HumanConfig::$_table);
		return TRUE;
	}

	//----------------------------------------------------------------------//
	//	Robot Functions - Ends
	//----------------------------------------------------------------------//
}

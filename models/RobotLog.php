<?php namespace Devnull\Main\Models;

use DB;
use Model;
use Devnull\Main\Classes\InstallMain;

class RobotLog extends Model
{
	public $table           =   'gp_main_robot_log';
	public static $_table   =   'gp_main_robot_log';

	protected $primaryKey   =   'id';
	public $timestamps      =   true;
	public $exists          =   true;
	protected $dates        =   [];
	protected $jsonable     =   [];
	protected $visible      =   [];
	protected $hidden       =   [];
	protected $guarded      =   [];

	public $fillable        =   [
		'useragent', 'addr', 'remote_host', 'remote_port', 'request_method', 'request_time',
		'request_time_flot', 'query_string', 'http_host', 'http_referrer', 'is_robot', 'is_human',
	];

	//----------------------------------------------------------------------//
	//	Validation Functions - Start
	//----------------------------------------------------------------------//

	use \October\Rain\Database\Traits\Validation;
	public $rules           =   [
	/*	'useragent'     =>  'required|between:1,255',
		'addr'          =>  'required|ip',
		'remote_host'   =>  'required|between:1,255|alpha-dash',
		'remote_port'   =>  'required|between:1,255|alpha',
		'request_method'=>  'required|between:1,255|alpha',
		'request_time'  =>  'required',
		'request_time_float'    =>  'required',
		'query_string'  =>  'required|between:1,255|alpha-dash',
		'http_host'     =>  'required|between:1,200|alpha-dash',
		'http_referrer' =>  'required|between:1,200|alpha-dash',
		'is_robot'      =>  'required|boolean',
		'is_human'      =>  'required|boolean' */
	];

	public $customMessages   =   [
		'required'      =>  'devnull.main::lang.customMessages.required',
		'boolean'       =>  'devnull.main::lang.customMessages.boolean',
		'alpha-dash'    =>  'devnull.main::lang.customMessages.alpha_dash',
		'ip'            =>  'devnull.main::lang.customMessages.ip'
	];

	//----------------------------------------------------------------------//
	//	__construct Functions - Start
	//----------------------------------------------------------------------//

	function __construct(){ parent::__construct();}

	//----------------------------------------------------------------------//
	//	Main Functions - Start
	//----------------------------------------------------------------------//

	public static function scopeHuman($query)
	{
		return $query->whereRaw("`is_robot` = '0' AND `is_human` = '1'");
	}

	public static function scopeRobot($query)
	{
		return $query->whereRaw("`is_robot` = '1' AND `is_human` = '0'");
	}

	//----------------------------------------------------------------------//
	//	Overridden Functions - Start
	//----------------------------------------------------------------------//

	//----------------------------------------------------------------------//
	//	Shared Functions - Start
	//----------------------------------------------------------------------//

	public static function countRoboto($_value)
	{
		switch ($_value)
		{
			case 'robots':
				$_search = "`is_robot` = '1' AND `is_human` = '0'";
				$_return = DB::table(Robotolog::$_table)->whereRaw($_search)->count();
				break;
			case 'humans':
				$_search = "`is_robot` = '0' AND `is_human` = '1'";
				$_return = DB::table(RobotoLog::$_table)->whereRaw($_search)->count();
				break;
			case 'all':
			default:
				$_return = self::all()->count();
				break;
		}
		return $_return;
	}

	public static function inputAccess($_value)
	{
		if(!is_array($_value)) { $_return = FALSE;}
		else
		{
			foreach ($_value as $_schema)
			{
				RobotLog::updateOrCreate([
					'useragent'         => $_schema['useragent'],
					'addr'              => $_schema['addr'],
					'remote_host'       => $_schema['remote_host'],
					'remote_port'       => $_schema['remote_port'],
					'request_method'    => $_schema['request_method'],
					'request_time'      => $_schema['request_time'],
					'request_time_float'=> $_schema['request_time_float'],
					'query_string'      => $_schema['query_string'],
					'http_host'         => $_schema['http_host'],
					'http_referrer'     => $_schema['http_referrer'],
					'is_robot'          => $_schema['is_robot'],
					'is_human'          => $_schema['is_human'],
				]);
			}
			$_return = TRUE;
		}
		return $_return;
	}

	public static function getAccess($_value)
	{
		$_return = [
			[   'useragent'          =>  ($_SERVER['HTTP_USER_AGENT'])? $_SERVER['HTTP_USER_AGENT'] : 'unknown',
				'addr'               =>  ip2long($_SERVER['REMOTE_ADDR']),
				'remote_host'        =>  gethostbyaddr($_SERVER['REMOTE_ADDR']),
				'remote_port'        =>  $_SERVER['REMOTE_PORT'],
				'request_method'     =>  $_SERVER['REQUEST_METHOD'],
				'request_time'       =>  $_SERVER['REQUEST_TIME'],
				'request_time_float' =>  $_SERVER['REQUEST_TIME_FLOAT'],
				'query_string'       =>  $_SERVER['QUERY_STRING'],
				'http_host'          =>  $_SERVER['HTTP_HOST'],
				'http_referrer'      =>  strval(isset($_SERVER['HTTP_REFERER'])),
				'is_human'           =>  (($_value == 'humans')? TRUE: FALSE),
				'is_robot'           =>  (($_value == 'robots')? TRUE: FALSE),
			]
		];

		return $_return;
	}

	//----------------------------------------------------------------------//
	//	onAjax Functions - Start
	//----------------------------------------------------------------------//

	public static function DoTruncate()
	{
		$installations = new InstallMain();
		$installations->truncate(RobotLog::$_table);
		return TRUE;
	}

	public static function DoDefault()
	{
		RobotLog::DoTruncate();
	}

	//----------------------------------------------------------------------//
	//	Robot Functions - Ends
	//----------------------------------------------------------------------//
}
<?php namespace Devnull\Main\Models;

use Model;
use Devnull\Main\Classes\Robots;
use Devnull\Main\Classes\InstallMain;
use Devnull\Main\Classes\Seeding;

class Robot extends Model
{
	public $table           =   'gp_main_robot';
	public static $_table   =   'gp_main_robot';

	protected $primaryKey   =   'id';
	public $timestamps      =   true;
	public $exists          =   true;
	protected $dates        =   [];
	protected $jsonable     =   [];
	protected $visible      =   [];
	protected $hidden       =   [];
	protected $guarded      =   [];
	public $fillable        =   ['agent', 'status' ];

	public $hasMany         =   [
		'directives'  => ['Devnull\Main\Models\RobotDirective', 'table' => 'gp_main_robot_directive', 'order' => 'position asc']
	];

	//----------------------------------------------------------------------//
	//	Validation Functions - Start
	//----------------------------------------------------------------------//

	use \October\Rain\Database\Traits\Validation;
	public $rules           =   ['agent' => 'required|between:1,200', 'status' => 'required|boolean'];
	public $customMessages  =   [
		'required'  => 'devnull.main::lang.customMessages.required',
		'between'   => 'devnull.main::lang.customMessages.between'
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

	public function getAgentOptions($fieldName = null, $keyValue = null)
	{
		return RobotAgent::lists('desc', 'nameId');
	}

	//----------------------------------------------------------------------//
	//	Shared Functions - Start
	//----------------------------------------------------------------------//

	public function generateRobots()
	{
		$robots = new Robots();
		$robots->addComment(HumanConfig::getConfig('robots.txt'));
		$robots->addSpacer();
		$robots->addSiteMap(HumanConfig::getURL());
		$robots->addSpacer();

		foreach (Robot::all() as $robot)
		{
			$robots->AddUserAgent($robot->agent);
			foreach ($robot->directives as $directive)
			{
				switch($directive->type)
				{
					case 'Disallow':
						$robots->addDisallow($directive->data);
						break;
					case 'Allow':
						$robots->addAllow($directive->data);
						break;
					default:
						break;
				}
			}
			$robots->addspacer();
		}
		return $robots->generate();
	}

	//----------------------------------------------------------------------//
	//	onAjax Functions - Start
	//----------------------------------------------------------------------//

	public static function DoTruncate()
	{
		$installations = new InstallMain();
		$installations->truncate(Robot::$_table);
		return TRUE;
	}

	public static function DoDefault()
	{
		$installations = new InstallMain();
		$installations->check_existing(Robot::$_table);
		$_schema_robot = Seeding::get_schema_robot();

		foreach ($_schema_robot as $_schema)
		{
			Robot::updateOrCreate([
				'agent'     =>  $_schema['agent'],
				'status'    =>  $_schema['status'],
			]);
		}
		$installations->optimize_table(Robot::$_table);
		return TRUE;
	}

	//----------------------------------------------------------------------//
	//	Robot Functions - Ends
	//----------------------------------------------------------------------//

}

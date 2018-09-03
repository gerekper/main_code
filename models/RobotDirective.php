<?php namespace Devnull\Main\Models;

use Model;
use Devnull\Main\Classes\InstallMain;
use Devnull\Main\Classes\Seeding;

class RobotDirective extends Model
{
	public $table           =   'gp_main_robot_directive';
	public static $_table   =   'gp_main_robot_directive';

	protected $primaryKey   =   'id';
	public $timestamps      =   true;
	public $exists          =   true;
	protected $dates        =   [];
	protected $jsonable     =   [];
	protected $visible      =   [];
	protected $hidden       =   [];
	protected $guarded      =   [];

	public $fillable        =   ['rbt_id', 'position', 'type', 'data'];
	public $belongsTo       =   ['robot' => ['Devnull\Main\Models\Robot', 'table' => 'gp_main_robot_directive']];

	//----------------------------------------------------------------------//
	//	Validation Functions - Start
	//----------------------------------------------------------------------//

	use \October\Rain\Database\Traits\Validation;
	public $rules           =   ['type' => 'required|between:1,100', 'data' => 'required|between:1,100'];
	public $customMessages  =   [
		'required'  =>  'devnull.main::lang.customMessages.required',
		'between'   =>  'devnull.main::lang.customMessages.between'
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

	public function getTypeOptions($fieldName = null, $keyvalue = null)
	{
		return [
			'true'  =>  ['devnull.main::lang.models.allow_label', 'devnull.main::lang.models.allow_description'],
			'false' =>  ['devnull.main::lang.models.disallow_label', 'devnull.main::lang.models.disallow_description']
		];
	}
	//----------------------------------------------------------------------//
	//	Shared Functions - Start
	//----------------------------------------------------------------------//

	//----------------------------------------------------------------------//
	//	onAjax Functions - Start
	//----------------------------------------------------------------------//

	public static function DoTruncate()
	{
		$installations = new InstallMain();
		$installations->trunctate(RobotDirective::$_table);
		return TRUE;
	}

	public static function DoDefault()
	{
		$installations = new InstallMain();
		$installations->check_existing(RobotDirective::$_table);
		$_schema_directive = Seeding::get_schema_robot_directive();

		foreach ($_schema_directive as $_schema)
		{
			RobotDirective::updateOrCreate([
				'robot'     =>  $_schema['robot_id'],
				'position'  =>  $_schema['position'],
				'type'      =>  $_schema['type'],
				'data'      =>  $_schema['data']
			]);
		}
		$installations->optimize_table(RobotDirective::$_table);
		return TRUE;
	}

	//----------------------------------------------------------------------//
	//	Robot Functions - Ends
	//----------------------------------------------------------------------//
}

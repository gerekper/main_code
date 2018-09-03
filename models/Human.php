<?php namespace Devnull\Main\Models;

use Model;
use Devnull\Main\Classes\InstallMain;
use Devnull\Main\Classes\Seeding;
use Devnull\Main\Classes\Humans;

class Human extends Model
{
	public $table           =   'gp_main_human';
	public static $_table   =   'gp_main_human';

	protected $primaryKey   =   'id';
	public $timestamps      =   true;
	public $exists          =   true;
	protected $dates        =   [];
	protected $jsonable     =   [];
	protected $visible      =   [];
	protected $hidden       =   [];
	protected $guarded      =   [];
	public $fillable        =   ['attribution', 'others', 'status'];

	public $hasMany         =   [
		'information'   =>  ['Devnull\Main\Models\HumanInfo', 'table' => 'gp_main_human_info', 'order' => 'position asc']
	];

	//----------------------------------------------------------------------//
	//	Validation Functions - Start
	//----------------------------------------------------------------------//

	use \October\Rain\Database\Traits\Validation;
	public $rules           =   ['attribution' => 'required|between:1,200', 'others' => 'between:0,200', 'status' => 'required|boolean' ];
	public $customMessages  =   [
		'required'  =>  'devnull.main::lang.customMessages.required',
		'between'   =>  'devnull.main::lang.customMessages.between',
		'boolean'   =>  'devnull.main::lang.customMessages.boolean'
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

	public function getAtrributionOptions($fieldName = null, $keyValue = null)
	{
		$human_fields = explode(',', Str::upper(HumanConfig::where('title', 'humans.info')->pluck('value')));
		array_map('trim', $human_fields);
		foreach ($human_fields as $fields) { $_new_fields[] = trim($_fields);}
		$fields = array_combine($_new_fields, $_new_fields);
		return $fields;

	}

	//----------------------------------------------------------------------//
	//	Shared Functions - Start
	//----------------------------------------------------------------------//

	public static function generateHumans()
	{
		$humans = new Humans();
		$humans->addComment(HumanConfig::getConfig('humans.txt'));
		$humans->addSpacer();

		foreach (Human::all() as $human)
		{
			foreach($human->information as $information)
			{
				switch($information->field) {
					case 'Nginx':
					case 'PHP':
					case 'MySQL':
					case 'SQLite':
					case 'FastCGI':
					case 'MemCache':
						$humans->addTechnology($information->field, $information->value);
						break;
					default:
						$humans->addSuperman($information->value, $information->field);
						break;
				}
			}
			$humans->addSpacer();
		}
		$humans->addComment(HumanConfig::getconfig('signature'));
		$humans->addSpacer();
		return $humans->generate();
	}


	//----------------------------------------------------------------------//
	//	onAjax Functions - Start
	//----------------------------------------------------------------------//

	public static function DoTruncate()
	{
		$installations = new InstallMain();
		$installations->truncate(Human::$_table);
		return TRUE;
	}

	public static function DoDefault()
	{
		$installations = new InstallMain();
		$installations->check_existing(Human::$_table);
		$_schema_human = Seeding::get_schema_human();

		foreach ($_schema_human as $_schema)
		{
			Human::updateOrCreate([
				'attribution'   =>  $_schema['attribution'],
				'status'        =>  $_schema['status']
			]);
		}
		$installations->optimize_table(Human::$_table);
		return TRUE;
	}

	//----------------------------------------------------------------------//
	//	Robot Functions - Ends
	//----------------------------------------------------------------------//
}

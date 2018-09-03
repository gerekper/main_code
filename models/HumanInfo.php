<?php namespace Devnull\Main\Models;

use Model;
use Devnull\Main\Classes\InstallMain;
use Devnull\Main\Classes\Seeding;

class HumanInfo extends Model
{
	public $table           =   'gp_main_human_info';
	public static $_table   =   'gp_main_human_info';

	protected $primaryKey   =   'id';
	public $timestamps      =   true;
	public $exists          =   true;
	protected $dates        =   [];
	protected $jsonable     =   [];
	protected $visible      =   [];
	protected $hidden       =   [];
	protected $guarded      =   [];

	public $fillable        =   ['human_id', 'position', 'field', 'value'];
	public $belongsTo       =   ['human' => ['Devnull\Main\Models\Human', 'table' => 'gp_main_human_info']];

	//----------------------------------------------------------------------//
	//	Validation Functions - Start
	//----------------------------------------------------------------------//
	use \October\Rain\Database\Traits\Validation;
	public $rules           =   [
		'human_id'  =>  'required|between:1,100',
		'position'  =>  'required|between:1,100',
		'field'     =>  'required|between:1,200',
		'value'     =>  'required|between:1,200'
	];

	public $customMessages  =   [
		'required'  => 'devnull.main::lang.customMessages.required',
		'between'   => 'devnull.main::lang.customMessages.between',
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

	//----------------------------------------------------------------------//
	//	onAjax Functions - Start
	//----------------------------------------------------------------------//

	public static function DoTruncate()
	{

	}

	public static function DoDefault()
	{

	}

	//----------------------------------------------------------------------//
	//	Robot Functions - Ends
	//----------------------------------------------------------------------//
}

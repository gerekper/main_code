<?php namespace Devnull\Main\Models;

use DB, Form, Model;
use Cms\Classes\Page;
use Devnull\Main\Classes\InstallMain;
use Devnull\Main\Classes\Seeding;

class Meta extends Model
{
	public $table           =   'gp_main_meta';
	public static $_table   =   'gp_main_meta';

	protected $primaryKey   =   'id';
	public $timestamps      =   true;
	public $exists          =   true;
	protected $dates        =   [];
	protected $jsonable     =   [];
	protected $visible      =   [];
	protected $hidden       =   [];
	protected $guarded      =   [];

	//----------------------------------------------------------------------//
	//	validation Functions - Start
	//----------------------------------------------------------------------//

	public $fillable        =   ['page', 'status' ];
	use \October\Rain\Database\Traits\Validation;
	public $rules           =   ['page' => 'required|between:1,100', 'status' => 'required|boolean'];
	public $customMessages  =   [
		'required'  =>  'devnull.main::lang.customMessages.required',
		'boolean'   =>  'devnull.main::lang.customMessages.boolean'
	];

	//----------------------------------------------------------------------//
	//	__construct Functions - Start
	//----------------------------------------------------------------------//

	function _construct() { parent::__construct();}

	//----------------------------------------------------------------------//
	//	Main Functions - Start
	//----------------------------------------------------------------------//

	//----------------------------------------------------------------------//
	//	Overridden Functions - Start
	//----------------------------------------------------------------------//

	public function getDropdownOptions($fieldName = Null, $keyValue = null)
	{
		if ($fieldName == 'page') {return Page::getNameList();}
		else if ($fieldName == 'status') {
			return [
				FALSE => ['devnull.main::lang.models.false_label', 'devnull.main::lang.models.false_description'],
				TRUE  => ['devnull.main::lang.models.true_label', 'devnull.main::lang.models.true_description']
			];
		}
		else { return [ null => ['devnull.main::lang.models.null_label', 'devnull.main::lang.models.null_description']];}
	}

	//----------------------------------------------------------------------//
	//	Shared Functions - Start
	//----------------------------------------------------------------------//

	private static function getID($_value)
	{
		$_getID = Meta::first()->where('page', $_value)->pluck('id');
		return (empty($_getID == TRUE)? $_getID = '1' : $_getID = $_getID);
	}

	public static function generateMeta($_value)
	{
		$_generateID = Meta::getID($_value);
		$_generateMeta = DB::select('SELECT `type`, `property`, `content` from '. MetaDirective::$_table . ' WHERE `meta_id` = '. $_generateID .' AND `status` = 1');

		return $_generateMeta;
	}

	//----------------------------------------------------------------------//
	//	onAjax Functions - Start
	//----------------------------------------------------------------------//

	public static function DoTruncate()
	{
		$installations = new InstallMain();
		$installations->truncate(Meta::$_table);
		return TRUE;
	}

	public static function DoDefault()
	{
		$installations = new InstallMain();
		$installations->check_exiting(Meta::$_table);
		$_schema_meta = Seeding::get_schema_meta();

		foreach ($_schema_meta as $_schema)
		{
			Meta::updateOrCreate([
				'page'      =>  $_schema['page'],
				'status'    =>  $_schema['status']
			]);
		}
		$installations->optimize_table(Meta::$_table);
		return TRUE;
	}

	//----------------------------------------------------------------------//
	//	Directive Functions - Ends
	//----------------------------------------------------------------------//

}
<?php namespace Devnull\Main\Models;

use DB, Model;
use Devnull\Main\Classes\InstallMain;
use Devnull\Main\Classes\Seeding;

class MetaListDirective extends Model
{
	public $table           =   'gp_main_meta_listdirectives';
	public static $_table   =   'gp_main_meta_listdirectives';

	protected $primaryKey   =   'id';
	public $timestamps      =   true;
	public $exists          =   true;
	protected $dates        =   [];
	protected $jsonable     =   [];
	protected $visible      =   [];
	protected $hidden       =   [];

	//use \October\Rain\Database\Traits\Validation;
	public $rules = [

	];

	public $customMessages = [

	];

	//----------------------------------------------------------------------//
	//	__construct Functions - Start
	//----------------------------------------------------------------------//

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
	//	OnAjax Functions - Ends
	//----------------------------------------------------------------------//

	public static function DoTruncate()
	{
		$installations = new InstallMain();
		$installations->truncate(MetaListDirective::$_table);
		return TRUE;
	}

	public static function DoDefault()
	{
		$installations = new InstallMain();
		$installations->check_existing(MetaListDirective::$_table);
		$_schema_ldirective = Seeding::get_schema_meta_ldirective();

		foreach ($_schema_ldirective as $_schema)
		{
			MetaListDirective::updateOrCreate([
				'type'      =>  $_schema['type'],
				'property'  =>  $_schema['property'],
				'content'   =>  $_schema['content'],
				'status'    =>  $_schema['status']
			]);
		}
		$installations->optimize_table(MetaListDirective::$_table);
		return TRUE;
	}

	//----------------------------------------------------------------------//
	//	Directive Functions - Ends
	//----------------------------------------------------------------------//

}

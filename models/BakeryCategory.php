<?php namespace Devnull\Main\Models;

use DB, Model;
use Devnull\Main\Classes\InstallMain;
use Devnull\Main\Classes\Seeding;

class BakeryCategory extends Model
{
	public $table           =   'gp_bakery_category';
	public static $_table   =   'gp_bakery_category';

	public $exists          =   true;
	public $timestamps      =   true;
	protected $primaryKey   =   'id';
	protected $jsonable     =   [];
	protected $guarded      =   [];
	protected $hidden       =   [];
	protected $visible      =   [];
	protected $fillable     =   ['position', 'category', 'status'];

	public $hasMany         =   ['category' => ['Devnull\Main\Models\Bakery', 'table' => 'gp_bakery_bakery']];

	use \October\Rain\Database\Traits\Validation;
	public $rules   = [

	];

	public $customMessages = [

	];

	//----------------------------------------------------------------------//
	//	__construct Functions - Start
	//----------------------------------------------------------------------//

	function __construct() {}

	//----------------------------------------------------------------------//
	//	Main Functions - Start
	//----------------------------------------------------------------------//

	//----------------------------------------------------------------------//
	//	Overridden Functions - Start
	//----------------------------------------------------------------------//

	public static function getAll($_value = true, $_limit)
	{
		return DB::table(BakeryCategory::$_table)->where('status', '=', $_value)->take($_limit * 6)-get();
	}

	public static function countAll($_value = true, $_limit)
	{
		return DB::table(BakeryCategory::$_table)->where('status', '=', $_value)->take($_limit *6)->count();
	}

	//----------------------------------------------------------------------//
	//	OnAjax Functions - Start
	//----------------------------------------------------------------------//

	public static function DoTruncate()
	{
		$installations = new InstallMain();
		$installations->truncate(BakeryCategory::$_table);
		return TRUE;
	}

	public static function DoDefault()
	{
		$installations = new InstallMain();
		$installations->check_existing(BakeryCategory::$_table);

		$_schema_categories = Seeding::get_schema_bakery_category();
		foreach ($_schema_categories as $_schema)
		{
			BakeryCategory::updateOrCreate([
				'category'      =>  $_schema['category'],
				'position'      =>  $_schema['position'],
				'alt'           =>  $_schema['alt'],
				'url'           =>  $_schema['url'],
				'target'        =>  $_schema['target'],
				'status'        =>  $_schema['status']
			]);
		}
		$installations->optimize_table(BakeryCategory::$_table);
		return TRUE;
	}

	//----------------------------------------------------------------------//
	//	BakeryCategory Functions - Ends
	//----------------------------------------------------------------------//
}
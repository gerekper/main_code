<?php namespace Devnull\Main\Models;

use DB, Model;
use Devnull\Main\Classes\InstallMain;
use Devnull\Main\Classes\Seeding;

class Bakery extends Model
{
	public $table           =   'gp_bakery_bakery';
	public static $_table   =   'gp_bakery_bakery';

	public $exists          =   true;
	public $timestamps      =   true;
	protected $primaryKey   =   'id';
	protected $jsonable     =   [];
	protected $guarded      =   [];
	protected $hidden       =   [];
	protected $visible      =   [];
	protected $fillable     =   ['categories_id'];

	public $belongsTo       =   ['category' => ['Devnull\Main\Models\BakeryCategory', 'table' => 'gp_bakery_category']];

	use \October\Rain\Database\Traits\Validation;
	public $rules = [
		'categories_id'     =>  'required|numeric'
	];
	public $customMessages  =   [
		'categories_id.required'    =>  'devnull.main::lang.bakery_categories_id_required',

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

	public function getTypeOptions($fieldName = null, $keyValue = null)
	{
		return ['Allow' => 'Allow', 'Disallow' => 'Disallow'];
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
		$installations->truncate(Bakery::$_table);
		return TRUE;
	}

	public static function DoDefault()
	{
		$installations = new InstallMain();
		$installations->check_existing(Bakery::$_table);
		$_schema_bakery = Seeding::get_schema_bakery();

		foreach ($_schema_bakery as $_schema)
		{
			Bakery::updateOrCreate([
				'categories_id'     =>  $_schema['categories_id'],
				'description'       =>  $_schema['description'],
				'quantity'          =>  $_schema['quantity'],
				'price'             =>  $_schema['price'],
				'discount'          =>  $_schema['discount'],
				'delivery_charge'   =>  $_schema['delivery_charge'],
				'location'          =>  $_schema['location'],
				'status'            =>  $_schema['status'],
				'self_collect'      =>  $_schema['self_collect'],
				'time_from'         =>  $_schema['time_from'],
				'time_to'           =>  $_schema['time_to'],
				'company_id'        =>  $_schema['company_id'],
				'dimension1'        =>  $_schema['dimension1'],
				'dimension2'        =>  $_schema['dimension2'],
				'weight'            =>  $_schema['weight']
			]);
		}

		$installations->optimize_table(Bakery::$_table);
		return TRUE;

	}

	//----------------------------------------------------------------------//
	//	Directive Functions - Ends
	//----------------------------------------------------------------------//

}

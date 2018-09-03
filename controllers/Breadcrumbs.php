<?php namespace Devnull\Main\Controllers;

use DB, Flash, Lang, Backend, BackendMenu;
use Backend\Classes\Controller;
use Devnull\Main\Models\Breadcrumb;

class Breadcrumbs extends Controller
{
	public $implement   = '';
	public $formConfig  = '';
	public $listConfig  = '';

	//----------------------------------------------------------------------//
	//	__construct Functions - Start
	//----------------------------------------------------------------------//

	public function __construct()
	{
		parent::__construct();
	}

	//----------------------------------------------------------------------//
	//	Override Functions - Start
	//----------------------------------------------------------------------//

	public function index(){}

	//----------------------------------------------------------------------//
	//	Shared Functions - End
	//----------------------------------------------------------------------//

	//----------------------------------------------------------------------//
	//	OnAjax Functions - End
	//----------------------------------------------------------------------//

	public function onDoTruncate()
	{
		if (Breadcrumb::DoTruncate() == TRUE)
			Flash::Success(Lang::get('devnull.main::lang.main.truncate_process'));
		else
			FLash::Warning(Lang::get('devnull.main::lang.main.truncate_failed'));

		return true ; // return to admin; TODO:
	}

	public function onDoDefault()
	{
		if (Breadcrumb::DoDefault() == TRUE)
			Flash::Success(Lang::get('devnull.main::lang.main.default_success'));
		else
			Flash::Warning(Lang::get('devnull.main::lang.main.default_failed'));

		return true; // return to admin :TODO:
	}

	//----------------------------------------------------------------------//
	//	BreadCrumbs Controller - End
	//----------------------------------------------------------------------//
}
<?php namespace Devnull\Main\Components;

use Devnull\Main\Models\Settings;
use Cms\Classes\ComponentBase;
use Illuminate\Support\Facades\Request;

class LogoFav extends ComponentBase
{
	//----------------------------------------------------------------------//
	//	__construct Functions - Start
	//----------------------------------------------------------------------//

	//----------------------------------------------------------------------//
	//	Main Functions - Start
	//----------------------------------------------------------------------//

	public function componentDetails()
	{
		return [
			'name'          =>  'devnull.main::lang.components.logo_name',
			'description'   =>  'devnull.main::lang.components.logo_description',
		];
	}

	public function onRun()
	{
		$this->page['use_plugin_logo']      =   Settings::get('use_plugin_logo');
		$this->page['domain']               =   Request::root();
	}

	public function init(){}
	public function onInit(){}
	public function onStart(){}
	public function onBeforePageStart(){}
	public function onEnd(){}
	protected function loadItem() {}

	//----------------------------------------------------------------------//
	//	Breadcrumbs Functions - End
	//----------------------------------------------------------------------//
}

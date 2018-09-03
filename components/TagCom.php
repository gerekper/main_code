<?php namespace Devnull\Main\Components;

use Cms\Classes\ComponentBase;
use Devnull\Main\Models\SettingsTagm;

class TagCom extends ComponentBase
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
			'name'          =>  'devnull.main::lang.components.tagmanager_tracker',
			'description'   =>  'devnull.main::lang.components.tagmanager_description'
		];
	}
	//----------------------------------------------------------------------//
	//	Overridden Functions - Start
	//----------------------------------------------------------------------//

	//----------------------------------------------------------------------//
	//	Shared Functions - Start
	//----------------------------------------------------------------------//

	public function trackingID() { return Settings::get('tracking_id');}

	public function domainName() { return Settings::get('domain_name');}

	//----------------------------------------------------------------------//
	//	Directive Functions - Ends
	//----------------------------------------------------------------------//

}

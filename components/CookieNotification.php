<?php namespace Devnull\Main\Components;

use Cms\Classes\ComponentBase;
use Devnull\Main\Models\SettingsCookies;

class CookieNotification extends ComponentBase
{

	//----------------------------------------------------------------------//
	//	Construct Functions - Start
	//----------------------------------------------------------------------//

	function __construct() {}

	//----------------------------------------------------------------------//
	//	Main Functions - Start
	//----------------------------------------------------------------------//

	public function componentDetails()
	{
		return [
			'name'          =>  'devnull.main::lang.settings.cookieNotification_name',
			'description'   =>  'devnull.main::lang.settings.cookieNotification_description',
		];
	}

	public function onRun()
	{
		$this->page['use_plugin_cookies']   =   SettingsCookies::get('cookies_use_plugin');
		$this->page['use_popup']            =   SettingsCookies::get('cookies_use_popup');
		$this->page['data_position']        =   CookieNotification::chooseDataPosition(Setting::get('cookies_use_which'), Setting::get('cookies_use_vertical'), Setting::get('cookies_use_horizontal'));
		$this->page['use_text']             =   SettingsCookies::get('cookies_use_text');
		$this->page['use_text_more']        =   SettingsCookies::get('cookies_use_text_more');
		$this->page['use_which']            =   SettingsCookies::get('cookies_use_which');
		$this->page['use_frontpage']        =   SettingsCookies::get('cookies_use_frontpage');
	}

	public function defineProperties(){ return [];}
	protected function loadItem(){}
	public function init(){}
	public function onInit(){}
	public function onStart(){}
	public function onBeforePageStart(){}
	public function onEnd(){}

	//----------------------------------------------------------------------//
	//	CookieNotifactions Functions - End
	//----------------------------------------------------------------------//
}
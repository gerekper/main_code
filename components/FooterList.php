<?php namespace Devnull\Main\Components;

use Cms\Classes\ComponentBase;
use Devnull\Main\Models\BakeryCategory;
use Devnull\Main\Models\Settings;
use Devnull\Main\Models\SettingsFooter;

class FooterList extends ComponentBase
{
	//----------------------------------------------------------------------//
	//	__construct Functions - Start
	//----------------------------------------------------------------------//

	function __construct() {}

	//----------------------------------------------------------------------//
	//	Main Functions - Start
	//----------------------------------------------------------------------//

	public function componentDetails()
	{
		return [
			'name'          =>  'devnull.main::lang.settings_footer.footerList_name',
			'description'   =>  'devnull.main::lang.settings_footer.footerList_description',
		];
	}

	public function defineProperties()
	{
		return [
			'columnLimit' => [
				'title'             =>  'devnull.main::lang.components_footerList_title',
				'description'       =>  'devnull.main::lang.components_footerList_description',
				'default'           =>  SettingsFooter::get('footer_list'),
				'type'              =>  'string',
				'validationPattern' =>  '^[0-9]+$',
				'validationMessage' =>  'devnull.main::lang.components_footerList_validationMessage'
			]
		];
	}

	protected function loadItem(){}

	public function onRun()
	{
		$this->page['footer_list']              =   BakeryCategory::getAll(TRUE, SettingsFooter::get('footer_list'));
		$this->page['shownList']                =   count($this->page['footerList']);
		$this->page['totalList']                =   BakeryCategory::countAll(TRUE, SettingsFooter::get('footer)list'));
		$this->page['columnList']               =   SettingsFooter::get('footer_list');
		$this->page['use_plugin_footer']        =   SettingsFooter::get('use_plugin_footer');
		$this->page['use_footerList_page']      =   SettingsFooter::get('use_footerList_page');
		$this->page['use_footerList_list']      =   SettingsFooter::get('use_footerList_list');
		$this->page['use_footerList_links']     =   SettingsFooter::get('use_footerList_links');
		$this->page['use_footerList_connect']   =   SettingsFooter::get('use_footerList_connect');
		$this->page['use_footerList_subscribe'] =   SettingsFooter::get('use_footerList_subscribe');
	}

	public function init(){}
	public function onInit(){}
	public function onStart(){}
	public function onBeforePageStart(){}
	public function onEnd(){}

	//----------------------------------------------------------------------//
	//	FooterList Functions - End
	//----------------------------------------------------------------------//


	//----------------------------------------------------------------------//
	//	Overridden Functions - Start
	//----------------------------------------------------------------------//

	//----------------------------------------------------------------------//
	//	Shared Functions - Start
	//----------------------------------------------------------------------//

	//----------------------------------------------------------------------//
	//	Directive Functions - Ends
	//----------------------------------------------------------------------//

}

<?php namespace Devnull\Main\Components;

use Cms\Classes\ComponentBase;
use Devnull\Main\Models\Meta;
use Devnull\Main\Models\SettingsMeta;
use Illuminate\Support\Facades\Request;

class MetaCom extends ComponentBase
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
			'name'          =>  'devnull.main::lang.components.meta_components_name',
			'description'   =>  'devnull.main::lang.components.meta_components_description'
		];
	}

	public function onRun()
	{
		$this->page['use_plugin_meta']   =   SettingsMeta::get('use_plugin_meta');
		$this->page['use_meta_html']     =   SettingsMeta::get('use_meta_html');
		$this->page['use_meta_twi']      =   SettingsMeta::get('use_meta_twi');
		$this->page['use_meta_fb']       =   SettingsMeta::get('use_meta_fb');
		$this->page['use_meta_app']      =   SettingsMeta::get('use_meta_app');
		$this->page['use_meta_api']      =   SettingsMeta::get('use_meta_api');
		$this->page['metas']             =   Meta::first()->generateMeta($this->page->baseFileName);
	}

	public function init(){}
	public function onInit(){}
	public function onStart(){}
	public function onBeforePageStart(){}
	public function onEnd(){}
	protected function loadItem() {}

	//----------------------------------------------------------------------//
	//	Meta Functions - End
	//----------------------------------------------------------------------//

}
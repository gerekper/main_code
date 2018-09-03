<?php namespace Devnull\Main\Components;

use Cms\Classes\ComponentBase;
use Devnull\Main\Models\SettingsDisqus;

class Disqus extends ComponentBase
{
	//----------------------------------------------------------------------//
	//	Main Functions - Start
	//----------------------------------------------------------------------//

	public function componentDetails()
	{
		return [
			'disqus' => [
				'title'             =>  'devnull.main::lang.components.disqus_title',
				'description'       =>  'devnull.main::lang.components.disqus_description',
				'default'           =>  SettingsDisqus::get('disquskey'),
				'type'              =>  'string',
				'validationPattern' =>  '^[0-9]+$',
				'validationMessage' =>  'devnull.main::lang.components.disqus_validationMessage',
				'required'          =>  true,
				'placeholder'       =>  'devnull.main::lang.components.disqus_placeholder',
				'options'           =>  '',
				'depends'           =>  '',
				'group'             =>  '',
				'showExternalParam' =>  '',
			],
		];
	}

	public function defineProperties(){}

	public function onRun()
	{
		$this->page['disqus']               = SettingsDisqus::get('disquskey');
		$this->page['disqus_url']           = '';
		$this->page['disqus_identifier']    = '';
	}

	public function init(){}
	public function onInit(){}
	public function onStart(){}
	public function onBeforePageStart(){}
	public function onEnd(){}
	protected function loadItem() {}

	//----------------------------------------------------------------------//
	//	Disqus Functions - End
	//----------------------------------------------------------------------//
}
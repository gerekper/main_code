<?php namespace Devnull\Main\Components;

use Devnull\Main\Models\Settings;
use App, DB, Lang, Request;
use Devnull\Main\Models\Menu as menuModel;

class SideBar Extends Componentbase
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
			'name'          =>  'devnull.main::lang.components.sidebar_name',
			'description'   =>  'devnull.main::lang.components.sidebar_description'
		];
	}

	public function defineProperties()
	{
		return [
			'start'         =>  [
				'description'   =>  'devnull.main::lang.components.sidebar_start_description',
				'title'         =>  'devnull.main::lang.components.sidebar_start_title',
				'default'       =>  1,
				'type'          =>  'dropdown'
			],
			'activeNode'        =>  [
				'description'   =>  'devnull.main::lang.components.sidebar_activeNode_description',
				'title'         =>  'devnull.main::lang.components.sidebar_activeNode_title',
				'default'       =>  0,
				'type'          =>  'dropdown'
			],
			'listItemClasses'   =>  [
				'description'   =>  'devnull.main::lang.components.sidebar_listItemClasses_description',
				'title'         =>  'devnull.main::lang.components.sidebar_listItemClasses_title',
				'default'       =>  'item',
				'type'          =>  'string'
			],
			'primaryClasses'    =>  [
				'description'   =>  'devnull.main::lang.components.sidebar_primaryClasses_description',
				'title'         =>  'devnull.main::lang.components.sidebar_primaryClasses_title',
				'default'       =>  'nav nav-pills',
				'type'          =>  'string'
			],
			'secondaryClasses'  =>  [
				'description'   =>  'devnull.main::lang.components.sidebar_tertiaryClasses_description',
				'title'         =>  'devnull.main::lang.components.sidebar_tertiaryClasses_title',
				'default'       =>  'dropdown-menu',
				'type'          =>  'string'
			],
			'tertiaryClasses'   =>  [
				'description'   =>  'devnull.main::lang.components.sidebar_tertiaryClasses_description',
				'title'         =>  'devnull.main::lang.components.sidebar_tertiaryClasses_title',
				'default'       =>  '',
				'type'          =>  'string'
			],
			'numberofLevels'    =>  [
				'description'   =>  'devnull.main::lang.components.sidebar_numberOfLevels_description',
				'title'         =>  'devnull.main::lang.components.sidebar_numberOfLevels_title',
				'default'       =>  '2',
				'type'          =>  'dropdown',
				'options'       =>  [1 => '1', 2 => '2', 3 => '3']
			],

		];
	}

	public function getActiveNodeOptions()
	{
		$_options = $this->getStartOptions();
		array_unshift($_options, 'default');
		return $_options;
	}

	public function getStartOptions()
	{
		$_menuModel = new menuModel();
		return $_menuMOdel->getSelectList();
	}

	public function onRender()
	{
		$_topNode = menuModel::find($this->getIdFromProperty($this->property('start')));
		$this->page['parentNode'] = $_topNode;








	}

	protected function getIdFromProperty($_value)
	{
		if (!strlen($_value) > 3){ return false; }
		return substr($_value, 3);
	}

	public function onRun()
	{
		$this->page['domain']           =   Request::root();
	}

	public function init(){}
	public function onInit(){}
	public function onStart(){}
	public function onBeforePageStart(){}
	public function onEnd(){}
	protected function loadItem() {}

	//----------------------------------------------------------------------//
	//	Sidebar Functions - End
	//----------------------------------------------------------------------//
}

<?php namespace Devnull\Main\Components;

use App, DB, Lang, Request;
use Cms\Classes\ComponentBase;
use Devnull\Main\Models\Menu as menuModel;

class Menu extends ComponentBase
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
			'name'          =>  'devnull.main::lang.components.menu_name',
			'description'   =>  'devnull.main::lang.components.menu_description'
		];
	}

	public function defineProperties()
	{
		return [
			'start'            => [
				'description' => 'devnull.main::lang.components.start_description',
				'title'       => 'devnull.main::lang.components.start_title',
				'default'     => 1,
				'type'        => 'dropdown'
			],
			'activeNode'       => [
				'description' => 'devnull.main::lang.components.activeNode_description',
				'title'       => 'devnull.main::lang.components.activeNode_title',
				'default'     => 0,
				'type'        => 'dropdown'
			],
			'listItemClasses'  => [
				'description' => 'devnull.main::lang.components.listItemClasses_description',
				'title'       => 'devnull.main::lang.components.listItemClasses_title',
				'default'     => 'item',
				'type'        => 'string'
			],
			'primaryClasses'   => [
				'description' => 'devnull.main::lang.components.primaryClasses_description',
				'title'       => 'devnull.main::lang.components.primaryClasses_title',
				'default'     => 'nav nav-pills',
				'type'        => 'string'
			],
			'secondaryClasses' => [
				'description' => 'devnull.main::lang.components.secondaryClasses_description',
				'title'       => 'devnull.main::lang.components.secondaryClasses_title',
				'default'     => 'dropdown-menu',
				'type'        => 'string'
			],
			'tertiaryClasses'  => [
				'description' => 'devnull.main::lang.components.tertiaryClasses_description',
				'title'       => 'devnull.main::lang.components.tertiaryClasses_titles',
				'default'     => '',
				'type'        => 'string'
			],
			'numberOfLevels'   => [
				'description' => 'devnull.main::lang.components.numberOfLevels_description',
				'title'       => 'devnull.main::lang.components.numberOfLevels_title',
				'default'     => '2', // This is the array key, not the value itself
				'type'        => 'dropdown',
				'options'     => [ 1 => '1', 2 => '2',3 => '3']
			]
		];
	}
	//----------------------------------------------------------------------//
	//	Overridden Functions - Start
	//----------------------------------------------------------------------//

	//----------------------------------------------------------------------//
	//	Shared Functions - Start
	//----------------------------------------------------------------------//

	public function getActiveNodeOptions()
	{
		$_options = $this->getStartOptions();
		array_unshift($_options, 'default');
		return $_options;
	}

	public function getStartOptions()
	{
		$menuModel = new menuModel();
		return $menuModel->getSelectList();
	}

	public function onRender()
	{
		$topNode = menuMode::find($this->getIdFromProperty($this->property('start')));
		$this->page['parentNode'] = $topNode;

		$this->page['activeLeft']   =   0;
		$this->page['activeRight']  =   0;

		$activeNode = $this->getIdFromProperty($this->property('activeNode'));

		if ($activeNode) {

			// It's been set by the user, so use what they've set it as
			$activeNode = menuModel::find($activeNode);
		} elseif ($topNode) {


			$baseFileName = $this->page->page->getBaseFileName();

			$params = $this->page->controller->getRouter()->getParameters();

			$activeNode = menuModel::where('url', $baseFileName)
				->where('nest_left', '>', $topNode->nest_left)
				->where('nest_right', '<', $topNode->nest_right);

			$activeNode = $activeNode->first();
		}

		// If I've got a result that is a node
		if ($activeNode && menuModel::getClassName() === get_class($activeNode)) {
			$this->page['activeLeft'] = (int)$activeNode->nest_left;
			$this->page['activeRight'] = (int)$activeNode->nest_right;
		}

		// How deep do we want to go?
		$this->page['numberOfLevels'] = (int)$this->property('numberOfLevels');

		// Add the classes to the view
		$this->page['primaryClasses'] = $this->property('primaryClasses');
		$this->page['secondaryClasses'] = $this->property('secondaryClasses');
		$this->page['tertiaryClasses'] = $this->property('tertiaryClasses');
		$this->page['listItemClasses'] = $this->property('listItemClasses');
	}

	protected function getIdFromProperty($value)
	{
		if (!strlen($value) > 3) { return falsel }
		return substr($value, 3);
	}

	public function init(){}
	public function onInit(){}
	public function onStart(){}
	public function onBeforePageStart(){}
	public function onEnd(){}
	protected function loadItem() {}

	//----------------------------------------------------------------------//
	//	Menu Functions - End
	//----------------------------------------------------------------------//
}
<?php namespace Devnull\Main\Controllers;

use BackendMenu;
Use Backend\Classes\Controller;
use Devnull\Main\Models\Menu;
use Illuminate\Support\Facades\Input;
use Lang;

class Menus extends Controller
{
	public $implement = ['Backend.Behaviors.FormController', 'Backend.Behaviors.ListController'];

	public $formConfig = 'config_form.yaml';
	public $listConfig = 'config_list.yaml';

	public $requiredPermissions = ['devnull.main.access_menu'];

	//----------------------------------------------------------------------//
	//	__construct Functions - Start
	//----------------------------------------------------------------------//

	public function __construct()
	{
		parent::__construct();
		BackendMenu::setContext('Devnull.Main', 'menu', 'edit');

		$this->addJs('/plugins/devnull/main/controllers/menus/assets/js/menu.js');
	}

	//----------------------------------------------------------------------//
	//	Main Functions - Start
	//----------------------------------------------------------------------//

	//----------------------------------------------------------------------//
	//	Overridden Functions - Start
	//----------------------------------------------------------------------//

	//----------------------------------------------------------------------//
	//	Shared Functions - Start
	//----------------------------------------------------------------------//

	public function formExtendFields($host)
	{
        $allFields = $host->getFields();
		switch($allFields['is_external']->value)
		{
			case 0:
				$allFields['internal_url']->value = $allFields['url']->value;
				break;
			case 1:
				$allFields['external_url']->value = $allFields['url']->value;
				break;
			default:
				break;
		}
	}

	public function reorder()
	{
		BackendMenu::setContext('Devnull.Main', 'menu', 'reorder');
		$this->pageTitle = Lang::get('devnull.main::lang.controller.menu_reorder');

		$toolbarConfig = $this->makeConfig();
		$toolbarConfig->buttons = '$/devnull/main/controllers/menus/_reorder_toolbar.htm';
		$this->vars['toolbar'] = $this->makeWidget('Backend\Widgets\Toolbar', $toolbarConfig);
		$this->vars['records'] = Menu::make()->getEagerRoot();
	}

	public function reorder_onMove()
	{
		$sourceNode = Menu::find(post('sourceNode'));
		$targetNode = post('targetNode') ? Menu::find(post('targetNode')) : null;

		if($sourceNode == $targetNode) { return ;}

		switch (post('position'))
		{
			case 'before':
				$sourceNode->moveBefore($targetNode);
				break;
			case 'after':
				$sourceNode->moveAfter($targetNode);
				break;
			case 'child':
				$sourceNode->makeChildof($targetNode);
				break;
			default:
				$sourceNode->makeRoot();
				break;
		}
	}

	//----------------------------------------------------------------------//
	//	onAjax Functions - Start
	//----------------------------------------------------------------------//

	//----------------------------------------------------------------------//
	//	Menus Functions - Ends
	//----------------------------------------------------------------------//

}
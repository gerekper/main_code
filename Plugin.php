<?php namespace Devnull\Main;

use App;
use System\Classes\PluginBase;

/**                _                             _
__ _  ___ _ __ ___| | ___ __   ___ _ __ __ _ ___(_) __ _
/ _` |/ _ \ '__/ _ \ |/ / '_ \ / _ \ '__/ _` / __| |/ _` |
| (_| |  __/ | |  __/   <| |_) |  __/ | | (_| \__ \ | (_| |
\__, |\___|_|  \___|_|\_\ .__/ \___|_|(_)__,_|___/_|\__,_|
|___/                   |_|

 * This is a gerekper.main[main] for OctoberCMS
 *
 * @category   Gerekper+ Addons | Main Plugin File
 * @package    Devnull.Main | Octobercms
 * @author     devnull <www.gerekper.asia>
 * @copyright  2012-2016 Gerekper Inc
 * @license    http://www.gerekper.asia/license/modules.txt
 * @version    1.0.0
 * @link       http://www.gerekper.asia/package/helpers
 * @see        http://www.github.com/gerekper
 * @since      File available since Release 1.0.0
 * @deprecated -
 */

class Plugin Extends PluginBase
{
	//----------------------------------------------------------------------//
	//	Construct Functions - Start
	//----------------------------------------------------------------------//

	function __construct()
	{
		$this->code         = 'devnull.main';
	}

	//----------------------------------------------------------------------//
	//	Main Functions - Start
	//----------------------------------------------------------------------//

	public function pluginDetails()
	{
		return [
			'name'          =>  'devnull.main::lang.plugin.name',
			'description'   =>  'devnull.main::lang.plugin.description',
			'author'        =>  'devnull.main::lang.plugin.author',
			'icon'          =>  'icon-bomb',
			'homepage'      =>  'devnull.main::lang.plugin.homepage'
		];
	}

	public function register()
	{

	}

	public function registerNavigation()
	{

	}

	public function registerSettings()
	{

	}

	public function registerComponents()
	{
		return [
			//'Devnull\Main\Components\Disqus'                =>  'disqus',
			//'Devnull\Main\Components\DisqusComments'        =>  'disquscomments',
			'Devnull\Main\Components\Breadcrumbs'           =>  'Breadcrumbs',
			'Devnull\Main\Components\LogoFav'               =>  'Logo',
			'Devnull\Main\Components\MetaCom'               =>  'MetaCom',
			'Devnull\Main\Components\Menu'                  =>  'Menu',
			//'Devnull\Main\Components\CookieNotification'    =>  'cookieNotification',
			//'Devnull\Main\Components\FooterList'            =>  'footerList',
		];
	}

	public function registerPermissions()
	{
	}

	public function registerSchedule($schedule)
	{
		$schedule->command('cache:clear')->everyFiveMinutes();
	}

	public function registerFormWidgets()
	{

	}

	public function registerReportWidgets()
	{

	}

	public function registerMarkupTags()
	{

	}

	public function boot()
	{
	}

	public function registerListColumnTypes(){}
	public function registerMailTemplates(){}

	//----------------------------------------------------------------------//
	//	Plugin Functions - end
	//----------------------------------------------------------------------//
}
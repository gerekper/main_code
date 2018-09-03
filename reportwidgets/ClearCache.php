<?php namespace Devnull\Main\ReportWidgets;

use Backend\Classes\ReportWidgetBase;
use Artisan;
use Flash;
use Lang;
use Devnull\Main\Models\SettingsCache;

class ClearCache extends ReportWidgetBase
{
	protected $defaultAlias = 'devnull_main_clearcache';

	//----------------------------------------------------------------------//
	//	Define Properties Functions - Start
	//----------------------------------------------------------------------//

	public function defineProperties()
	{
		return [
			'title' => [
				'title'             =>  'backend::lang.dashboard.widget_title_label',
				'default'           =>  'devnull.main::lang.reportWidgets.cache_widget_label',
				'type'              =>  'string',
				'validationPattern' =>  '^.+$',
				'validationMessage' =>  'backend::lang.dashboard.widget_title_error'
			],
			'nochart' => [
				'title'             =>  'devnull.main::lang.reportWidgets.cache_nochart',
				'type'              =>  'checkbox',
				'default'           =>  SettingsCache::get('cache_chart_nochart')
			],
			'radius' => [
				'title'             =>  'devnull.main::lang.reportWidgets.cache_radius',
				'type'              =>  'string',
				'validationPattern' =>  '^[0-9]+$',
				'validationMessage' =>  'Only numbers!',
				'default'           =>  SettingsCache::get('cache_chart_size')
			],
			'delthumbs' => [
				'title'             =>  'devnull.main::lang.reportWidgets.cache_delthumbs',
				'type'              =>  'checkbox',
				'default'           =>  SettingsCache::get('cache_delete_thumbs')
			],
			'thumbspath' => [
				'title'             => 'devnull.main::lang.reportWidgets.cache_thumbs_path',
				'type'              => 'string',
				'default'           =>  SettingsCache::get('thumbnails_path'),
			],
			'thumb_regex' => [
				'title'             => 'devnull.main:;lang.reportWidgets.cache_thumbs_regex',
				'type'              => 'string',
				'default'           =>  '/^thumb_\w+_crop.*/'
			]
		];
	}

	//----------------------------------------------------------------------//
	//	Main Functions - Start
	//----------------------------------------------------------------------//

	public function render(){
		$this->vars['size'] = $this->getSizes();
		$this->vars['radius'] = $this->property("radius");
		$widget = ($this->property("nochart"))? 'widget2' : 'widget';
		return $this->makePartial($widget);
	}

	public function onClear()
	{
		Artisan::call('cache:clear');
		if ($this->property("delthumbs")) { $this->delThumbs(); }

		Flash::success(Lang::get('devnull.main::lang.reportWidgets.cache_clear_success'));
		$widget = ($this->property("nochart"))? 'widget2' : 'widget';
		return ['partial' => $this->makePartial($widget, ['size'   => $this->getSizes(), 'radius' => $this->property("radius")])];
	}

	//----------------------------------------------------------------------//
	//	Shared Functions - Start
	//----------------------------------------------------------------------//

	private function getDirSize($directory)
	{
		if(!file_exists($directory) || count(scandir($directory)) <= 2) { return 0; }
		$_size = 0;
		foreach (new \RecursiveDirectoryIterator(new \RecursiveDirectoryIterator($directory)) as $file) { $_size += $file->getSize(); }
		return $_size;
	}

	private function formatSize($size)
	{
		$_mod = 1024;
		$units = explode(' ','B KB MB GB TB PB');
		for ($i = 0; $size > $_mod; $i++) {
			$size /= $_mod;
		}
		return round($size, 2) . ' ' . $units[$i];
	}

	private function getSizes(){

		$_size['ccache_b']    = $this->getDirSize(storage_path() . SettingsCache::get('cms_cache_path'));
		$_size['ccache']      = $this->formatSize($_size['ccache_b']);
		$_size['ccombiner_b'] = $this->getDirSize(storage_path() . SettingsCache::get('cms_combiner_path'));
		$_size['ccombiner']   = $this->formatSize($_size['ccombiner_b']);
		$_size['ctwig_b']     = $this->getDirSize(storage_path() . SettingsCache::get('cms_twig_path'));
		$_size['ctwig']       = $this->formatSize($_size['ctwig_b']);
		$_size['fcache_b']    = $this->getDirSize(storage_path() . SettingsCache::get('framework_cache_path'));
		$_size['fcache']      = $this->formatSize($_size['fcache_b']);
		$_size['all']         = $this->formatSize($_size['ccache_b'] + $_size['ccombiner_b'] + $_size['ctwig_b'] + $_size['fcache_b']);

		return $_size;
	}

	private function delThumbs(){
		$thumbs = array();
		$path = storage_path();
		$path .= $this->property('thumbspath') ?: SettingsCache::get('thumbnails_path');
		$iterator = new \RecursiveDirectoryIterator($path);
		$regex = $this->property('thumb_regex');

		foreach (new \RecursiveIteratorIterator($iterator) as $file)
		{
			if (preg_match($regex, $file->getFilename())) { $thumbs[] = $file->getRealPath(); }
		}
		foreach ($thumbs as $img) { unlink($img); }
	}
    //----------------------------------------------------------------------//
	//	Overridden Functions - Start
	//----------------------------------------------------------------------//

	//----------------------------------------------------------------------//
	//	ClearCache ReportWidget Functions - End
	//----------------------------------------------------------------------//
}

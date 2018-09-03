<?php namespace Devnull\Main\Classes;

use DB;

class Metas
{
	protected $lines = array();

	//----------------------------------------------------------------------//
	//	Seo __construct Functions - Start
	//----------------------------------------------------------------------//

	function __construct() {}

	//----------------------------------------------------------------------//
	//	Seos Class Functions - Start
	//----------------------------------------------------------------------//

	public function generate() { return implode(PHP_EOL, $this->lines); }

	public function addName($_property, $_content)
	{
		$this->addLine("<meta name=\"$_property\" content=\"$_content\" />");
	}

	public function addhttp($_property, $_content)
	{
		$this->addLine("<meta http-equiv=\"$_property\" content=\"$_content\" />\n");
	}

	public function addFB($_property, $_content)
	{
		$this->addLine("<meta property=\"$_property\" content=\"$_content\" />");
	}

	public function addTwit($_property, $_content)
	{
		$this->addLine("<meta property=\"$_property\" content=\"$_content\" />");
	}

	public function addSpacer() {$this->addLine("\t"); }

	public function addLine($_line) { $this->lines[] = (string) $_line; }

	protected function addLines($_lines){ foreach ((array) $_lines as $_line) { $this->addLine($_line); }}

	public function reset() { $this->lines = array(); }

	//----------------------------------------------------------------------//
	//	Check devnull.plugins Functions - Start
	//----------------------------------------------------------------------//

	public static function check_ifRobotsPresent()
	{
		$_value = DB::table('system_plugin_versions')->where('code', '=', 'Devnull.Robot')->pluck('is_disabled');
		return (!is_null($_value)) ? 1 : 0;
	}

	public static function check_ifDatabasePresent()
	{
		$_value = DB::table('system_plugin_versions')->where('code', '=', 'Devnull.Database')->pluck('is_disabled');
		return (!is_null($_value)) ? 1 : 0;
	}

	public static function check_ifSeoPresent()
	{
		$_value = DB::table('system_plugin_versions')->where('code', '=', 'Devnull.Seo')->pluck('is_disabled');
		return (!is_null($_value)) ? 1 : 0;
	}

	//----------------------------------------------------------------------//
	//	SEO Helpers Functions - Start
	//----------------------------------------------------------------------//

	public function returnActivateDe($_value)
	{
		if ($_value == TRUE) return 'Activated';
		else return 'Deactivated';
	}

	public function getIcon($_value)
	{
		if ($_value == FALSE) return 'negative';
		else  return 'positive';
	}

	public function getCSS($_value)
	{
		if($_value == FALSE)
			return 'btn btn-success';
		else
			return 'btn btn-danger';
	}

	public function getTranslation($_value)
	{
		if($_value == FALSE)
			return 'devnull.seo::lang.propertiesWidget.label_toggle_on';
		else if ($_value == TRUE)
			return 'devnull.seo::lang.propertiesWidget.label_toggle_off';
	}

	public function getToggle($_value)
	{
		if($_value == FALSE)
			return 'fa icon-toggle-on';
		else if ($_value == TRUE)
			return 'fa icon-toggle-off';
	}

	public function do_inverse($_value, $_option)
	{
		if($_value == FALSE)
			return $_option;
		else
			if ($_option == 'btn btn-success') return 'btn btn-danger';
			else if ($_option == 'btn btn-danger') return 'btn btn-success';
	}

	//----------------------------------------------------------------------//
	//	Seos Class Functions - End
	//----------------------------------------------------------------------//
}
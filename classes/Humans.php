<?php namespace Devnull\Main\Classes;

class Humans
{
	protected $lines = Array();

	public function generate()
	{
		return implode(PHP_EOL, $this->lines);
	}

	public function addHeader($_header)
	{
		$this->addLine("/* $_header /*");
	}

	public function addSuperman($_value, $_title)
	{
		$this->addLine("$_title: $_value");
	}

	public function addTechnology($_value, $_url)
	{
		$this->addLine("$_value [$_url]");
	}

	protected function addLine($line)
	{
		$this->lines[] = (string) $line;
	}

	public function addSpacer()
	{
		self::addLine("");
	}

	public function addComment($comment)
	{
		self::addLine("$comment");
	}

	public function reset()
	{
		$this->lines = array();
	}
}
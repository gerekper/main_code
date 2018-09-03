<?php namespace Devnull\Main\Facades;

use October\Rain\Support\Facade;

class Humans extends Facade
{
	protected static function getFacadeAccessor(){ return 'main.humans'; }
}
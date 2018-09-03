<?php namespace Devnull\Main\Facades;

use October\Rain\Support\Facade;

class Seeding extends Facade
{
	protected static function getFacadeAccessor(){ return 'main.seeding'; }
}

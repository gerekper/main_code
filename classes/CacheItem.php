<?php namespace Devnull\Main\Classes;

use Psr\Cache\CacheItemInterface;
use DateTimeInterface, DateInterval, DateTime;

class CacheItem implements CacheItemInterface
{
	protected $key;
	protected $value;
	protected $hit;
	protected $expires;

	//----------------------------------------------------------------------//
	//	__construct Functions - Start
	//----------------------------------------------------------------------//

	public function __construct($key, $value = null, $hit = false)
	{
		$this->key = $key;
		$this->value = $value;
		$this->hit = boolval($hit);
	}

	//----------------------------------------------------------------------//
	//	Main Functions - Start
	//----------------------------------------------------------------------//

	public function getKey()
	{
		return $this->key;
	}

	public function get()
	{
		return $this->value;
	}

	public function isHit()
	{
		return $this->hit;
	}

	public function set($value)
	{
		$this->value = $value;
		return $this;
	}

	public function expiresAfter($time)
	{
		$this->expires = $time;
		return $this;
	}

	//----------------------------------------------------------------------//
	//	Overridden Functions - Start
	//----------------------------------------------------------------------//

	//----------------------------------------------------------------------//
	//	Shared Functions - Start
	//----------------------------------------------------------------------//

	public function getTTL()
	{
		if (is_int($this->expires)) { return floor($this->expires / 60.0);}

		if ($this->expires instanceof DateTimeInterface)
		{
			$diff = (new DateTime())->diff($this->expires);
			return boolval($diff->invert) ? 0 : $diff->i;
		}

		if ($this->expires instanceof DateInterval)
		{
			return boolval($this->expires->invert) ? 0 : $this->expires->i;
		}
	}


	//----------------------------------------------------------------------//
	//	CacheItem Functions - Ends
	//----------------------------------------------------------------------//
}
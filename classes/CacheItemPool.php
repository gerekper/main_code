<?php namespace Devnull\Main\Classes;

use Psr\Cache\CacheItemInterface;
use Psr\Cache\CacheItemPoolInterface;
use Illuminate\Contracts\Cache\Repository;
use InvalidArgumentException, Exception;

class CacheItemPool Implements CacheItemPoolInterface
{
	protected $repository;
	protected $deferred = [];

	//----------------------------------------------------------------------//
	//	__construct Functions - Start
	//----------------------------------------------------------------------//

	public function __construct(Repository $repository)
	{
		$this->repository = $repository;
	}

	public function __destruct()
	{
		$this->commit();
	}

	//----------------------------------------------------------------------//
	//	Main Functions - Start
	//----------------------------------------------------------------------//

	public function getItem($key)
	{
		$this->validateKey($key);
		if ($this->repository->has($key))
		{
			return new CacheItem($key, unserialize($this->repository->get($key)), true);
		}
		else { return new CacheItem($key);}
	}

	public function getItems(array $key = array())
	{
		return array_combine($keys, array_map(function ($key)
		{
			return $this->getItem($key);
		}, $keys));
	}

	public function clear()
	{
		try {
			$store = $this->repository;
			$store->flush();
		}
		catch (Exception $exception)
		{
			return false;
		}

		return true;
	}

	public function deleteItem($key)
	{
		$this->validateKey($key);
		return $this->repository->forget($key);
	}

	public function deleteItems(array $keys)
	{
		foreach ($keys as $key)
		{
			$this->validateKey($key);
		}
		$success = true;
		foreach ($keys as $key)
		{
			$success = $success && $this->deleteItem($key);
		}
		return $success;

	}

	public function save(CacheItemInterface $item)
	{
		$expiresInMinutes = null;
		if ($item instanceof CacheItem)
		{
			$expiresInMinutes = $item->getTTL();
		}

		try {
			if (is_null($expiresInMinutes)) {
				$this->repository->forever($item->getKey(), serialize($item->get()));
			}
			else {
				$this->repository->put($item->getKey(), serialize($item->get()), $expiresInMinutes);
			}
		}
		catch (Exception $exception) {
			return false;
		}

		return true;
	}

	public function saveDeferred(CacheItemInterface $item)
	{
		$this->deferred[] = $item;

		return true;
	}

	public function commit()
	{
		$success = true;

		foreach ($this->deferred as $item) {
			$success = $success && $this->save($item);
		}

		$this->deferred = [];

		return $success;
	}

	protected function validateKey($key)
	{
		if (!is_string($key) || preg_match('#[{}\(\)/\\\\@:]#', $key)) {
			throw new InvalidArgumentException();
		}
	}
	//----------------------------------------------------------------------//
	//	Overridden Functions - Start
	//----------------------------------------------------------------------//

	//----------------------------------------------------------------------//
	//	Shared Functions - Start
	//----------------------------------------------------------------------//

	//----------------------------------------------------------------------//
	//	CacheItemPool Functions - Ends
	//----------------------------------------------------------------------//

}
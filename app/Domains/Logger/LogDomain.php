<?php

declare(strict_types=1);

namespace App\Domains\Logger;

class LogDomain
{
	/**
	 * @var string
	 */
	private $msg;

	/**
	 * @var array|NULL
	 */
	private $trace;

	/**
	 * @var array
	 */
	private $info;

	public function __construct(string $msg = '', array $trace = [], array $info = [])
	{
		$this->msg = $msg;
		$this->trace = count($trace) ? $trace : [];
		$this->info = $info;
	}

	/**
	 * Get msg.
	 * 
	 * @return string
	 */
	public function getMsg(){
		return isset($this->msg) ? $this->msg : '';
	}

	/**
	 * Get trace.
	 * 
	 * @return string|NULL
	 */
	public function getTrace($attribute)
	{
		return isset($this->trace[$attribute]) ? $this->trace[$attribute] : '';
	}
	
	/**
	 * Get info.
	 * 
	 * @return array
	 */
	public function getInfo()
	{
		if (isset($this->info['input']['password'])) {
			$this->info['input']['password'] = '*****';
		}

		return $this->info;
	}
	
	/**
	 * Get current file.
	 * 
	 * @return array
	 */
	public function getCurrentFile(){
		$rootDir = dirname(dirname(dirname(dirname(__FILE__)))) . '/';
		return explode($rootDir, $this->getTrace('file'))[1];
	}
}

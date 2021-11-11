<?php

declare(strict_types=1);

namespace App\Domains\Logger;

class LogDomain
{
	private $msg;
	private $trace;
	private $info;
	private $request;

	public function __construct(string $msg = '', array $trace = array(), array $info = array(), $request = NULL)
	{
		$this->msg = $msg;
		$this->trace = count($trace) ? array_shift($trace) : array();
		$this->info = $info;
		$this->request = $request;
	}

	public function getMsg(){
		return isset($this->msg) ? $this->msg : '';
	}

	public function getTrace($attribute)
	{
		return isset($this->trace[$attribute]) ? $this->trace[$attribute] : NULL;
	}

	public function getRequest($attribute)
	{
		return isset($this->request->{$attribute}) ? $this->request->{$attribute} : NULL;
	}

	public function getInfo()
	{
		if (isset($this->info['input']['password'])) {
			$this->info['input']['password'] = '*****';
		}
		
		return $this->info;
	}

	public function getCurrentFile(){
		$rootDir = dirname(dirname(dirname(dirname(__FILE__)))) . '/';
		return explode($rootDir, $this->getTrace('file'))[1];
	}
}

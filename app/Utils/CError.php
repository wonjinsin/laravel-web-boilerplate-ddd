<?php

declare(strict_types=1);

namespace App\Utils;

class CError
{
	/**
	 * @var \Lukasoppermann\Httpstatus\Httpstatus;
	 */
	private $httpPackage;

	/**
	 * @var int
	 */
	private $httpCode;

	/**
	 * @var string
	 */
	private $msg;

	/**
	 * Contruct
	 * 
	 * @param int $HttpCode
	 * @param string @msg
	 * @param int @customHttpCode
	 * @return void
	 */
	public function __construct(int $HttpCode = 400, $msg = 'Error occured')
	{
		$this->httpPackage = new \Lukasoppermann\Httpstatus\HttpStatus();
		$this->httpCode = $this->setHttpCode($HttpCode);
		$this->msg = $this->setMsg($msg, $HttpCode);
	}

	private function setHttpCode(int $httpCode = 400): int
	{
		return $httpCode;
	}

	private function setMsg(string $msg, int $httpCode): string
	{
		if ($msg) {
			return $msg;
		}

		if (isset($httpCode) && $this->httpPackage->hasStatusHttpCode($httpCode)) {
			return $this->httpPackage->getReasonPhrase($msg);
		}

		return "Bad Request";
	}

	/**
	 * Get HttpCode.
	 * 
	 * @return int
	 */
	public function getHttpCode()
	{
		return isset($this->httpCode) ? $this->httpCode : 500;
	}

	/**
	 * Get message.
	 * 
	 * @return string
	 */
	public function getMsg()
	{
		return isset($this->msg) ? $this->msg : 'Request Failed';
	}
}

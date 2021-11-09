<?php

declare(strict_types=1);

namespace App\Utils;

use Illuminate\Support\Facades\Log;

class CLog
{
	static function getFormattedString(string $msg, array $trace)
	{
		$rootDir = dirname(dirname(dirname(__FILE__))) . '/';

		$str  = sprintf('{"trid": "%d", ', TRID);
		$str .= isset($trace['method']) ? sprintf('"method": "%s", ', $trace['method']) : '';
		$str .= isset($trace['uri']) ? sprintf('"uri": "%s", ', $trace['uri']) : '';
		$str .= isset($trace['remoteIP']) ? sprintf('"remote_ip": "%s", ', $trace['remoteIP']) : '';
		$str .= $msg ? sprintf('"msg": "%s", ', $msg) : '';
		$str .= isset($trace['status']) ? sprintf('"status": "%d", ', $trace['status']) : '';
		$str .= isset($trace['latency']) ? sprintf('"latency": "%d", ', $trace['latency']) : '';
		$str .= isset($trace['function']) ? sprintf('"caller": "%s(%s:%d)"', $trace['function'], explode($rootDir, $trace['file'])[1], $trace['line']) : '';
		$str .= sprintf('}');

		return $str;
	}

	static function getArrayShift(array $trace = array())
	{
		if (!count($trace)) return array();

		return array_shift($trace);
	}

	static function setFilteredInfo(array $info = array())
	{
		if (isset($info['input']['password'])) {
			$info['input']['password'] = '*****';
		}
		return $info;
	}

	static function info(string $msg = '', array $trace = array(), array $info = array())
	{
		return Log::channel('stderr')->info(self::getFormattedString($msg, self::getArrayShift($trace)), self::setFilteredInfo($info));
	}

	static function infoForResult(string $msg = '', array $trace = array(), array $info = array())
	{
		return Log::channel('stderr')->info(self::getFormattedString($msg, self::getArrayShift($trace)), self::setFilteredInfo($info));
	}

	static function warn(string $msg = '', array $trace = array(), array $info = array())
	{
		return Log::channel('stderr')->warning(self::getFormattedString($msg, self::getArrayShift($trace)), self::setFilteredInfo($info));
	}

	static function warnForResult(string $msg = '', array $trace = array(), array $info = array())
	{
		return Log::channel('stderr')->warning(self::getFormattedString($msg, self::getArrayShift($trace)), self::setFilteredInfo($info));
	}

	static function error(string $msg = '', array $trace = array(), array $info = array())
	{
		return Log::channel('stderr')->error(self::getFormattedString($msg, self::getArrayShift($trace)), self::setFilteredInfo($info));
	}

	static function erroForResult(string $msg = '', array $trace = array(), array $info = array())
	{
		return Log::channel('stderr')->error(self::getFormattedString($msg, array_shift($trace)), self::setFilteredInfo($info));
	}
}

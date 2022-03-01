<?php

declare(strict_types=1);

namespace App\Utils;

use Illuminate\Support\Facades\Log;
use App\Domains\Logger\LogDomain;
use Throwable;

class CLog
{
	/**
	 * Get formatted string.
	 * 
	 * @param App\Domains\Logger\LogDomain $ld
	 * @return string
	 */
	static private function getFormattedString(LogDomain $ld)
	{
		$str  = sprintf('{"trid": "%d", ', TRID);
		$str .= $ld->getTrace('method') ? sprintf('"method": "%s", ', $ld->getTrace('method')) : '';
		$str .= $ld->getTrace('uri') ? sprintf('"uri": "%s", ', $ld->getTrace('uri')) : '';
		$str .= $ld->getTrace('remoteIP') ? sprintf('"remote_ip": "%s", ', $ld->getTrace('remoteIP')) : '';
		$str .= $ld->getMsg() ? sprintf('"msg": "%s", ', $ld->getMsg()) : '';
		$str .= $ld->getInfo() ? sprintf('"params": "%s", ', json_encode($ld->getInfo())) : '';
		$str .= $ld->getTrace('status') ? sprintf('"status": "%d", ', $ld->getTrace('status')) : '';
		$str .= $ld->getTrace('latency') ? sprintf('"latency": "%d", ', $ld->getTrace('latency')) : '';
		$str .= $ld->getTrace('function') ? sprintf('"caller": "%s(%s:%d)"', $ld->getTrace('function'), $ld->getCurrentFile(), $ld->getTrace('line')) : '';
		$str .= sprintf('}');

		return $str;
	}

	/**
	 * Get error string.
	 * 
	 * @param App\Domains\Logger\LogDomain $ld
	 * @return string
	 */
	static private function getErrorString(LogDomain $ld)
	{
		$str  = sprintf('{"trid": "%d", ', TRID);
		$str .= $ld->getMsg() ? sprintf('"msg": "%s", ', $ld->getMsg()) : '';
		$str .= $ld->getInfo() ? sprintf('"params": "%s", ', json_encode($ld->getInfo())) : '';
		$str .= sprintf('}');

		return $str;
	}

	/**
	 * Logging info.
	 * 
	 * @param string $msg
	 * @param array $trace
	 * @param array $info
	 * @return void
	 */
	static public function info(string $msg = '', array $trace = [], array $info = [])
	{
		Log::channel('stderr')->info(self::getFormattedString(new LogDomain($msg, $trace, $info)));
	}

	/**
	 * Logging warn.
	 * 
	 * @param string $msg
	 * @param array $trace
	 * @param array $info
	 * @return void
	 */
	static public function warn(string $msg = '', array $trace = [], array $info = [])
	{
		return Log::channel('stderr')->warning(self::getFormattedString(new LogDomain($msg, $trace, $info)));
	}

	/**
	 * Logging error.
	 * 
	 * @param string $msg
	 * @param array $trace
	 * @param array $info
	 * @return void
	 */
	static public function error(string $msg = '', array $trace = [], array $info = [])
	{
		if (isset($info['error']) && $info['error'] instanceof Throwable) {
			return Log::channel('stderr')->error(self::getErrorString(new LogDomain($msg, $trace, $info)));
		}
		return Log::channel('stderr')->error(self::getFormattedString(new LogDomain($msg, $trace, $info)));
	}
}

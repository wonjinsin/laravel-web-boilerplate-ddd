<?php

declare(strict_types=1);

namespace App\Utils;

use Illuminate\Support\Facades\Log;
use App\Domains\Logger\LogDomain;

class CLog
{
	static private function getFormattedString(LogDomain $ld)
	{
		$str  = sprintf('{"trid": "%d", ', TRID);
		$str .= $ld->getTrace('method') ? sprintf('"method": "%s", ', $ld->getTrace('method')) : '';
		$str .= $ld->getTrace('uri') ? sprintf('"uri": "%s", ', $ld->getTrace('uri')) : '';
		$str .= $ld->getTrace('remoteIP') ? sprintf('"remote_ip": "%s", ', $ld->getTrace('remoteIP')) : '';
		$str .= $ld->getMsg() ? sprintf('"msg": "%s", ', $ld->getMsg()) : '';
		$str .= $ld->getTrace('status') ? sprintf('"status": "%d", ', $ld->getTrace('status')) : '';
		$str .= $ld->getTrace('latency') ? sprintf('"latency": "%d", ', $ld->getTrace('latency')) : '';
		$str .= $ld->getTrace('function') ? sprintf('"caller": "%s(%s:%d)"', $ld->getTrace('function'), $ld->getCurrentFile(), $ld->getTrace('line')) : '';
		$str .= sprintf('}');

		return $str;
	}

	static public function info(string $msg = '', array $trace = array(), array $info = array())
	{
		return Log::channel('stderr')->info(self::getFormattedString(new LogDomain($msg, $trace, $info)));
	}

	static public function infoForResult(string $msg = '', array $trace = array(), array $info = array())
	{
		return Log::channel('stderr')->info(self::getFormattedString(new LogDomain($msg, $trace, $info, request())));
	}

	static public function warn(string $msg = '', array $trace = array(), array $info = array())
	{
		return Log::channel('stderr')->warning(self::getFormattedString(new LogDomain($msg, $trace, $info)));
	}

	static public function warnForResult(string $msg = '', array $trace = array(), array $info = array())
	{
		return Log::channel('stderr')->warning(self::getFormattedString(new LogDomain($msg, $trace, $info, request())));
	}

	static public function error(string $msg = '', array $trace = array(), array $info = array())
	{
		return Log::channel('stderr')->error(self::getFormattedString(new LogDomain($msg, $trace, $info)));
	}

	static public function erroForResult(string $msg = '', array $trace = array(), array $info = array())
	{
		return Log::channel('stderr')->error(self::getFormattedString(new LogDomain($msg, $trace, $info, request())));
	}
}

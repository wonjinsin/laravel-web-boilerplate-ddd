<?php

declare(strict_types=1);

namespace App\Utils;

use App\Exceptions\GeneralException;

class CError {
	static $message;

	public static function set($message) {
		self::$message = $message;
	}

	public static function get() {
		return self::$message;
	}
}
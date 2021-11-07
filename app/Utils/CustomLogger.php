<?php

declare(strict_types=1);

namespace App\Utils;

use Illuminate\Support\Facades\Log;

class CustomLogger {
	static function Info($msg) {
		Log::info($msg);
	}
}

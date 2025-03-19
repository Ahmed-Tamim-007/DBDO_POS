<?php

namespace App\Helpers;

class AppHelper {
    public static function getVersion() {
        return trim(exec('git describe --tags --abbrev=0')) ?: '1.0.0';
    }
}

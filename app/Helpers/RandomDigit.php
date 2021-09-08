<?php

namespace App\Helpers;

use Carbon\Carbon;

/**
 * Format response.
 */
class RandomDigit
{
    public static function getRandom($type)
    {
        $date = Carbon::now(); // will get you the current date, time
        $data = explode('-', $date->format('Y-m-d'));
        $random = substr(hash('sha256', mt_rand() . microtime()), 0, 3);
        return $type . $data[0] . $data[1] . $data[2] . $random;
    }
}

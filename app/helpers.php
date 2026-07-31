<?php

use Carbon\Carbon;

if (! function_exists('format_date')) {
    function format_date($date, string $format = 'M Y'): string
    {
        if (empty($date)) {
            return '';
        }

        try {
            return Carbon::parse($date)->format($format);
        } catch (Throwable $e) {
            return '';
        }
    }
}

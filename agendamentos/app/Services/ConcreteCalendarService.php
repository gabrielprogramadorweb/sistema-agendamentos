<?php

namespace App\Services;

use Carbon\Carbon;

class ConcreteCalendarService extends CalendarService {
    public function renderMonths(): array {
        $today = Carbon::now();
        $currentYear = $today->year;
        $currentMonth = $today->month;

        $options = [];
        foreach (self::$months as $key => $month) {
            if ($currentMonth > $key) {
                continue;  // Skip past months within the current year
            }
            $options[$key] = "{$month} / {$currentYear}";
        }
        return $options;
    }
}

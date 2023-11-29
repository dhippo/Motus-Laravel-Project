<?php

namespace App\Models;

use Carbon\Carbon;

class Calendar
{

    public function __construct()
    {
    }

    public static function getDataCalendar(): array
    {
        // Obtenir le mois et l'année actuels
        $currentYear = Carbon::now()->year;
        $currentMonth = Carbon::now()->month;

        $firstDay = Carbon::create($currentYear, $currentMonth, 1, 0, 0, 0);
        $daysInMonth = $firstDay->daysInMonth;
        $displayFirstDay = $firstDay->format('F Y');
        $firstDayWeek = $firstDay->dayOfWeek;


        return [
            'firstDay' => $firstDayWeek,
            'daysInMonth' => $daysInMonth,
            'displayFirstDay' => $displayFirstDay

        ];

    }

}

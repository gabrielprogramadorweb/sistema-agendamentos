<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;

abstract class CalendarService {
    protected static $months = [
        1 => 'Janeiro', 2 => 'Fevereiro', 3 => 'Março', 4 => 'Abril',
        5 => 'Maio', 6 => 'Junho', 7 => 'Julho', 8 => 'Agosto',
        9 => 'Setembro', 10 => 'Outubro', 11 => 'Novembro', 12 => 'Dezembro'
    ];

    abstract public function renderMonths(): array;

    public function generate(int $month): string {
        try {
            $now = Carbon::now();
            $currentYear = $now->year;
            $currentMonth = $now->month;
            $currentDay = $now->day;

            $firstDayObject = Carbon::create($currentYear, $month, 1);
            $daysOfMonth = $firstDayObject->daysInMonth;
            $startDay = $firstDayObject->dayOfWeek;

            $calendar = '<div class="table-responsive"><table class="table table-sm table-borderless">';
            $calendar .= '<tr class="text-center">
                            <td>Dom</td>
                            <td>Seg</td>
                            <td>Ter</td>
                            <td>Qua</td>
                            <td>Qui</td>
                            <td>Sex</td>
                            <td>Sáb</td>
                        </tr>';

            if ($startDay > 0) {
                $calendar .= '<tr>' . str_repeat('<td>&nbsp;</td>', $startDay);
            }

            for ($day = 1; $day <= $daysOfMonth; $day++) {
                if ($startDay == 0) {
                    $calendar .= '<tr>';
                }

                $isWeekend = $this->isWeekend($currentYear, $month, $day);
                $isPast = $month === $currentMonth && $day < $currentDay;
                $btnDay = $this->renderDayButton($day, $month, $isWeekend || $isPast);
                $calendar .= "<td>{$btnDay}</td>";

                if ($startDay == 6) {
                    $calendar .= '</tr>';
                    $startDay = -1;
                }
                $startDay++;
            }

            if ($startDay != 0) {
                $calendar .= str_repeat('<td>&nbsp;</td>', 7 - $startDay) . '</tr>';
            }

            $calendar .= '</table></div>';

            return $calendar;
        } catch (\Exception $e) {
            Log::error("Error retrieving calendar: " . $e->getMessage());
            return "Não foi possível gerar o calendário para o mês informado: " . $e->getMessage();
        }
    }

    private function isWeekend(int $year, int $month, int $day): bool {
        $date = Carbon::create($year, $month, $day);
        return $date->isWeekend();
    }

    private function renderDayButton(int $day, int $month, bool $disable): string {
        $class = $disable ? 'btn btn-secondary btn-calendar-day disabled' : 'btn btn-primary btn-calendar-day';
        $style = $disable ? 'background-color: rgba(0, 0, 0, 0.2); cursor: not-allowed;' : 'cursor: pointer; background-color: #007bff;';
        $disabled = $disable ? 'disabled' : '';
        $dataDay = "data-day='{$day}'";

        return "<button type='button' class='{$class}' style='{$style}' {$disabled} {$dataDay}>{$day}</button>";
    }


}

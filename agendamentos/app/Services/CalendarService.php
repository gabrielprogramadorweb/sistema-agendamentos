<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;

abstract class CalendarService
{
    protected static $months = [
        1 => 'Janeiro', 2 => 'Fevereiro', 3 => 'Março', 4 => 'Abril',
        5 => 'Maio', 6 => 'Junho', 7 => 'Julho', 8 => 'Agosto',
        9 => 'Setembro', 10 => 'Outubro', 11 => 'Novembro', 12 => 'Dezembro'
    ];

    abstract public function renderMonths(): array;

    // Renderiza os dias para o mês informado para serem escolhidos no front
    public function generate(int $month): string
    {
        try {
            $now = Carbon::now();
            $currentMonth = $now->month;
            $year = $now->year;

            if ($month < $currentMonth || !array_key_exists($month, self::$months)) {
                throw new InvalidArgumentException("O mês {$month} não é um mês válido para gerar o calendário");
            }
            // novo objeto para ter acesso ao dia da semana do primeiro dia do mês
            $firstDayObject = $now::create(year: $year, month: $month, day: 1);

            // obtém a quantidade de dias do mês
            $daysOfMonth = $firstDayObject->format('t');
            // obtém a representação numérica do dia da semana. 0 (domingo) até 6 (sabado)
            $startDay = (int) $firstDayObject->format('w');
            // abertura da div que comporta o calendário
            $calendar = '<div class="table-responsive">';
            // abertura da tabela
            $calendar .= '<div class="table table-sm table-bordered">';
            // dias da semana( primeira linha da tabela
            $calendar .= '<tr class="text-center">
                              <td>Dom</td>
                              <td>Seg</td>
                              <td>Ter</td>
                              <td>Qua</td>
                              <td>Qui</td>
                              <td>Sex</td>
                              <td>Sáb</td>
                          </tr>
                          ';
            if ($startDay > 0){
                for ($i = 0; $i < $startDay; $i++){
                    $calendar .= '<td>&nbsp;</td>';
                }
            }

            // população de calendario
            for ($day = 1; $day <= $daysOfMonth; $day++ ){
                $calendar .= "<td>{$day}</td>";
                // vamos incrementar o dia de inicio
                $startDay++;
                // se $startDay for igual a 7 (domingo), adicionamos uma nova linha na tabela
                if ($startDay === 7){
                    // reinicio o startDay em zero
                    $startDay = 0;
                    // se o dia corrente for menor $daysOfMonth, então realizamos a abertura da <tr> (nova linha)
                    if ($day < $daysOfMonth) {
                        $calendar .= '<tr>';
                    }

                }
            }
            return $calendar;
        } catch (\Exception $e) {
            Log::error("Error retrieving calendar: " . $e->getMessage());
            return "Não foi possível gerar o calendário para o mês informado: " . $e->getMessage();
        }
    }
}

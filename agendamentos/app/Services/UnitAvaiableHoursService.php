<?php

namespace App\Services;

use App\Models\UnitModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class UnitAvaiableHoursService
{
    // Renderiza as horas disponíveis para serem escolhidas no agendamento.
    public function renderHours(array $request): string|null
    {
        try {
            // Transforma o request em objeto para facilitar acesso.
            $request = (object) $request;
            // Obtém unidade, mês e dia desejado.
            $unitId = (string) $request->unit_id;
            $month = (string) $request->month;
            $day = (string) $request->day;

            // Adicionando zero à esquerda para mês e dia se necessário.
            $month = strlen($month) < 2 ? sprintf("%02d", $month) : $month;
            $day = strlen($day) < 2 ? sprintf("%02d", $day) : $day;

            // Valida a existência da unidade, se está ativa e com serviços.
            $unit = UnitModel::where('active', 1)->findOrFail($unitId);
            // Data atual para comparação.
            $now = Carbon::now();
            // Obtém a data desejada no formato 'Y-m-d'.
            $dateWanted = "{$now->year}-{$month}-{$day}";
            // Identifica se a data desejada é a data atual.
            $isCurrentDay = $dateWanted === $now->toDateString();

            // Cria intervalos de tempo com base nos horários de serviço da unidade.
            $timeRange = $this->createUnitTimeRange($unit->starttime, $unit->endtime, $unit->servicetime, $isCurrentDay);

            // Inicia a string de retorno com div aberto para os horários.
            $divHours = '<div class="hours-container">';

            // Itera sobre o array de horários e cria botões para cada hora disponível.
            foreach ($timeRange as $hour) {
                $divHours .= "<button class='btn btn-hour btn-primary' data-hour='{$hour}'>{$hour}</button>";
            }

            // Fecha a div de horários.
            $divHours .= '</div>';

            return $divHours;
        } catch (\Exception $e) {
            Log::error("Error in renderHours method: " . $e->getMessage());
            // Retorna null se ocorrer uma exceção para que a aplicação possa tratar adequadamente.
            return null;
        }
    }

    // Cria um array com range de horários de acordo com início, fim e intervalo.
    private function createUnitTimeRange(string $start, string $end, string $interval, bool $isCurrentDay): array
    {
        $startTime = new Carbon($start);
        $endTime = new Carbon($end);

        // Ensure interval is a number and append 'M' for minutes correctly.
        $intervalFormatted = 'PT' . intval($interval) . 'M';
        $period = new \DatePeriod($startTime, new \DateInterval($intervalFormatted), $endTime);

        $timeRange = [];
        $now = Carbon::now()->format('H:i');

        foreach ($period as $time) {
            $hour = $time->format('H:i');
            if (!$isCurrentDay || ($isCurrentDay && $hour > $now)) {
                $timeRange[] = $hour;
            }
        }

        return $timeRange;
    }

}

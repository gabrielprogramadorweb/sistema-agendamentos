<?php

namespace App\Services;

 use App\Models\UnitModel;
 use Carbon\Carbon;
 use Illuminate\Http\Response;
 use Illuminate\Support\Facades\Log;

 class UnitAvaiableHoursService
{
    //Renderiza as horas disponíveis para serem escolhidas no agendamento.
   public function renderHours(array $request): string|null
   {
       try {
           // trabsfirma o request em objeto
           $request = (object) $request;
           // obtem unidade, mês e dia desejado
           $unitId  = (string) $request->unit_id;
           $month   = (string) $request->month;
           $day     = (string) $request->day;

           // adicionando zero à esquerda do mês e dia quando for o caso
           $month   = strlen($month) < 2 ? sprintf("%02d", $month) : $month;
           $day     = strlen($day) < 2 ? sprintf("%02d", $day) : $day;
           // validamos a existência da unidade, ativa, com serviços
           $unit = UnitModel::where('active', 1)->findOrFail($unitId);
           // data atual
           $now = Carbon::now();
           // obtem a data desejada
           $dateWanted = "{$now->getYear()}-{$month}-{$day}";
           // precisamos identificar se a data desejada é a data atual
           $isCurrentDay = $dateWanted === $now->format('Y-m-d');

           $timeRange = $this->createUnitTimeRange(start: $unit->starttime, end: $unit->endtime, interval: $unit->servicetime, isCurrentDay: $isCurrentDay );
           // abertura da div com os horários com valor padrão null
           $divHours = null;

           foreach ($timeRange as $hour) {
               $divHours .= form_button(data: ['class' => 'btn btn-hour btn-primary', 'data-hour' => $hour], content: $hour);
           }
           return $divHours;

       }catch (\Exception $e) {
           Log::error("Error in index method of SchedulesController: " . $e->getMessage());
           return response()->json([
               'error' => 'An error occurred while retrieving schedule units.',
               'details' => $e->getMessage()
           ], Response::HTTP_INTERNAL_SERVER_ERROR);
       }
   }

   //Cria um array com range de horários de acordo co início, fim e intervalo.
   private function createUnitTimeRange(string $start, string $end, string $interval, bool $isCurrentDay): array
   {
        $period = new \DatePeriod(new Carbon($start), \DateInterval::createFromDateString($interval), new Carbon($end));
        // receberá os tempos gerados
       $timeRange = [];
       // tempo atual hh:mm para comparar com a hora e minutos gerados no foreach abaixo
       $now = Carbon::now()->format('H:i');
       foreach ($period as $instance){
           //recuperamos o tempo no formato 'hh:mm'
           $hour = Carbon::createFromInterface($instance)->format('H:i');
           // se não for o dia atual, fazemos o push normal
           if (! $isCurrentDay){
                $timeRange[] = $hour;
           }else{
           // aqui dentro é dia atual,
           // verificamos se a hora de inicio é maior que hora atual.
           // dessa forma só apresentaremos horários que forem maiores que o horário atual
           // ou sejam não apresentamos horas passadas
                if ($hour > $now){
                    $timeRange[] = $hour;
                }
           }
       }
       return $timeRange;
   }

}

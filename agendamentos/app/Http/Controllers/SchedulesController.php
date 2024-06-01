<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Notifications\ScheduleCreatedNotification;
use App\Services\CalendarService;
use App\Services\SchedulesService;
use App\Services\UnitAvaiableHoursService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class SchedulesController extends Controller
{
    private SchedulesService $schedulesService;
    private CalendarService $calendarService;
    private UnitAvaiableHoursService $UnitAvaiableHoursService;

    public function __construct(UnitAvaiableHoursService $unitAvaiableHoursService, SchedulesService $schedulesService, CalendarService $calendarService) {
        $this->schedulesService = $schedulesService;
        $this->calendarService = $calendarService;
        $this->UnitAvaiableHoursService = $unitAvaiableHoursService;
    }

    public function index() {
        try {
            $title = 'Criar agendamento';
            $units = $this->schedulesService->renderUnits();
            $months = $this->calendarService->renderMonths();
            return view('Front.Schedules.index', compact('title', 'units', 'months'));
        } catch (\Exception $e) {
            Log::error("Error in index method of SchedulesController: {$e}");
            return response()->json(['error' => 'An error occurred while retrieving schedule units.', 'details' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    public function unitServices(Request $request, $unitId)
    {
        if (!$request->ajax()) {
            return response()->json(['error' => 'This endpoint only accepts AJAX requests'], 400);
        }

        try {
            $services = $this->schedulesService->getUnitServices((int) $unitId);
            if (empty($services)) {
                return response()->json(['error' => 'No services available for this unit'], 404);
            }

            $options = '<option value="">--- Escolha ---</option>';
            foreach ($services as $service) {
                $options .= "<option value='{$service->id}'>{$service->name}</option>";
            }

            return response()->json(['services' => $options], 200);
        } catch (\Exception $e) {
            Log::error("Error retrieving unit services for unit {$unitId}: " . $e->getMessage());
            return response()->json(['error' => 'An error occurred while retrieving unit services'], 500);
        }
    }

    public function getCalendar(Request $request)
    {
        if (!$request->ajax()) {
            return response()->json(['error' => 'This endpoint only accepts AJAX requests'], 400);
        }

        try {
            $month = $request->query('month');
            if (is_null($month)) {
                return response()->json(['error' => 'Month parameter is required'], 400);
            }

            $month = (int) $month;
            $calendarDetails = $this->fetchCalendarDetailsByMonth($month);

            if (empty($calendarDetails)) {
                return response()->json(['error' => "No calendar data available for month {$month}"], 404);
            }

            return response()->json(['calendar' => $this->calendarService->generate(month: $month)], 200);
        } catch (\Exception $e) {
            Log::error("Error retrieving calendar: " . $e->getMessage());
            return response()->json(['error' => 'An error occurred while retrieving the calendar'], 500);
        }
    }

    public function getHours(Request $request)
    {
        Log::info("Received parameters:", $request->all());

        if (!$request->ajax()) {
            return response()->json(['error' => 'This endpoint only accepts AJAX requests'], 400);
        }

        try {
            $unitId = $request->query('unit_id');
            $month = $request->query('month');
            $serviceId = $request->query('service_id');
            $day = $request->query('day');

            if (is_null($unitId) || is_null($month) || is_null($day)) {
                return response()->json(['error' => 'All parameters (unit_id, month, day) are required'], 400);
            }

            $hours = $this->UnitAvaiableHoursService->renderHours([
                'unit_id' => $unitId,
                'month' => $month,
                'day' => $day,
                'service_id' => $serviceId
            ]);

            if (empty($hours)) {
                return response()->json(['error' => "No available hours for the selected day"], 404);
            }

            return response()->json(['hours' => $hours], 200);
        } catch (\Exception $e) {
            Log::error("Error retrieving hours: " . $e->getMessage());
            return response()->json(['error' => 'An error occurred while processing your request'], 500);
        }
    }

    public function createSchedule(Request $request)
    {
        $request->merge([
            'hour' => substr($request->hour, 0, 5)
        ]);

        $validator = $this->schedulesService->validateSchedule($request);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 400);
        }
//        \Mail::raw('Hello, this is a test email.', function ($message) {
//            $message->from(config('mail.from.address'), config('mail.from.name'));
//            $message->to('test@example.com', 'Recipient Name')->subject('Test Email');
//        });


        try {
            DB::beginTransaction();

            $currentYear = now()->year;
            $chosenDate = Carbon::createFromFormat('Y-m-d H:i', "{$currentYear}-{$request->month}-{$request->day} {$request->hour}", 'UTC');
            $existingSchedule = Schedule::where('chosen_date', $chosenDate)->exists();

            if ($existingSchedule) {
                throw new \Exception('Já existe uma programação com a data e hora especificadas.');
            }


            $schedule = new Schedule();
            $schedule->unit_id = $request->unit_id;
            $schedule->service_id = $request->service_id;
            $schedule->month = $request->month;
            $schedule->day = $request->day;
            $schedule->hour = $request->hour;
            $schedule->chosen_date = $chosenDate;
            $schedule->user_id = auth()->user()->id;
            $schedule->save();
            $user = auth()->user();
//            $user->notify(new \App\Notifications\ScheduleCreatedNotification($schedule));

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Agendamento criado com sucesso!'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to create schedule',
                'details' => $e->getMessage()
            ], 500);
        }
    }

    public function showUserSchedules()
    {
        $userId = Auth::id();

        $schedules = Schedule::with(['service', 'unit'])->where('user_id', $userId)->get();

        $title = 'Meus Agendamentos';

        return view('Front.Schedules.my_schedules', compact('schedules', 'title'));
    }

    private function monthToNumber($monthName) {
        $months = [
            'Janeiro' => '01', 'Fevereiro' => '02', 'Março' => '03', 'Abril' => '04',
            'Maio' => '05', 'Junho' => '06', 'Julho' => '07', 'Agosto' => '08',
            'Setembro' => '09', 'Outubro' => '10', 'Novembro' => '11', 'Dezembro' => '12'
        ];
        return $months[$monthName] ?? null;
    }


    private function parseMonth($input)
    {
        $months = [
            'Janeiro' => 1, 'Fevereiro' => 2, 'Março' => 3, 'Abril' => 4,
            'Maio' => 5, 'Junho' => 6, 'Julho' => 7, 'Agosto' => 8,
            'Setembro' => 9, 'Outubro' => 10, 'Novembro' => 11, 'Dezembro' => 12
        ];
        $parts = explode(' / ', $input);
        $name = $parts[0];
        return $months[$name] ?? null; // Return the month number or null if not found
    }


    private function fetchCalendarDetailsByMonth($month)
    {
        try {
            return "Details for month {$month}";
        } catch (\Exception $e) {
            Log::error("Failed fetching calendar data for month {$month}: " . $e->getMessage());
            return null;
        }
    }
    public function destroy(Schedule $schedule)
    {
        $schedule->delete();

        return redirect()->route('meus-agendamentos')->with('success', 'Agendamento cancelado com sucesso.');
    }

}



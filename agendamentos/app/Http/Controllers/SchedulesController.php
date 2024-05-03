<?php

namespace App\Http\Controllers;

use App\Services\CalendarService;
use App\Services\SchedulesService;
use App\Services\UnitAvaiableHoursService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

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

    //recupera o calendario
    public function getCalendar(Request $request)
    {
        if (!$request->ajax()) {
            return response()->json(['error' => 'This endpoint only accepts AJAX requests'], 400);
        }

        try {
            // Ensure the 'month' parameter is present
            $month = $request->query('month');
            if (is_null($month)) {
                return response()->json(['error' => 'Month parameter is required'], 400);
            }

            $month = (int) $month;
            // Retrieve or calculate calendar data based on the month
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

    //recupera as horas
    public function getHours(Request $request)
    {
        Log::info("Received parameters:", $request->all());

        if (!$request->ajax()) {
            return response()->json(['error' => 'This endpoint only accepts AJAX requests'], 400);
        }

        try {
            $unitId = $request->query('unit_id');
            $month = $request->query('month');
            $day = $request->query('day');

            if (is_null($unitId) || is_null($month) || is_null($day)) {
                return response()->json(['error' => 'All parameters (unit_id, month, day) are required'], 400);
            }

            $hours = $this->UnitAvaiableHoursService->renderHours([
                'unit_id' => $unitId,
                'month' => $month,
                'day' => $day
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


    /**
     * A hypothetical method to fetch calendar details by month
     */
    private function fetchCalendarDetailsByMonth($month)
    {
        // Assuming you have a model or a service to get calendar data
        try {
            // Simulated fetching logic
            return "Details for month {$month}";
        } catch (\Exception $e) {
            Log::error("Failed fetching calendar data for month {$month}: " . $e->getMessage());
            return null;
        }
    }


}

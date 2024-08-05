<?php

namespace App\Http\Controllers\Super;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreHomeRequest;
use App\Http\Requests\UpdateHomeRequest;
use App\Models\Home;
use App\Models\Schedule;
use App\Models\ServiceModel;
use App\Models\StatusAgendamento;
use Illuminate\Http\Request;
use App\Models\Notification;
use Illuminate\Support\Carbon;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        try {
            if (!auth()->check()) {
                return redirect()->route('login');
            }

            $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->toDateString());
            $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->toDateString());

            $schedules = Schedule::with('service', 'unit', 'user', 'status')
                ->whereBetween('chosen_date', [$startDate, $endDate])
                ->orderBy('created_at', 'desc')
                ->paginate(10);

            $mostRequestedProcedure = Schedule::select('service_id')
                ->selectRaw('count(*) as total')
                ->whereBetween('chosen_date', [$startDate, $endDate])
                ->groupBy('service_id')
                ->orderByDesc('total')
                ->first();

            $mostRequestedProcedureName = $mostRequestedProcedure ? ServiceModel::find($mostRequestedProcedure->service_id)->name : 'Nenhum';

            $totalProcedures = Schedule::whereBetween('chosen_date', [$startDate, $endDate])->count();

            $confirmedSchedules = Schedule::where('status_id', 1)
                ->whereBetween('chosen_date', [$startDate, $endDate])
                ->count();

            $statuses = StatusAgendamento::all();
            $title = 'Todos os Agendamentos';

            $schedulesData = $this->getSchedulesData($startDate, $endDate);
            $notifications = Notification::orderBy('created_at', 'desc')->get();

            \Log::info('Usuário autenticado:', ['user_id' => auth()->user()->id]);
            \Log::info('Todas as notificações:', $notifications->toArray());

            return view('Back.Home.index', compact('schedulesData', 'schedules', 'statuses', 'title', 'notifications', 'mostRequestedProcedureName', 'totalProcedures', 'confirmedSchedules', 'startDate', 'endDate'));
        } catch (\Exception $e) {
            \Log::error("Erro ao carregar a página inicial: " . $e->getMessage());
            return redirect()->route('error.page')->with('error', 'Erro ao carregar a página');
        }
    }

    private function getSchedulesData($startDate, $endDate)
    {
        $schedules = Schedule::with('service')
            ->whereBetween('chosen_date', [$startDate, $endDate])
            ->get();
        $data = [];
        foreach ($schedules as $schedule) {
            $serviceName = $schedule->service->name ?? 'Serviço não especificado';
            if (!isset($data[$serviceName])) {
                $data[$serviceName] = 0;
            }
            $data[$serviceName]++;
        }

        return [
            'labels' => array_keys($data),
            'data' => array_values($data),
        ];
    }

    public function updateStatus(Request $request, $id)
    {
        try {
            $schedule = Schedule::findOrFail($id);
            $schedule->status_id = $request->status_id;
            $schedule->save();

            $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->toDateString());
            $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->toDateString());

            // Recalcula o número de agendamentos confirmados
            $confirmedSchedules = Schedule::where('status_id', 1)
                ->whereBetween('chosen_date', [$startDate, $endDate])
                ->count();

            return response()->json(['success' => 'Status do agendamento atualizado com sucesso.', 'confirmedSchedules' => $confirmedSchedules]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao atualizar o status do agendamento.'], 500);
        }
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreHomeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreHomeRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Home  $home
     * @return \Illuminate\Http\Response
     */
    public function show(Home $home)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Home  $home
     * @return \Illuminate\Http\Response
     */
    public function edit(Home $home)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateHomeRequest  $request
     * @param  \App\Models\Home  $home
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateHomeRequest $request, Home $home)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Home  $home
     * @return \Illuminate\Http\Response
     */
    public function destroy(Schedule $schedule)
    {
        $schedule->delete();

        return redirect()->route('home.index')->with('success', 'Agendamento cancelado com sucesso.');
    }
}

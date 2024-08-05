<?php

namespace App\Http\Controllers\Super;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreHomeRequest;
use App\Http\Requests\UpdateHomeRequest;
use App\Models\Home;
use App\Models\Schedule;
use App\Models\StatusAgendamento;
use Illuminate\Http\Request;
use App\Models\Notification;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        try {
            if (!auth()->check()) {
                return redirect()->route('login');
            }

            $schedules = Schedule::with('service', 'unit', 'user', 'status')
                ->orderBy('created_at', 'desc')
                ->paginate(5);
            $statuses = StatusAgendamento::all(); // Adiciona essa linha
            $title = 'Todos os Agendamentos';

            $schedulesData = $this->getSchedulesData();
            $notifications = Notification::orderBy('created_at', 'desc')->get();

            \Log::info('Usuário autenticado:', ['user_id' => auth()->user()->id]);
            \Log::info('Todas as notificações:', $notifications->toArray());

            return view('Back.Home.index', compact('schedulesData', 'schedules', 'statuses', 'title', 'notifications'));
        } catch (\Exception $e) {
            \Log::error("Erro ao carregar a página inicial: " . $e->getMessage());
            return redirect()->route('error.page')->with('error', 'Erro ao carregar a página');
        }
    }

    public function updateStatus(Request $request, $id)
    {
        try {
            $schedule = Schedule::findOrFail($id);
            $schedule->status_id = $request->status_id;
            $schedule->save();

            return response()->json(['success' => 'Status do agendamento atualizado com sucesso.']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao atualizar o status do agendamento.'], 500);
        }
    }



    private function getSchedulesData()
    {
        $schedules = Schedule::with('service')->get();
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

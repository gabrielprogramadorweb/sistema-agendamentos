<?php
namespace App\Http\Controllers\Super;
use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\Schedule;
use App\Models\ServiceModel;
use App\Models\StatusAgendamento;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SchedulesAdminController extends Controller
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
            $title = 'Todos os Agendamentos Admin';
            $schedulesData = $this->getSchedulesData($startDate, $endDate);
            $notifications = Notification::orderBy('created_at', 'desc')->get();

            \Log::info('Usuário autenticado:', ['user_id' => auth()->user()->id]);
            \Log::info('Todas as notificações:', $notifications->toArray());

            return view('Admin.Schedules.index', compact(
                'schedulesData',
                'schedules',
                'statuses',
                'title',
                'notifications',
                'mostRequestedProcedureName',
                'totalProcedures',
                'confirmedSchedules',
                'startDate',
                'endDate'
            ));
        } catch (\Exception $e) {
            \Log::error("Erro ao carregar a página inicial: " . $e->getMessage());
            return redirect()->route('login')->with('error', 'Erro ao carregar a página');
        }
    }
}

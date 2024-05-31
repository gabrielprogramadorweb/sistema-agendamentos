@extends('Back.Layout.main')

@section('title')
    {{ $title }}
@endsection

@section('css')

@endsection

@section('content')
    <div class="container-fluid">
        <h1 class="h3 mb-4 mt-4 text-gray-800">{{ $title }} </h1>

        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-chart-bar"></i>
                Agendamentos por Serviço
            </div>
            <div class="card-body">
                <canvas id="schedulesChart"></canvas>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover">
                <thead class="thead-dark">
                <tr>
                    <th class="text-center">Data e Hora</th>
                    <th class="text-center">Serviço</th>
                    <th class="text-center">Unidade</th>
                    <th class="text-center">Nome do Cliente</th>
                    <th class="text-center">Email do Cliente</th>
                    <th class="text-center">Telefone do Cliente</th>
                    <th class="text-center">Ações</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($schedules as $schedule)
                    <tr>
                        <td class="text-center">{{ $schedule->chosen_date->format('d/m/Y H:i') }}</td>
                        <td class="text-center">{{ $schedule->service->name ?? 'Serviço não especificado' }}</td>
                        <td class="text-center">{{ $schedule->unit->name ?? 'Unidade não especificada' }}</td>
                        <td class="text-center">{{ $schedule->user->name ?? 'Cliente não especificado' }}</td>
                        <td class="text-center">{{ $schedule->user->email ?? 'Email não especificado' }}</td>
                        <td class="text-center">{{ $schedule->user->phone ?? 'Telefone não especificado' }}</td> <!-- Exibir telefone do cliente -->
                        <td class="text-center">
                            <form action="{{ route('admin.schedules.destroy', $schedule->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Cancelar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="text-center" colspan="7">Nenhum agendamento encontrado.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var ctx = document.getElementById('schedulesChart').getContext('2d');
            var schedulesData = @json($schedulesData);

            var combinedData = schedulesData.labels.map(function(label, index) {
                return { label: label, value: schedulesData.data[index] };
            });

            combinedData.sort(function(a, b) {
                return b.value - a.value;
            });

            var sortedLabels = combinedData.map(function(item) {
                return item.label;
            });
            var sortedData = combinedData.map(function(item) {
                return item.value;
            });

            var chart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: sortedLabels,
                    datasets: [{
                        label: 'Agendamentos',
                        data: sortedData,
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });

    </script>
@endsection

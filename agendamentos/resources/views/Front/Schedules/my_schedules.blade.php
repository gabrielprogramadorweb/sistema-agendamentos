@extends('Front.Layout.main')

@section('title')
    {{ $title }}
@endsection

@section('content')
    <div class="container mt-5">
        <h1 class="mb-4 text-center titulo"><b>Meus Agendamentos</b></h1>
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover">
                <thead class="thead-dark">
                <tr>
                    <th class="text-center">Data e Hora</th>
                    <th class="text-center">Serviço</th>
                    <th class="text-center">Unidade</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($schedules as $schedule)
                    <tr>
                        <td class="text-center">{{ $schedule->chosen_date->format('d/m/Y H:i') }}</td>
                        <td class="text-center">{{ $schedule->service->name ?? 'Serviço não especificado' }}</td>
                        <td class="text-center">{{ $schedule->unit->name ?? 'Unidade não especificada' }}</td> <!-- Exibir nome da unidade -->
                    </tr>
                @empty
                    <tr>
                        <td class="text-center" colspan="3">Nenhum agendamento encontrado.</td> <!-- Atualizado o colspan -->
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

@extends('Admin.Layout.main')

@section('title')
    Agendamentos
@endsection

@section('css')
    <style>
        .toast-success {
            background-color: #28a745 !important;
            color: #fff !important;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid">
        <h1 class="h3 mb-4 mt-4 text-gray-800">Agendamentos</h1>
        <!-- Filtro por data -->
        <div class="row mb-4">
            <div class="col-md-12">
                <form method="GET" action="{{ route('agendamentos.index') }}">
                    <div class="form-row align-items-end">
                        <div class="col">
                            <label for="start_date">Data de Início</label>
                            <input type="date" class="form-control" name="start_date" id="start_date" value="{{ $startDate }}">
                        </div>
                        <div class="col">
                            <label for="end_date">Data de Fim</label>
                            <input type="date" class="form-control" name="end_date" id="end_date" value="{{ $endDate }}">
                        </div>
                        <div class="col-auto">
                            <button type="submit" class="btn btn-primary">Filtrar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- Tabela de Agendamentos -->
        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="table">
                <thead class="thead" id="thead">
                <tr>
                    <th class="text-center">Data e Hora</th>
                    <th class="text-center">Serviço</th>
                    <th class="text-center">Unidade</th>
                    <th class="text-center">Nome do Cliente</th>
                    <th class="text-center">Email do Cliente</th>
                    <th class="text-center">Telefone do Cliente</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Ações</th>
                </tr>
                </thead>
                <tbody id="tbody">
                @forelse ($schedules as $schedule)
                    <tr>
                        <td class="text-center">{{ $schedule->chosen_date->format('d/m/Y H:i') }}</td>
                        <td class="text-center">{{ $schedule->service->name ?? 'Serviço não especificado' }}</td>
                        <td class="text-center">{{ $schedule->unit->name ?? 'Unidade não especificada' }}</td>
                        <td class="text-center">{{ $schedule->user->name ?? 'Cliente não especificado' }}</td>
                        <td class="text-center">{{ $schedule->user->email ?? 'Email não especificado' }}</td>
                        <td class="text-center">{{ $schedule->user->phone ?? 'Telefone não especificado' }}</td>
                        <td class="text-center">
                            <form class="update-status-form" data-schedule-id="{{ $schedule->id }}">
                                @csrf
                                @method('PATCH')
                                <select name="status_id" class="status-select" data-schedule-id="{{ $schedule->id }}">
                                    @foreach ($statuses as $status)
                                        <option value="{{ $status->id }}" {{ $schedule->status_id == $status->id ? 'selected' : '' }}>
                                            {{ $status->status }}
                                        </option>
                                    @endforeach
                                </select>
                            </form>
                        </td>
                        <td class="text-center">
                            <form action="{{ route('admin.schedules.destroy', $schedule->id) }}" method="POST" class="cancel-form">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-danger btn-sm cancel-button" data-schedule-id="{{ $schedule->id }}">Excluir</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="text-center" colspan="8">Nenhum agendamento encontrado.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <!-- Paginação -->
        <div class="d-flex justify-content-between align-items-center" id="pagination">
            <small>Mostrando de {{ $schedules->firstItem() }} a {{ $schedules->lastItem() }} de {{ $schedules->total() }} resultados</small>
            {{ $schedules->links('vendor.pagination.bootstrap-4') }}
        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            $('.status-select').on('change', function() {
                var scheduleId = $(this).data('schedule-id');
                var statusId = $(this).val();
                var token = $('meta[name="csrf-token"]').attr('content');

                $.ajax({
                    url: '/schedules/' + scheduleId + '/update-status',
                    type: 'PATCH',
                    data: {
                        _token: token,
                        status_id: statusId
                    },
                    success: function(response) {
                        if(response.success) {
                            toastr.success(response.success);
                        } else {
                            toastr.error('Erro ao atualizar o status.');
                        }
                    },
                    error: function(response) {
                        toastr.error('Erro ao atualizar o status.');
                    }
                });
            });

        });
    </script>
@endsection

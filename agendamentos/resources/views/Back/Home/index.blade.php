@extends('Back.Layout.main')

@section('title')
    {{ $title }}
@endsection

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
@endsection

@section('content')
    <div class="container-fluid">
        <div class="card mb-4 mt-4">
            <div class="card-header">
                <i class="fas fa-chart-bar"></i>
                Agendamentos por Serviço
            </div>
            <div class="card-body" id="card-body">
                <canvas id="schedulesChart"></canvas>
            </div>
        </div>
        <h1 class="h3 mb-4 mt-4 text-gray-800">{{ $title }}</h1>
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

            <!-- Modal de Confirmação -->
            <div class="modal fade" id="confirmCancelModal" tabindex="-1" role="dialog" aria-labelledby="confirmCancelModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-danger text-white">
                            <h5 class="modal-title" id="confirmCancelModalLabel">Confirmar Cancelamento</h5>
                            <button type="button" class="close" id="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="d-flex align-items-center">
                                <div class="mr-3">
                                    <i class="fas fa-exclamation-circle fa-3x text-danger"></i>
                                </div>
                                <div>
                                    <p class="mb-0">Tem certeza que deseja excluir este agendamento?</p>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" id="naoCancelButton" data-dismiss="modal">Não</button>
                            <button type="button" class="btn btn-danger" id="confirmCancelButton">Sim, Excluir</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-between align-items-center" id="pagination">
                <small>Mostrando de {{ $schedules->firstItem() }} a {{ $schedules->lastItem() }} de {{ $schedules->total() }} resultados</small>

                {{ $schedules->links('vendor.pagination.bootstrap-4') }}
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
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

            // AJAX para atualizar status
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
                        toastr.success(response.success);
                    },
                    error: function(response) {
                        toastr.error('Erro ao atualizar o status.');
                    }
                });
            });

            var cancelButtons = document.querySelectorAll('.cancel-button');
            var confirmCancelButton = document.getElementById('confirmCancelButton');
            var confirmCancelModal = new bootstrap.Modal(document.getElementById('confirmCancelModal'));
            var currentForm;

            cancelButtons.forEach(function(button) {
                button.addEventListener('click', function() {
                    var scheduleId = this.getAttribute('data-schedule-id');
                    currentForm = this.closest('form');
                    confirmCancelModal.show();
                });
            });

            confirmCancelButton.addEventListener('click', function() {
                if (currentForm) {
                    currentForm.submit();
                }
            });

            document.getElementById('naoCancelButton').addEventListener('click', function() {
                confirmCancelModal.hide();
            });
            document.getElementById('close').addEventListener('click', function() {
                confirmCancelModal.hide();
            });
        });
    </script>
@endsection

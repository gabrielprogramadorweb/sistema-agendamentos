@extends('Back.Layout.main')

@section('title')
    {{ $title }}
@endsection

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <style>
        .toast-success {
            background-color: #28a745 !important;
            color: #fff !important;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row mb-4 mt-4">
            <div class="col-md-4">
                <div class="card text-white bg-primary">
                    <div class="card-body">
                        <h5 class="card-title">Procedimento N° 1</h5>
                        <p class="card-text">{{ $mostRequestedProcedureName }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-secondary">
                    <div class="card-body">
                        <h5 class="card-title">Total Procedimentos</h5>
                        <p class="card-text">{{ $totalProcedures }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-success">
                    <div class="card-body">
                        <h5 class="card-title">Confirmados</h5>
                        <p class="card-text" id="confirmed-schedules">{{ $confirmedSchedules }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-12">
                <form method="GET" action="{{ route('home.index') }}">
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

        <div class="card mb-4 mt-4">
            <div class="card-header">
                <i class="fas fa-chart-bar"></i>
                Agendamentos por Serviço
            </div>
            <div class="card-body" id="card-body">
                <div id="schedulesBarChart"></div>
                <div id="schedulesPieChart" class="mt-4"></div>
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
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
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

            var barOptions = {
                series: [{
                    name: 'Agendamentos',
                    data: sortedData
                }],
                chart: {
                    type: 'bar',
                    height: 350
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '55%',
                        endingShape: 'rounded'
                    },
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    show: true,
                    width: 2,
                    colors: ['transparent']
                },
                xaxis: {
                    categories: sortedLabels,
                },
                yaxis: {
                    title: {
                        text: 'Número de Agendamentos'
                    }
                },
                fill: {
                    opacity: 1
                },
                tooltip: {
                    y: {
                        formatter: function (val) {
                            return val + " agendamentos"
                        }
                    }
                }
            };

            var barChart = new ApexCharts(document.querySelector("#schedulesBarChart"), barOptions);
            barChart.render();

            var pieOptions = {
                series: sortedData,
                chart: {
                    type: 'pie',
                    height: 350
                },
                labels: sortedLabels,
                responsive: [{
                    breakpoint: 480,
                    options: {
                        chart: {
                            width: 200
                        },
                        legend: {
                            position: 'bottom'
                        }
                    }
                }]
            };

            var pieChart = new ApexCharts(document.querySelector("#schedulesPieChart"), pieOptions);
            pieChart.render();

            // AJAX para atualizar status e atualizar confirmedSchedules
            $('.status-select').on('change', function() {
                var scheduleId = $(this).data('schedule-id');
                var statusId = $(this).val();
                var token = $('meta[name="csrf-token"]').attr('content');
                var startDate = $('#start_date').val();
                var endDate = $('#end_date').val();

                $.ajax({
                    url: '/schedules/' + scheduleId + '/update-status',
                    type: 'PATCH',
                    data: {
                        _token: token,
                        status_id: statusId,
                        start_date: startDate,
                        end_date: endDate
                    },
                    success: function(response) {
                        if(response.success) {
                            toastr.success(response.success);
                            $('#confirmed-schedules').text(response.confirmedSchedules);
                        } else {
                            toastr.error('Erro ao atualizar o status.');
                        }
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

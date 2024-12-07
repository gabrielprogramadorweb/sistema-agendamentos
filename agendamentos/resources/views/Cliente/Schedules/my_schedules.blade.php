@extends('Cliente.Layout.main')

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
                    <th class="text-center">Ações</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($schedules as $schedule)
                    <tr>
                        <td class="text-center">{{ $schedule->chosen_date->format('d/m/Y H:i') }}</td>
                        <td class="text-center">{{ $schedule->service->name ?? 'Serviço não especificado' }}</td>
                        <td class="text-center">{{ $schedule->unit->name ?? 'Unidade não especificada' }}</td>
                        <td class="text-center">
                            <form action="{{ route('schedules.destroy', $schedule->id) }}" method="POST" class="cancel-form">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-danger btn-sm cancel-button" data-schedule-id="{{ $schedule->id }}">Cancelar</button>
                            </form>
                        </td>
{{--                        <form action="{{ route('admin.schedules.destroy', $schedule->id) }}" method="POST" class="cancel-form">--}}
{{--                            @csrf--}}
{{--                            @method('DELETE')--}}
{{--                            <button type="button" class="btn btn-danger btn-sm cancel-button" data-schedule-id="{{ $schedule->id }}">Cancelar</button>--}}
{{--                        </form>--}}
                    </tr>
                @empty
                    <tr>
                        <td class="text-center" colspan="4">Nenhum agendamento encontrado.</td> <!-- Atualizado o colspan -->
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
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
                                <p class="mb-0">Tem certeza que deseja cancelar este agendamento?</p>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" id="naoCancelButton" data-dismiss="modal">Não</button>
                        <button type="button" class="btn btn-danger" id="confirmCancelButton">Sim, Cancelar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
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
    </script>
@endsection

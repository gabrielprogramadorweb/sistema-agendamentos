@extends('Back.Layout.main')

@section('title', $title)

@section('content')
    <div class="container-fluid">
        @if(session('success'))
            <div class="alert alert-success">
                {!! session('success') !!}
            </div>
        @endif
        @if(session('info'))
            <div class="alert alert-info">
                {{ session('info') }}
            </div>
        @endif
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">{{ $title }}</h6>
                <a href="{{ route('units.create') }}" class="btn btn-success btn-sm">Nova Unidade</a>
            </div>
            <div class="card-body">
                <form action="{{ route('units.index') }}" method="GET" class="mb-4">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Search by name..." value="{{ request('search') }}">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit">Search</button>
                        </div>
                    </div>
                </form>

                <div class="table-responsive">
                    @if($table->isEmpty)
                        <div class="alert alert-info">Não existem dados.</div>
                    @else
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                                @foreach($table->headers as $header)
                                    <th>{{ $header }}</th>
                                @endforeach
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($table->rows as $row)
                                <tr>
                                    @foreach($row as $key => $cell)
                                        <td>
                                            @if($key == 'actions')
                                                {!! $cell !!} <!-- Make sure this includes a call to setDeleteUrl passing the unit's ID -->
                                            @else
                                                {!! $cell !!}

                                            @endif
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                        <div class="d-flex justify-content-between align-items-center">
                            <small>Showing {{ $units->firstItem() }} to {{ $units->lastItem() }} of {{ $units->total() }} results</small>
                            {{ $units->links('vendor.pagination.bootstrap-4') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!-- Modals de confirmação de exclusão -->
    @foreach($units as $unit)
        <div class="modal fade" id="confirmDeleteModal{{ $unit->id }}" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalLabel">Confirmar Exclusão</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Tem certeza que deseja excluir esta unidade?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <form id="deleteForm{{ $unit->id }}" action="{{ route('units.destroy', ['id' => $unit->id]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Excluir</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection

@section('scripts')
    <script>
        function setDeleteUrl(element) {
            var id = element.getAttribute('data-id');
            var form = document.getElementById('deleteForm' + id); // Correctly append the id to match the form's ID
            form.action = '/super/units/' + id;
        }
    </script>
@endsection

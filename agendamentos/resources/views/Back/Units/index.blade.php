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
                                            @if($key == 'status')
                                                {!! $cell !!}
                                            @elseif($key == 'actions')
                                                {!! $cell !!}
                                            @else
                                                {{ $cell }}
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
@endsection

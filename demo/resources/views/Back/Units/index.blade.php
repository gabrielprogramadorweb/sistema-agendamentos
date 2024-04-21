@extends('Back.Layout.main')
@section('title')
    {{ $title }}
@endsection
@section('content')
    <div class="container-fluid">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">{{ $title }}</h6>
                <a href="{{ route('units.new') }}" class="btn btn-success btn-sm float-right">Nova</a>
            </div>
            <div class="card-body">
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
                                @foreach($row as $cell)
                                    <td>{{ $cell }}</td>
                                @endforeach
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif
    </div>
@endsection

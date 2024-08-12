@extends('Admin.Layout.main')

@section('title', $title)

@section('content')
    <div class="container-fluid mt-4">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>

                    @endforeach
                </ul>
            </div>
        @endif
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
                <a href="{{ route('units.index') }}" class="btn btn-secondary btn-sm">Voltar</a>
            </div>
            <div class="card-body">
                <form action="{{ route('units.services.store', $unit->id) }}" method="POST">
                    @csrf
                    <!-- Remove @method('PUT') or change to @method('POST') if it must be POST -->
                    <button type="submit" class="btn btn-sm btn-success">Salvar</button><br>
                    <button type="button" id="btnToggleAll" class="btn btn-sm btn-primary mt-2 mb-1">Marcar todos</button>
                    {!! $servicesOptions !!}
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.getElementById('btnToggleAll').addEventListener('click', function() {
            let checkboxes = document.querySelectorAll('input[type="checkbox"]');
            let allChecked = Array.from(checkboxes).every(checkbox => checkbox.checked);

            checkboxes.forEach(checkbox => {
                checkbox.checked = !allChecked;
            });
        });
    </script>
@endsection

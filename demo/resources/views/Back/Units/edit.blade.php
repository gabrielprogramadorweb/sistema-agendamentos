@extends('Back.Layout.main')

@section('title', $title)

@section('content')
    <div class="container">
        <h1>Editar Unidade</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('units.update', $unit->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="form-group col-md-3">
                    <label for="name">Nome:</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $unit->name) }}" required>
                </div>

                <div class="form-group col-md-3">
                    <label for="email">E-mail:</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $unit->email) }}" required>
                </div>

                <div class="form-group col-md-3">
                    <label for="phone">Telefone:</label>
                    <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone', $unit->phone) }}">
                </div>

                <div class="form-group col-md-3">
                    <label for="coordinator">Coordenador(a):</label>
                    <input type="text" class="form-control" id="coordinator" name="coordinator" value="{{ old('coordinator', $unit->coordinator) }}">
                </div>

                <div class="form-group col-md-3">
                    <label for="address">Endereço:</label>
                    <input type="text" class="form-control" id="address" name="address" value="{{ old('address', $unit->address) }}">
                </div>

                <div class="form-group col-md-3">
                    <label for="starttime">Início:</label>
                    <input type="time" class="form-control" id="starttime" name="starttime" value="{{ old('starttime', $unit->starttime) }}">
                </div>

                <div class="form-group col-md-3">
                    <label for="endtime">Fim:</label>
                    <input type="time" class="form-control" id="endtime" name="endtime" value="{{ old('endtime', $unit->endtime) }}">
                </div>

                <div class="form-group col-md-3">
                    <label for="servicetime">Tempo de serviço:</label>
                    <input type="number" class="form-control" id="servicetime" name="servicetime" value="{{ old('servicetime', $unit->servicetime) }}">
                </div>

                <div class="form-group col-md-3">
                    <label for="active">Ativo:</label>
                    <input type="checkbox" id="active" name="active" {{ $unit->active ? 'checked' : '' }}>
                </div>
                <div class="form-group col-md-10">
                    <button type="submit" class="btn btn-primary">Atualizar</button>
                </div>

            </div>

        </form>
    </div>
@endsection

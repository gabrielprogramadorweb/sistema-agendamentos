@extends('Back.Layout.main')

@section('title', $title)

@section('content')
    <div class="container mt-3">
        <h1>Criar novo registro</h1>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                        <li>{{ 'Erro ao criar registro!'}}</li>
                </ul>
            </div>
        @endif

        <form action="{{ route('units.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="form-group col-md-3">
                    <label for="name">Nome:</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                    @error('name')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group col-md-3">
                    <label for="email">E-mail:</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
                    @error('email')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group col-md-3">
                    <label for="password">Senha:</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                    @error('password')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group col-md-3">
                    <label for="phone">Telefone:</label>
                    <input type="text" class="form-control" id="phone" name="phone" placeholder="(00)00000-0000" value="{{ old('phone') }}" required>
                    @error('phone')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group col-md-3">
                    <label for="coordinator">Coordenador(a):</label>
                    <input type="text" class="form-control" id="coordinator" name="coordinator" value="{{ old('coordinator') }}"required>
                    @error('coordinator')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group col-md-3">
                    <label for="address">Endereço:</label>
                    <input type="text" class="form-control" id="address" name="address" value="{{ old('address') }}"required>
                    @error('address')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group col-md-3">
                    <label for="starttime">Início de expediente:</label>
                    <input type="time" class="form-control" id="starttime" name="starttime" value="{{ old('starttime') }}"required>
                    @error('starttime')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group col-md-3">
                    <label for="endtime">Fim de expediente:</label>
                    <input type="time" class="form-control" id="endtime" name="endtime" value="{{ old('endtime') }}"required>
                    @error('endtime')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="servicetime">Tempo de serviço:</label>
                    <select name="servicetime" id="servicetime" class="form-control"required>
                        <option value="">{{ '--Escolha o tempo--' }}</option>
                        @foreach ($serviceTimes as $key => $value)
                            <option value="{{ $key }}" {{ old('servicetime') == $key ? 'selected' : '' }}>
                                {{ $value }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group col-md-3">
                    <label for="active">Registro ativo</label>
                    <input type="hidden" name="active" value="0">
                    <input type="checkbox" id="active" name="active" value="1" {{ old('active', $unit->active ?? 0) ? 'checked' : '' }}>
                    @error('active')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group col-md-10">
                    <button type="submit" class="btn btn-primary">Criar</button>
                    <a href="{{ route('units.index') }}" class="btn btn-secondary">Voltar</a>
                </div>
            </div>
        </form>
    </div>
@endsection
@section('scripts')
<script>
    $(document).ready(function(){
        $('#phone').mask('(00) 00000-0000');
    });
</script>
@endsection

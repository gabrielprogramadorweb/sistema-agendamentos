@extends('Back.Layout.main')

@section('title', $title)

@section('content')
    <div class="container">
        <h1>Criar novo serviço</h1>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                        <li>{{ 'Erro ao criar registro!'}}</li>
                </ul>
            </div>
        @endif

        <form action="{{ route('services.store') }}" method="POST">
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
                    <label for="active">Ativo</label>
                    <input type="hidden" name="active" value="0">
                    <input type="checkbox" id="active" name="active" value="1" {{ old('active', $services->active ?? 0) ? 'checked' : '' }}>
                    @error('active')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group col-md-10">
                    <button type="submit" class="btn btn-primary">Criar</button>
                    <a href="{{ route('services.index') }}" class="btn btn-secondary">Voltar</a>
                </div>
            </div>

        </form>
    </div>
@endsection

<script>
    $(document).ready(function(){
        $('#phone').mask('(00) 00000-0000');
    });
</script>

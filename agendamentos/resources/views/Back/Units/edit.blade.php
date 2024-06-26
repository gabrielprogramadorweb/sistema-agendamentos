@extends('Back.Layout.main')

@section('title', $title)

@section('content')
    <div class="container" id="app">
        <success-modal :visible="showSuccessModal" :message="'Unidade atualizada com sucesso!'" @close="showSuccessModal = false"></success-modal>
        <h1>Editar Unidade</h1>
        @include('components.messages')
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
                    <label for="password">Senha:</label>
                    <input type="password" class="form-control" id="password" name="password" value="{{ old('password', $unit->password) }}" required>
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
                    <label for="starttime">Início de expediente:</label>
                    <input type="time" class="form-control" id="starttime" name="starttime" value="{{ old('starttime', $unit->starttime) }}">
                </div>

                <div class="form-group col-md-3">
                    <label for="endtime">Fim de expediente:</label>
                    <input type="time" class="form-control" id="endtime" name="endtime" value="{{ old('endtime', $unit->endtime) }}">
                </div>

                <div class="form-group col-md-3">
                    <label for="servicetime">Tempo de serviço:</label>
                    <select name="servicetime" id="servicetime" class="form-control">
                        @foreach ($serviceTimes as $key => $value)
                            <option value="{{ $key }}" {{ old('servicetime', $unit->servicetime ?? '') == $key ? 'selected' : '' }}>{{ $value }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="custom-control custom-checkbox">
                    <label for="active">Registro ativo</label>
                    <input type="hidden" name="active" value="0">
                    <input type="checkbox" id="active" name="active" value="1" {{ $unit->active ? 'checked' : '' }}>
                </div>
                <div class="form-group col-md-10">
                    <button type="submit" class="btn btn-primary">Salvar</button>
                    <a href="{{ route('units.index') }}" class="btn btn-secondary">Voltar</a>
                </div>
            </div>
        </form>
    </div>
@endsection

<script>
    const app = createApp({
        data() {
            return {
                showSuccessModal: @json(session('success') !== null)
            }
        }
    });
</script>


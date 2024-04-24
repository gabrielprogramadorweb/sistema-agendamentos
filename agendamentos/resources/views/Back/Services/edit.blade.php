@extends('Back.Layout.main')

@section('title', $title)

@section('content')
    <div class="container" id="app">
        <success-modal :visible="showSuccessModal" :message="'Unidade atualizada com sucesso!'" @close="showSuccessModal = false"></success-modal>
        <h1>Editar Unidade</h1>
        @include('components.messages')
        <form action="{{ route('services.update', $services->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="form-group col-md-3">
                    <label for="name">Nome:</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $services->name) }}" required>
                </div>

                <div class="custom-control custom-checkbox">
                    <label for="active">Ativo</label>
                    <input type="hidden" name="active" value="0">
                    <input type="checkbox" id="active" name="active" value="1" {{ $services->active ? 'checked' : '' }}>
                </div>
                <div class="form-group col-md-10">
                    <button type="submit" class="btn btn-primary">Salvar</button>
                    <a href="{{ route('services.index') }}" class="btn btn-secondary">Voltar</a>
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


@extends('Front.Layout.main')

@section('title')
    {{ $title }}
@endsection

@section('css')@endsection

@section('content')
    <div class="container pt-5 text-center">
        <h1 id="titulo" class="mt-5 ">Veja como é fácil criar o seu agendamento</h1>
        <div class="row mt-4">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        Primeiro
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Autentique-se</h5>
                        <p class="card-text">Realize o login ou crie a sua conta</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        Segundo
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Escolha a Unidade</h5>
                        <p class="card-text">Onde você gostaria de ser atendido</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        Terciro
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Escolha o Serviço</h5>
                        <p class="card-text">Serviço que deseja atendimento</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        Quarto
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Escolha a data</h5>
                        <p class="card-text">Escolha a melhor data e horário</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        Pronto
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Confirmação</h5>
                        <p class="card-text">Revise os dados e crie o agendamento</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-m-12">
                <a href="{{route('schedules.new')}}" class="btn btn-lg btn-primary">Criar agendamento</a>
            </div>
        </div>
    </div>

@endsection

@section('js')

@endsection

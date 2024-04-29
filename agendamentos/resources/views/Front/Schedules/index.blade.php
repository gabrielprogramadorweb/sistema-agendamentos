@extends('Front.Layout.main')

@section('title')
    {{ $title }}
@endsection

@section('content')
    <div class="container pt-5">
        <h1 class="mt-5">{{ $title }}</h1>
        <div id="boxErrors" class="mt-4 mb-3"></div>
        <div class="row">
            <div class="col-md-8">
                <div class="row">
                    <!-- Unidades -->
                    <div class="col-md-12 mb-4">
                        <p class="lead">Escolha uma Unidade</p>
                        <div>{!! $units !!}</div>
                    </div>
                    <!-- Serviços da unidade (inicialmente oculto) -->
                    <div id="mainBoxServices" class="col-md-8 mb-4 d-none">
                        <p class="lead">Escolha o Serviço</p>
                        <select class="form-select" id="boxServices"></select>
                    </div>
                    <!-- Mês (inicialmente oculto) -->
                    <div id="boxMonths" class="col-md-8 mb-4 d-none">
                        <p class="lead">Escolha o Mês</p>
                        <select id="month" class="form-select ">
                            <option value="">--- Escolha ---</option>
                            @foreach ($months as $key => $value)
                                <option value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                    <!-- Calendar -->
                    <div id="mainBoxCalendar" class="col-md-8 d-none mb-4"></div>
                        <p class="lead">Escolha o dia e o horário</p>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <div id="boxCalendar">

                                </div>
                            </div>

                            <div class="col-md-6 form-group">
                                <div id="boxHours">

                                </div>
                            </div>
                        </div>
                </div>
            </div>
            <!-- Preview das escolhas feitas -->
            <div class="col-md-4 ms-auto">
                <div class="preview-details">
                    <p class="lead mt-4">Unidade escolhida: <br><span id="chosenUnitText" class="text-muted small"></span></p>
                    <p class="lead">Serviço escolhido: <br><span id="chosenServiceText" class="text-muted small"></span></p>
                    <p class="lead">Mês escolhido: <br><span id="chosenMonthText" class="text-muted small"></span></p>
                    <p class="lead">Dia escolhido: <br><span id="chosenDayText" class="text-muted small"></span></p>
                    <p class="lead">Horário escolhido: <br><span id="chosenHourText" class="text-muted small"></span></p>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')

@endsection

@section('js')

@endsection


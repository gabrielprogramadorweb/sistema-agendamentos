@extends('Front.Layout.main')

@section('title')
    {{ $title }}
@endsection

@section('content')
    <div class="container pt-5">
        <h1 class="mt-5">{{ $title }}</h1>
        <div class="row">
            <div class="col-md-8">
                <div class="row">
                    <!-- Unidades -->
                    <div class="col-md-12 mb-4">
                        <p class="lead">Escolha uma Unidade</p>
                        <div>{!! $units !!}</div>
                    </div>
                    <!-- Serviços da unidade (inicialmente oculto) -->
                    <div id="mainBoxServices" class="col-md-12 mb-4 d-none">
                        <p class="lead">Escolha o Serviço</p>
                        <div id="boxServices"></div>
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

@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const mainBoxServices = document.getElementById('mainBoxServices');
            const chosenUnitText = document.getElementById('chosenUnitText');
            const units = document.querySelectorAll('input[name="unit_id"]');

            units.forEach(element => {
                element.addEventListener('click', (event) => {
                    mainBoxServices.classList.remove('d-none');
                    const unitName = element.getAttribute('data-name');
                    const unitAddress = element.getAttribute('data-address');
                    chosenUnitText.innerText = unitName + " - " + unitAddress;
                });
            });
        });
    </script>
@endsection

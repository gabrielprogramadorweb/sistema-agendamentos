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
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const URL_GET_SERVICES = '{{ route('get.unit.services', ['unitId' => ':unitId']) }}';
            const boxErrors = document.getElementById('boxErrors');
            const mainBoxServices = document.getElementById('mainBoxServices');
            const boxServices = document.getElementById('boxServices');
            const boxMonths = document.getElementById('boxMonths');
            const mainBoxCalendar = document.getElementById('mainBoxCalendar');
            const boxCalendar = document.getElementById('boxCalendar');
            const chosenUnitText = document.getElementById('chosenUnitText');
            const units = document.querySelectorAll('input[name="unit_id"]');
            const calendarContainer = document.getElementById('boxCalendar');

            function showErrorMessage(message) {
                return `<div class="alert alert-danger">${message}</div>`;
            }

            units.forEach(unit => {
                unit.addEventListener('click', function () {
                    mainBoxServices.classList.remove('d-none');
                    // redefine as opções dos meses
                    resetMonthOptions();
                    // redefine o calendário
                    resetBoxCalendar();
                    chosenUnitText.innerText = `${unit.getAttribute('data-name')} - ${unit.getAttribute('data-address')}`;
                    const url = URL_GET_SERVICES.replace(':unitId', unit.value);
                    fetchServices(url);
                });
            });

            calendarContainer.addEventListener('click', function(event) {
                if (event.target.classList.contains('clickable-day')) {
                    document.querySelectorAll('.clickable-day').forEach(button => {
                        button.style.backgroundColor = '#007bff';
                    });

                    event.target.style.backgroundColor = 'green';

                }
            });

            async function fetchServices(url) {
                try {
                    const response = await fetch(url, {
                        method: 'GET',
                        headers: { "X-Requested-With": "XMLHttpRequest" }
                    });

                    if (!response.ok) {
                        throw new Error(`HTTP error! Status: ${response.status}`);
                    }

                    const data = await response.json();
                    if (data.services) {
                        boxServices.innerHTML = data.services;
                        mainBoxServices.classList.remove('d-none');
                        boxServices.addEventListener('change', function(event) {
                            let serviceId = boxServices.value;
                            let serviceName = serviceId !== 'null' ? boxServices.options[event.target.selectedIndex].text : null;
                            chosenServiceText.innerText = serviceName === '--- Escolha ---' ? '' : serviceName;
                            serviceId !== '' ? boxMonths.classList.remove('d-none') : boxMonths.classList.add('d-none');
                        });
                    } else {
                        throw new Error("No services data found");
                    }
                } catch ( error) {
                    console.error('Error fetching services:', error);
                    boxErrors.innerHTML = showErrorMessage(`Não foi possível recuperar os Serviços. Error: ${error.message}`);
                }
            }

            document.getElementById('month').addEventListener('change', (event) => {
                const chosenMonthText = document.getElementById('chosenMonthText');
                const selectedOption = event.target.options[event.target.selectedIndex];
                chosenMonthText.innerText = selectedOption.text === '--- Escolha ---' ? '' : selectedOption.text;
                if(selectedOption.value !== '') {
                    getCalendar(selectedOption.value);
                }
            });

            const URL_GET_CALENDAR = '{{ route('get.calendar') }}';
            // mês
            const getCalendar = async (month) => {
                boxErrors.innerHTML = '';
                chosenDayText.innerText = '';
                resetBoxCalendar();
                const buttonsChosenDay = document.querySelectorAll('.btn-calendar-day');
                removeClassFromElements(buttonsChosenDay, 'btn-calendar-day-chosen');

                let url = `${URL_GET_CALENDAR}?month=${encodeURIComponent(month)}`;
                try {
                    const response = await fetch(url, {
                        method: 'GET',
                        headers: { "X-Requested-With": "XMLHttpRequest" }
                    });

                    if (!month){
                        resetMonthDataVariables();
                        resetBoxCalendar();
                        return;
                    }
                    if (!response.ok) {
                        throw new Error(`HTTP error! Status: ${response.status}`);
                    }

                    const data = await response.json();
                    mainBoxCalendar.classList.remove('d-none');
                    boxCalendar.innerHTML = data.calendar;

                    document.querySelectorAll('.btn-calendar-day:not([disabled])').forEach(button => {
                        button.addEventListener('click', function() {
                            boxHours.innerHTML = '<span class="text-info">Carregando as horas...</span>';
                            chosenDayText.innerText = this.getAttribute('data-day');
                            getHours();
                        });
                    });
                } catch (error) {
                    console.error('Fetch error:', error);
                    boxErrors.innerHTML = showErrorMessage('Erro ao conectar ao servidor.');
                }
            };
            // calendário
            const getHours = async () => {
                const URL_GET_HOURS = '{{ route('get.hours') }}';
                boxErrors.innerHTML = '';

                // Ensure that a unit has been selected
                const selectedUnit = document.querySelector('input[name="unit_id"]:checked');
                if (!selectedUnit) {
                    boxErrors.innerHTML = showErrorMessage('Você precisa escolher a Unidade de atendimento');
                    return;
                }

                const unitId = selectedUnit.value;
                const month = chosenMonthText.innerText;
                const day = chosenDayText.innerText;

                // Ensure month and day have been selected
                if (!month || !day) {
                    boxErrors.innerHTML = showErrorMessage('Você precisa selecionar um mês e um dia');
                    return;
                }

                // Construct URL with query parameters
                const url = `${URL_GET_HOURS}?unit_id=${unitId}&month=${encodeURIComponent(month)}&day=${day}`;

                try {
                    const response = await fetch(url, {
                        method: 'GET',
                        headers: { "X-Requested-With": "XMLHttpRequest" }
                    });

                    if (!response.ok) {
                        throw new Error(`HTTP error! Status: ${response.status}`);
                    }

                    const data = await response.json();
                    if (data.hours) {
                        boxHours.innerHTML = data.hours;
                        // Retrieve elements with the class '.btn-hour', which are the hour buttons
                        const buttonsBtnHours = document.querySelectorAll('.btn-hour');
                        // Iterate over them to add event listeners
                        buttonsBtnHours.forEach(element => {
                            element.addEventListener('click', (event) => {
                                // Remove the class and reset style from all buttons
                                removeClassFromElements(buttonsBtnHours, 'btn-hour-chosen');
                                // Add the class and change style only to the clicked button
                                event.target.classList.add('btn-hour-chosen');
                                event.target.style.backgroundColor = 'green'; // Change background to green
                                // Store the selected hour and display it
                                const chosenHour = event.target.dataset.hour;
                                const chosenHourText = document.getElementById('chosenHourText');
                                chosenHourText.innerText = chosenHour;
                            });
                        });
                    } else {
                        boxHours.innerHTML = showErrorMessage(`Não há horários disponíveis para o dia ${day}`);
                    }
                } catch (error) {
                    console.error('Fetch error:', error);
                    boxErrors.innerHTML = showErrorMessage('Erro ao conectar ao servidor.');
                }
            };

            // redefine as opções dos meses
            const resetMonthOptions = () => {
                console.log('Redefini as opções de meses...');
                // oculta a div dos meses
                boxMonths.classList.add('d-none');
                // volta para a opção '--- Escolha ---'
                document.getElementById('month').selectedIndex = 0;
                // nulamos esses campos
                resetMonthDataVariables();
            }

            // Redefini as variaveis pertinentes ao mês, dia, hora...
            const resetMonthDataVariables = () => {
                console.log('Redefini as variaveis pertinentes ao mês, dia, hora...');
                chosenMonth = null;
                chosenDay = null;
                chosenHour = null;
            }

            // Redefine o calendário
            const resetBoxCalendar = () => {
                console.log('Redefini o calendário...');
                mainBoxCalendar.classList.add('d-none');

                boxCalendar.innerHTML = '';
                boxHours.innerHTML    = '';
            }

            // Função para remover a classe e resetar a cor de fundo
            const removeClassFromElements = (elements, className) => {
                elements.forEach(element => {
                    element.classList.remove(className);
                    element.style.backgroundColor = '';
                });
            };

        });
    </script>
@endsection


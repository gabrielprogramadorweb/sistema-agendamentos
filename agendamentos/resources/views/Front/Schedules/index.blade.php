@extends('Front.Layout.main')

@section('title')
    {{ $title }}
@endsection

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="container pt-5">
        <h1 id="titulo" class="font-weight-bolder">{{ $title }}</h1>
        <img src="{{ asset('front/image/agendamento.png') }}" alt="Image" id="agendado" class="d-none">
        <div class="row">
            <div class="col-md-8">
                <div id="boxSuccess" class="mt-4 mb-3"></div>

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
                <div class="row" id='container'>
                    <div class="col-md-12 mb-4">
                        <p id='escUnidade' class="lead">Escolha uma Unidade</p>
                        <div id="unitsEsc" >{!! $units !!}</div>
                    </div>
                    <div id="mainBoxServices" class="col-md-8 mb-4 d-none">
                        <p class="lead">Escolha o Serviço</p>
                        <select class="form-select" id="boxServices"></select>
                    </div>
                    <div id="boxMonths" class="col-md-8 mb-4 d-none">
                        <p class="lead">Escolha o Mês</p>
                        <select id="month" class="form-select ">
                            <option value="">--- Escolha ---</option>
                            @foreach ($months as $key => $value)
                                <option value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div id="mainBoxCalendar" class="col-md-8 d-none mb-4"></div>
                    <p id='escHorario' class="lead">Escolha o dia e o horário</p>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <div id="boxCalendar">

                            </div>
                        </div>

                        <div class="col-md-6 form-group">
                            <div id="boxHours">

                            </div>
                        </div>
                        <div id="boxErrors" class="mt-4 mb-3"></div>

                        <div class="col-md-12 border-top pt-4">
                            <button id="btnTryCreate" class="btn btn-primary disabled">Criar meu agendamento</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4 ms-auto">
                <div id="divRight" class="preview-details">
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
            const URL_CREATION_SCHEDULE = '{{ route('create.schedule') }}';
            const URL_GET_CALENDAR = '{{ route('get.calendar') }}';
            const btnTryCreate = document.getElementById('btnTryCreate');
            const boxErrors = document.getElementById('boxErrors');
            const boxSuccess = document.getElementById('boxSuccess');
            const mainBoxServices = document.getElementById('mainBoxServices');
            const boxServices = document.getElementById('boxServices');
            const boxMonths = document.getElementById('boxMonths');
            const mainBoxCalendar = document.getElementById('mainBoxCalendar');
            const boxCalendar = document.getElementById('boxCalendar');
            const chosenUnitText = document.getElementById('chosenUnitText');
            const units = document.querySelectorAll('input[name="unit_id"]');
            const calendarContainer = document.getElementById('boxCalendar');
            let chosenMonth = null, chosenDay = null, chosenHour = null;
            let csrfTokenValue = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            let selectedUnitId = null;

            function showErrorMessage(message) {
                return `<div class="alert alert-danger">${message}</div>`;
            }
            function showSuccessesMessage(message) {
                return `<div class="alert alert-success">${message}</div>`;
            }

            function hideInputFields() {
                const ids = [
                    'mainBoxServices', 'boxServices', 'boxMonths', 'mainBoxCalendar',
                    'boxCalendar', 'boxHours', 'escHorario', 'divRight', 'container',
                    'titulo', 'btnTryCreate', 'boxSuccess'
                ];
                ids.forEach(id => {
                    const element = document.getElementById(id);
                    if (element) {
                        element.style.display = 'none';
                        agendado.classList.remove('d-none');
                    }
                });
            }

            units.forEach(unit => {
                unit.addEventListener('click', function () {
                    boxErrors.innerHTML = ''
                    mainBoxServices.classList.remove('d-none');
                    resetMonthOptions();
                    selectedUnitId = unit.value;
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
                    chosenDay = event.target.getAttribute('data-day'); // Assign the chosen day
                }
            });

            async function fetchServices(url) {
                try {
                    const response = await fetch(url, {
                        method: 'GET',
                        headers: {
                            "Content-Type": "application/json",
                            "X-Requested-With": "XMLHttpRequest",
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }

                    });

                    if (!response.ok) {
                        throw new Error(`HTTP error! Status: ${response.status}`);
                    }

                    const data = await response.json();
                    if (data.services) {
                        boxErrors.innerHTML = ''
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

            const formatWithTwoDigits = number => number.toString().padStart(2, '0');

            document.getElementById('month').addEventListener('change', (event) => {
                const chosenMonthText = document.getElementById('chosenMonthText');
                const selectedOption = event.target.options[event.target.selectedIndex];
                chosenMonthText.innerText = selectedOption.text === '--- Escolha ---' ? '' : selectedOption.text;
                chosenMonth = formatWithTwoDigits(event.target.value);
                if(selectedOption.value !== '') {
                    getCalendar(selectedOption.value);
                }
            });

            btnTryCreate.addEventListener('click', async (event) => {
                let formData = new FormData();
                formData.append('unit_id', selectedUnitId);
                formData.append('service_id', boxServices.value);
                formData.append('month', chosenMonth);
                formData.append('day', chosenDay);
                formData.append('hour', chosenHour);
                formData.append('_token', csrfTokenValue);
                event.preventDefault();

                if (!units.length) {
                    boxErrors.innerHTML = showErrorMessage('Escolha a Unidade');
                    return;
                }

                if (!boxServices.value) {
                    boxErrors.innerHTML = showErrorMessage('Escolha o Serviço');
                    return;
                }


                if (!chosenHour) {
                    boxErrors.innerHTML = showErrorMessage('Por favor, selecione uma hora.');
                    return;
                }

                const serviceId = boxServices.value;
                btnTryCreate.disabled = true;
                btnTryCreate.innerText = 'Estamos criando o seu agendamento...';
                const url = 'http://localhost/api/agendamentos';
                const requestData = {
                    unitId: selectedUnitId,
                    serviceId: serviceId,
                    month: chosenMonth,
                    day: chosenDay,
                    hour: chosenHour
                };
                try {
                    const unitId = document.querySelector('input[name="unit_id"]:checked').value;
                    const serviceId = boxServices.value;

                    const body = {
                        unit_id: parseInt(selectedUnitId),
                        service_id: parseInt(boxServices.value),
                        month: chosenMonth.toString().padStart(2, '0'),
                        day: chosenDay.toString().padStart(2, '0'),
                        hour: chosenHour.toString() + ':00',
                        _token: csrfTokenValue
                    };

                    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                    const response = await fetch(URL_CREATION_SCHEDULE, {
                        method: 'POST',
                        headers: {
                            "Content-Type": "application/json",
                            "X-Requested-With": "XMLHttpRequest",
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },

                        body: JSON.stringify(body), formData
                    });

                    if (!response.ok) {
                        btnTryCreate.disabled = false;
                        btnTryCreate.innerText = 'Criar meu agendamento';

                        if (response.status === 400) {
                            const data = await response.json();
                            const errors = data.errors;
                            csrfTokenValue = data.token;
                            let message = Object.keys(errors).map(field => errors[field]).join(', ');
                            boxErrors.innerHTML = showErrorMessage(message);
                            return;
                        }

                        boxErrors.innerHTML = showErrorMessage('Não foi possível criar o seu agendamento');
                        throw new Error(`HTTP error! Status: ${response.status}`);
                    }

                    const data = await response.json();

                    if (data.success) {
                        boxSuccess.innerHTML = showSuccessesMessage('Agendamento criado com sucesso!');
                        hideInputFields();
                    } else {
                        throw new Error(data.message || 'Erro ao criar o agendamento.');
                    }

                } catch (error) {
                    console.error('Error creating schedule:', error);
                    boxErrors.innerHTML = showErrorMessage('Já existe uma programação com a data e hora especificadas. ');
                }
            });

            //-----------------------FUNÇÕES------------------------------------//
            const tryCreateSchedule = async () => {
                boxErrors.innerHTML = '';
                const body = {
                    unit_id    : unitId,
                    service_id  : serviceId,
                    month      : chosenMonth,
                    day        : chosenDay,
                    hour       : chosenHour
                };

                body[csrfTokenName] = csrfTokenValue;

                const response = await fetch(URL_CREATION_SCHEDULE, {
                    method: 'POST',
                    headers: {
                        "Content-Type": "application/json",
                        "X-Requested-With": "XMLHttpRequest",
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                    ,
                    body: JSON.stringify(body)
                });

                if (!response.ok) {
                    if (response.status === 400){

                        const data = await response.json();
                        const errors = data.errors;
                        csrfTokenValue = data.token;
                        let message = Object.keys(errors).map(field => errors[field]).join(', ');
                        boxErrors.innerHTML = showErrorMessage(message);
                        return;
                    }
                    boxErrors.innerHTML = showErrorMessage('Não foi possivel criar o seu agendamento');
                    throw new Error(`HTTP error! Status: ${response.status}`);
                }
                window.location.href = window.location.href;

            };

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
                        headers: {
                            "Content-Type": "application/json",
                            "X-Requested-With": "XMLHttpRequest",
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }

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

            const getHours = async () => {
                const URL_GET_HOURS = '{{ route('get.hours') }}';
                boxErrors.innerHTML = '';

                const selectedUnit = document.querySelector('input[name="unit_id"]:checked');
                if (!selectedUnit) {
                    boxErrors.innerHTML = showErrorMessage('Você precisa escolher a Unidade de atendimento');
                    return;
                }

                const unitId = selectedUnit.value;
                const month = chosenMonthText.innerText;
                const day = chosenDayText.innerText;

                if (!month || !day) {
                    boxErrors.innerHTML = showErrorMessage('Você precisa selecionar um mês e um dia');
                    return;
                }

                const url = `${URL_GET_HOURS}?unit_id=${unitId}&month=${encodeURIComponent(month)}&day=${day}`;

                try {
                    const response = await fetch(url, {
                        method: 'GET',
                        headers: {
                            "Content-Type": "application/json",
                            "X-Requested-With": "XMLHttpRequest",
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }

                    });

                    if (!response.ok) {
                        throw new Error(`HTTP error! Status: ${response.status}`);
                    }

                    const data = await response.json();
                    if (data.hours) {
                        boxHours.innerHTML = data.hours;
                        const buttonsBtnHours = document.querySelectorAll('.btn-hour');
                        buttonsBtnHours.forEach(element => {
                            element.addEventListener('click', (event) => {
                                buttonsBtnHours.forEach(btn => {
                                    btn.classList.remove('btn-hour-chosen');
                                    btnTryCreate.classList.remove('disabled');

                                    btn.style.backgroundColor = ''; // Remove any special coloring
                                });
                                event.target.classList.add('btn-hour-chosen');
                                event.target.style.backgroundColor = 'green'; // Highlight selected hour
                                chosenHour = event.target.dataset.hour; // Store the selected hour
                                const chosenHourText = document.getElementById('chosenHourText');
                                chosenHourText.innerText = chosenHour; // Display the selected hour
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

            const resetMonthOptions = () => {
                console.log('Redefini as opções de meses...');
                boxMonths.classList.add('d-none');
                document.getElementById('month').selectedIndex = 0;
                resetMonthDataVariables();
            }

            const resetMonthDataVariables = () => {
                console.log('Redefini as variaveis pertinentes ao mês, dia, hora...');
                chosenMonth = null;
                chosenDay = null;
                chosenHour = null;
            }

            const resetBoxCalendar = () => {
                console.log('Redefini o calendário...');
                mainBoxCalendar.classList.add('d-none');

                boxCalendar.innerHTML = '';
                boxHours.innerHTML    = '';
            }

            const removeClassFromElements = (elements, className) => {
                elements.forEach(element => {
                    element.classList.remove(className);
                    element.style.backgroundColor = '';
                });
            };

        });
    </script>
@endsection

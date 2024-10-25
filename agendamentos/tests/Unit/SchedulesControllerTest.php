<?php

use App\Http\Controllers\SchedulesController;
use App\Services\SchedulesService;
use App\Services\CalendarService;
use App\Services\UnitAvaiableHoursService;

it('returns the correct view for index method', function () {
    // Mock dos serviços
    $schedulesServiceMock = mock(SchedulesService::class);
    $calendarServiceMock = mock(CalendarService::class);
    $unitAvaiableHoursServiceMock = mock(UnitAvaiableHoursService::class);

    // Configurações dos mocks
    $schedulesServiceMock->shouldReceive('renderUnits')->andReturn(['Unit 1', 'Unit 2']);
    $calendarServiceMock->shouldReceive('renderMonths')->andReturn(['January', 'February']);

    // Instância do controller
    $controller = new SchedulesController($unitAvaiableHoursServiceMock, $schedulesServiceMock, $calendarServiceMock);

    // Chamada do método index
    $response = $controller->index();

    // Verificações
    expect($response->getName())->toBe('Front.Schedules.index');
    expect($response->getData())->toHaveKey('title', 'Criar agendamento');
    expect($response->getData())->toHaveKey('units');
    expect($response->getData())->toHaveKey('months');
});

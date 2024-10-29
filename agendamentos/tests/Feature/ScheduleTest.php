<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;
use App\Models\Schedule;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Carbon\Carbon;

class ScheduleTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_schedules_data_returns_correct_data()
    {
        $startDate = Carbon::now()->subDays(7);
        $endDate = Carbon::now();

        Schedule::factory()->create([
            'chosen_date' => $startDate->copy()->addDay(),
            'service_name' => 'Limpeza',
        ]);

        Schedule::factory()->create([
            'chosen_date' => $startDate->copy()->addDays(2),
            'service_name' => 'Limpeza',
        ]);

        Schedule::factory()->create([
            'chosen_date' => $startDate->copy()->addDays(3),
            'service_name' => 'Consulta Inicial',
        ]);

        $result = $this->app->call([$this, 'getSchedulesData'], [
            'startDate' => $startDate,
            'endDate' => $endDate,
        ]);

        $this->assertEquals(['Limpeza', 'Consulta Inicial'], $result['labels']);
        $this->assertEquals([2, 1], $result['data']);
    }

    public function test_index_loads_correctly()
    {
        $response = $this->get(route('schedules.index'));

        $response->assertStatus(200);
        $response->assertViewIs('Front.Schedules.index');
        $response->assertViewHasAll(['title', 'units', 'months']);
    }

    public function test_unit_services_returns_services()
    {
        $unitId = 1;
        $response = $this->json('GET', route('schedules.unitServices', ['unitId' => $unitId]));

        $response->assertStatus(200);
        $response->assertJsonStructure(['services']);
    }

    public function test_get_calendar_returns_calendar_data()
    {
        $response = $this->json('GET', route('schedules.getCalendar'), ['month' => 1]);

        $response->assertStatus(200);
        $response->assertJsonStructure(['calendar']);
    }

    public function test_get_hours_returns_available_hours()
    {
        $response = $this->json('GET', route('schedules.getHours'), [
            'unit_id' => 1,
            'month' => 1,
            'day' => 15,
            'service_id' => 1,
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure(['hours']);
    }

    public function test_create_schedule_creates_and_sends_notification()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->postJson(route('schedules.createSchedule'), [
            'unit_id' => 1,
            'service_id' => 1,
            'month' => '07',
            'day' => '15',
            'hour' => '10:30',
        ]);

        $response->assertStatus(200);
        $response->assertJson(['success' => true, 'message' => 'Agendamento criado com sucesso!']);
    }

    public function test_destroy_schedule_deletes_schedule()
    {
        $schedule = Schedule::factory()->create();

        $response = $this->delete(route('schedules.destroy', $schedule->id));

        $response->assertRedirect(route('meus-agendamentos'));
        $this->assertDatabaseMissing('schedules', ['id' => $schedule->id]);
    }

    public function test_show_user_schedules_loads_correctly()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(route('schedules.mySchedules'));

        $response->assertStatus(200);
        $response->assertViewIs('Front.Schedules.my_schedules');
        $response->assertViewHas('schedules');
    }

}


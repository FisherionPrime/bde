<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\Student;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ParticipantTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_users_can_view_participants_with_activity_count(): void
    {
        $participant = Student::create([
            'first_name' => 'Ada',
            'last_name' => 'Lovelace',
            'email' => 'ada@example.com',
            'class_name' => 'B3 Informatique',
        ]);
        $event = Event::create([
            'name' => 'Atelier code', 'color' => '#f7521c', 'event_date' => '2026-10-01',
        ]);
        $participant->events()->attach($event);

        $this->actingAs(User::factory()->create(['role' => 'user']))
            ->get(route('participants.index'))
            ->assertOk()
            ->assertSee('Lovelace')
            ->assertSee('Ada')
            ->assertSee('B3 Informatique')
            ->assertSee('1');
    }

    public function test_only_admins_can_manage_participants(): void
    {
        $user = User::factory()->create(['role' => 'user']);

        $this->actingAs($user)
            ->get(route('participants.create'))
            ->assertForbidden();

        $this->actingAs(User::factory()->create(['role' => 'admin']))
            ->post(route('participants.store'), [
                'first_name' => 'Grace',
                'last_name' => 'Hopper',
                'class_name' => 'M2 Data',
                'email' => 'grace@example.com',
            ])
            ->assertRedirect(route('participants.index'));

        $this->assertDatabaseHas('students', [
            'first_name' => 'Grace',
            'last_name' => 'Hopper',
            'class_name' => 'M2 Data',
        ]);
    }
}

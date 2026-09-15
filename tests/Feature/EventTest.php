<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\Student;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class EventTest extends TestCase
{
    use RefreshDatabase;

    public function test_non_admins_do_not_see_the_new_event_button(): void
    {
        $this->actingAs(User::factory()->create(['role' => 'user']))
            ->get('/')
            ->assertOk()
            ->assertDontSee('Nouvel événement');
    }

    public function test_guests_do_not_see_or_access_event_creation(): void
    {
        $this->get('/')
            ->assertRedirect(route('auth.login'))
            ->assertDontSee('Nouvel événement');

        $this->get(route('events.create'))
            ->assertRedirect(route('auth.login'))
            ->assertSessionHas('url.intended', route('events.create'));
    }

    public function test_admin_can_create_an_event(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $student = Student::create([
            'first_name' => 'Ada',
            'last_name' => 'Lovelace',
            'email' => 'ada@example.com',
            'class_name' => 'B3 Informatique',
        ]);

        $this->actingAs($admin)
            ->get(route('events.create'))
            ->assertOk()
            ->assertSee('Créer un événement');

        $this->actingAs($admin)
            ->get(route('index'))
            ->assertOk()
            ->assertSee(route('events.create'));

        $this->actingAs($admin)
            ->post(route('events.store'), [
                'name' => 'Soirée de rentrée',
                'color' => '#f7521c',
                'event_date' => '2026-10-01',
                'student_ids' => [$student->id],
            ])
            ->assertRedirect(route('events.show', Event::query()->first()));

        $event = Event::query()->first();

        $this->assertNotNull($event);
        $this->assertSame('Soirée de rentrée', $event->name);
        $this->assertSame('#f7521c', $event->color);
        $this->assertSame('2026-10-01', $event->event_date->format('Y-m-d'));
        $this->assertTrue($event->students->contains($student));
    }

    public function test_homepage_shows_three_events_and_full_page_shows_all_events(): void
    {
        foreach (range(1, 4) as $number) {
            Event::create([
                'name' => 'Événement '.$number,
                'color' => '#f7521c',
                'event_date' => '2026-10-0'.$number,
            ]);
        }

        $user = User::factory()->create(['role' => 'user']);

        $this->actingAs($user)
            ->get('/')
            ->assertOk()
            ->assertSee('Événement 1')
            ->assertSee('Événement 3')
            ->assertDontSee('Événement 4')
            ->assertSee('Voir plus d’événements');

        $this->actingAs($user)
            ->get(route('events.index'))
            ->assertOk()
            ->assertSee('Événement 4');
    }

    public function test_event_list_separates_archived_events_and_shows_participant_count(): void
    {
        $pastEvent = Event::create([
            'name' => 'Événement terminé',
            'color' => '#f7521c',
            'event_date' => Carbon::yesterday()->format('Y-m-d'),
        ]);
        $futureEvent = Event::create([
            'name' => 'Événement à venir',
            'color' => '#f7521c',
            'event_date' => Carbon::tomorrow()->format('Y-m-d'),
        ]);
        $pastEvent->students()->attach(Student::create([
            'first_name' => 'Élodie',
            'last_name' => 'Durand',
            'email' => 'elodie@example.com',
            'class_name' => 'B3',
        ]));

        $this->actingAs(User::factory()->create(['role' => 'user']))
            ->get(route('events.index'))
            ->assertOk()
            ->assertSee('Événements à venir')
            ->assertSee('Archives')
            ->assertSee('1 participant(s)')
            ->assertSee('Événement terminé')
            ->assertSee('Événement à venir');
    }

    public function test_event_list_can_be_searched(): void
    {
        Event::create(['name' => 'Soirée cinéma', 'color' => '#f7521c', 'event_date' => Carbon::tomorrow()->format('Y-m-d')]);
        Event::create(['name' => 'Tournoi sportif', 'color' => '#f7521c', 'event_date' => Carbon::tomorrow()->format('Y-m-d')]);

        $this->actingAs(User::factory()->create(['role' => 'user']))
            ->get(route('events.index', ['q' => 'cinéma']))
            ->assertOk()
            ->assertSee('Soirée cinéma')
            ->assertDontSee('Tournoi sportif');
    }
}

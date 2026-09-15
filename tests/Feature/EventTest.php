<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
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

    public function test_admin_can_create_an_event(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)
            ->get(route('events.create'))
            ->assertOk()
            ->assertSee('Créer un événement');

        $this->actingAs($admin)
            ->post(route('events.store'), [
                'name' => 'Soirée de rentrée',
                'color' => '#f7521c',
                'event_date' => '2026-10-01',
            ])
            ->assertRedirect(route('index'));

        $event = Event::query()->first();

        $this->assertNotNull($event);
        $this->assertSame('Soirée de rentrée', $event->name);
        $this->assertSame('#f7521c', $event->color);
        $this->assertSame('2026-10-01', $event->event_date->format('Y-m-d'));
    }
}

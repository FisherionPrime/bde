<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\Student;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class ParticipantTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_users_can_view_participants_with_activity_count(): void
    {
        $participant = Student::create([
            'first_name' => 'Ada',
            'last_name' => 'Lovelace',
            'email' => 'elodie@example.com',
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

    public function test_admins_can_import_participants_from_a_spreadsheet(): void
    {
        $file = UploadedFile::fake()->createWithContent(
            'participants.csv',
            "prenom,nom,classe,email\nÉlodie,Durand,B3 Informatique,elodie@example.com\n"
        );

        $this->actingAs(User::factory()->create(['role' => 'admin']))
            ->post(route('participants.import'), ['file' => $file])
            ->assertRedirect(route('participants.index'));

        $this->assertDatabaseHas('students', [
            'first_name' => 'Élodie',
            'last_name' => 'Durand',
            'class_name' => 'B3 Informatique',
                'email' => 'elodie@example.com',
        ]);
    }

    public function test_authenticated_users_can_export_participants_as_pdf(): void
    {
        Student::create([
            'first_name' => 'Ada',
            'last_name' => 'Lovelace',
            'email' => 'ada@example.com',
            'class_name' => 'B3 Informatique',
        ]);

        $this->get(route('participants.export'))
            ->assertRedirect(route('auth.login'));

        $this->actingAs(User::factory()->create(['role' => 'user']))
            ->get(route('participants.export'))
            ->assertOk()
            ->assertHeader('content-type', 'application/pdf')
            ->assertHeader('content-disposition', 'attachment; filename=participants-bde.pdf');
    }

    public function test_participant_list_can_be_searched(): void
    {
        Student::create([
            'first_name' => 'Élodie',
            'last_name' => 'Durand',
            'email' => 'elodie@example.com',
            'class_name' => 'B3 Informatique',
        ]);
        Student::create([
            'first_name' => 'Marc',
            'last_name' => 'Martin',
            'email' => 'marc@example.com',
            'class_name' => 'M2 Data',
        ]);

        $this->actingAs(User::factory()->create(['role' => 'user']))
            ->get(route('participants.index', ['q' => 'Durand']))
            ->assertOk()
            ->assertSee('Élodie')
            ->assertDontSee('Marc');
    }
}

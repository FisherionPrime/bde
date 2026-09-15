<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return array<string, string>
     */
    private function registrationPayload(array $overrides = []): array
    {
        return array_merge([
            'first_name' => 'Ada',
            'last_name' => 'Lovelace',
            'class_name' => 'B3 Informatique',
            'email' => 'ada@example.com',
            'password' => 'motdepasse',
            'password_confirmation' => 'motdepasse',
        ], $overrides);
    }

    public function test_registration_rejects_an_email_already_taken(): void
    {
        User::factory()->create(['email' => 'ada@example.com']);

        $this->post(route('auth.register.store'), $this->registrationPayload())
            ->assertRedirect()
            ->assertSessionHasErrors('email');

        $this->assertSame(1, User::where('email', 'ada@example.com')->count());
    }

    public function test_registration_requires_a_password_of_at_least_eight_characters(): void
    {
        $this->post(route('auth.register.store'), $this->registrationPayload([
            'password' => 'court',
            'password_confirmation' => 'court',
        ]))->assertSessionHasErrors('password');

        $this->assertDatabaseMissing('users', ['email' => 'ada@example.com']);
    }

    public function test_registration_stores_a_hashed_password(): void
    {
        $this->post(route('auth.register.store'), $this->registrationPayload())
            ->assertRedirect(route('auth.login'));

        $user = User::where('email', 'ada@example.com')->firstOrFail();

        $this->assertNotSame('motdepasse', $user->password);
        $this->assertTrue(Hash::check('motdepasse', $user->password));
    }

    public function test_authenticated_users_cannot_reach_the_login_and_register_pages(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->get(route('auth.login'))->assertRedirect('/');
        $this->actingAs($user)->get(route('auth.register'))->assertRedirect('/');
    }

    public function test_logout_clears_the_session_and_returns_to_the_login_page(): void
    {
        $this->actingAs(User::factory()->create())
            ->post(route('auth.logout'))
            ->assertRedirect(route('auth.login'));

        $this->assertGuest();
    }
}

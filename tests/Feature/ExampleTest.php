<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     */
    public function test_guests_are_redirected_to_login_from_the_homepage(): void
    {
        $response = $this->get('/');

        $response->assertRedirect(route('auth.login'));
    }

    public function test_admins_can_manage_bde_accounts(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $member = User::factory()->create(['role' => 'user']);

        $this->actingAs($admin)
            ->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee($member->email);

        $this->actingAs($admin)
            ->patch(route('admin.users.role', $member), ['role' => 'admin'])
            ->assertRedirect();

        $this->assertDatabaseHas('users', ['id' => $member->id, 'role' => 'admin']);

        $this->actingAs($admin)
            ->delete(route('admin.users.destroy', $member))
            ->assertRedirect();

        $this->assertDatabaseMissing('users', ['id' => $member->id]);
    }

    public function test_admin_cannot_delete_themselves_or_remove_the_last_admin(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)
            ->delete(route('admin.users.destroy', $admin))
            ->assertSessionHasErrors('user');

        $this->actingAs($admin)
            ->patch(route('admin.users.role', $admin), ['role' => 'user'])
            ->assertSessionHasErrors('user');

        $this->assertDatabaseHas('users', ['id' => $admin->id, 'role' => 'admin']);
    }
}

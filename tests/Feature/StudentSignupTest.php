<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class StudentSignupTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_view_registration_page(): void
    {
        $this->get(route('register'))
            ->assertOk()
            ->assertSee('Create Aspirant Account')
            ->assertSee('Full Name')
            ->assertSee('Email Address')
            ->assertSee('Password')
            ->assertSee('Confirm Password')
            ->assertSee('Create Student Account');

        $this->get('/signup')
            ->assertOk()
            ->assertSee('Create Aspirant Account');
    }

    public function test_login_page_contains_link_to_registration(): void
    {
        $this->get(route('login'))
            ->assertOk()
            ->assertSee(route('register'))
            ->assertSee('Sign Up here');
    }

    public function test_registration_requires_valid_fields(): void
    {
        $this->post(route('register'), [])
            ->assertSessionHasErrors(['name', 'email', 'password']);
    }

    public function test_registration_requires_unique_email(): void
    {
        User::factory()->create([
            'email' => 'existing@loksewa.test',
        ]);

        $this->post(route('register'), [
            'name' => 'Duplicate User',
            'email' => 'existing@loksewa.test',
            'password' => 'secret123',
            'password_confirmation' => 'secret123',
        ])->assertSessionHasErrors(['email']);
    }

    public function test_registration_requires_password_confirmation_and_minimum_length(): void
    {
        $this->post(route('register'), [
            'name' => 'Test User',
            'email' => 'test@loksewa.test',
            'password' => 'short',
            'password_confirmation' => 'mismatch',
        ])->assertSessionHasErrors(['password']);
    }

    public function test_student_can_register_and_is_redirected_to_dashboard_with_role(): void
    {
        $response = $this->post(route('register'), [
            'name' => 'Aakash Shrestha',
            'email' => 'aakash@loksewa.test',
            'password' => 'passkey12345',
            'password_confirmation' => 'passkey12345',
        ]);

        $response->assertRedirect(route('dashboard'));

        $this->assertDatabaseHas('users', [
            'name' => 'Aakash Shrestha',
            'email' => 'aakash@loksewa.test',
        ]);

        $user = User::where('email', 'aakash@loksewa.test')->first();
        $this->assertNotNull($user);
        $this->assertTrue(Hash::check('passkey12345', $user->password));
        $this->assertTrue($user->hasRole('user'));
        $this->assertEquals(Auth::id(), $user->id);
    }
}

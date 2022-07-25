<?php

namespace Http\Controllers\Auth;

use App\Http\Controllers\Auth\RegisterController;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Logged user should be redirected to the home page
     *
     * @return void
     */
    public function test_logged_user_should_be_redirected_to_home()
    {
        $user = User::factory()->create();

        $this->actingAs($user)->get('/register')->assertRedirect('/me');
    }

    /**
     * Guest can register
     *
     * @return void
     */
    public function test_guest_can_register()
    {
        $userData = [
            'name' => 'John Doe',
            'email' => 'john@test.com',
            'birth_date' => '2000-01-01',
            'phone_number' => '+5511999999999',
            'document_id' => '99999999999',
        ];

        $registrationUserData = $userData;
        $registrationUserData['password'] = 'password';
        $registrationUserData['password_confirmation'] = $registrationUserData['password'];

        $this->post('/register', $registrationUserData)->assertRedirect('/me');
        $this->assertDatabaseHas('users', $userData);
    }

    /**
     * Guest can not register with invalid data
     *
     * @return void
     */
    public function test_guest_can_not_register_with_invalid_data()
    {
        $userToBeRegistered = [
            'name' => 'John Doe',
            'email' => 'john@test.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'birth_date' => '2000-01-01',
            'phone_number' => '+5511999999999',
            'document_id' => '999.999.999-99', // Same document_id but with different format
        ];

        User::factory()->create(['document_id' => '99999999999']); // Create a user with the same document_id

        $this->post('/register', $userToBeRegistered)->assertSessionHasErrors(['document_id']);
    }
}

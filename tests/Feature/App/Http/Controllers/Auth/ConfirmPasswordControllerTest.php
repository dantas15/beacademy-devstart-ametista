<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ConfirmPasswordControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test redirect to home page if user is authenticated.
     *
     * @return void
     */
    public function test_user_should_return_status_200()
    {
        $user = User::factory()->create();

        $this->actingAs($user)->get('/password/confirm')->assertStatus(200);
    }
}

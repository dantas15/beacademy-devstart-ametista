<?php

namespace Http\Middleware;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IsAdminTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Regular user should be redirected to index.
     *
     * @return void
     */
    public function test_normal_user_accessing_admin_route_should_be_redirected_to_index()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/admin');

        $response->assertRedirect('/');
    }

    /**
     * Admin should be able to pass the middleware
     *
     * @return void
     */
    public function test_admin_should_be_able_to_enter_admin_page()
    {
        $user = User::factory()->create(['is_admin' => 1]);

        $response = $this->actingAs($user)->get('/admin');

        $response->assertViewIs('admin.index');
    }
}

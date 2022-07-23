<?php

namespace Http\Controllers;

use App\Http\Controllers\AdminController;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Admin default route should return admin.index view
     *
     * @return void
     */
    public function test_admin_should_enter_admin_page()
    {
        $user = User::factory()->create(['is_admin' => 1]);

        $response = $this->actingAs($user)->get('/admin');

        $response->assertViewIs('admin.index');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test Admin default route should return admin.index view
     */
    public function test_admin_should_enter_admin_page()
    {
        $user = User::factory()->create(['is_admin' => 1]);

        $response = $this->actingAs($user)->get('/admin');

        $response->assertViewIs('admin.index');
    }

    /**
     * @test Admin should be able to see all orders
     */
    public function test_admin_should_see_all_orders()
    {
        $user = User::factory()->create(['is_admin' => 1]);

        $response = $this->actingAs($user)->get('/admin/orders');

        $response->assertViewIs('admin.orders.index');
    }

}

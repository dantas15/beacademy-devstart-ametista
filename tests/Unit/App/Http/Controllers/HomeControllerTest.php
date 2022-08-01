<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomeControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test Index should show welcome page
     */
    public function index()
    {
        $this->get(route(('index')))->assertStatus(200)->assertViewIs('welcome');
    }
}

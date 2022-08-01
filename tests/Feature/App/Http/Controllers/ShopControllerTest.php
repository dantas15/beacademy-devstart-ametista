<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShopControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test Index should show all products with amount > 0 and with paginate links
     */
    public function test_index_should_show_all_products_with_amount_greater_than_zero()
    {
        $products1 = Product::factory()->create(['amount' => 0]);
        $products2 = Product::factory()->create(['amount' => 0]);
        $products3 = Product::factory()->create(['amount' => 1]);

        $this->get(route('shop.index'))
            ->assertStatus(200)
            ->assertSee($products3->name)
            ->assertDontSee($products1->name)
            ->assertDontSee($products2->name);
    }

    /**
     * @test If request has search, index should show products matching search query on name or description
     */
    public function test_if_request_has_search_index_should_show_products_matching_search_query_on_name_or_description()
    {
        Product::factory(5)->create();
        $product = Product::factory()->create(['name' => 'Product 1', 'description' => 'Product 1 description']);

        $this->get(route('shop.index', ['search' => 'Product 1']))
            ->assertStatus(200)
            ->assertSee($product->name)
            ->assertSee($product->description);
    }
}

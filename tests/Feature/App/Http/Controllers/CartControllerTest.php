<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test Guest can store new product in cart
     */
    public function test_guest_can_store_new_product_in_cart()
    {
        $product = Product::factory()->create();

        $response = $this->post(route('shop.cart.store'), [
            'productId' => $product->id,
            'amount' => 1,
        ]);

        $response->assertSessionHas('cart', [
            $product->id => [
                'name' => $product->name,
                'amount' => 1,
                'description' => $product->description,
                'price' => $product->sale_price,
            ],
        ]);
    }

    /**
     * @test Product amount can be increased
     */
    public function test_product_amount_can_be_increased()
    {
        $product = Product::factory()->create();

        $this->post(route('shop.cart.store'), [
            'productId' => $product->id,
            'amount' => 1,
        ]);

        $this->post(route('shop.cart.store'), [
            'productId' => $product->id,
            'amount' => 1,
        ]);

        $this->assertEquals(2, session()->get('cart')[$product->id]['amount']);
    }
}

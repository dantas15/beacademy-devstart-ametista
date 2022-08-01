<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class CartControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test Any User should be able to see its cart.
     */
    public function test_any_user_should_be_able_to_see_its_cart_if_cart_is_not_null()
    {
        $this->get(route('shop.cart.index'))->assertRedirect();


        $product = Product::factory()->create();
        $this->post(route('shop.cart.store'), [
            'productId' => $product->id,
            'amount' => 1,
        ]);

        $this->get(route('shop.cart.index'))->assertViewIs('shop.cart.index');
    }

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
                'id' => $product->id,
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

        $expectedTotalPrice = $product->sale_price * 2;

        $this->assertEquals(2, session()->get('cart')[$product->id]['amount']);
        $this->assertEquals($expectedTotalPrice, session()->get('totalCartPrice'));
    }

    /**
     * @test Product amount can be decreased
     */
    public function test_product_amount_can_be_decreased()
    {
        $product = Product::factory()->create(['amount' => 5]);

        $this->post(route('shop.cart.store'), [
            'productId' => $product->id,
            'amount' => 2,
        ]);

        $this->delete(route('shop.cart.destroy', [
            'productId' => $product->id,
            'amount' => 1,
        ]));

        $expectedTotalPrice = $product->sale_price;

        $this->assertEquals(1, session()->get('cart')[$product->id]['amount']);
        $this->assertEquals($expectedTotalPrice, session()->get('totalCartPrice'));
    }

    /**
     * @test If product amount is decresed to zero or less than zero, product is removed from cart
     */
    public function test_if_product_amount_is_decresed_to_zero_or_less_than_zero_product_is_removed_from_cart()
    {
        $product = Product::factory()->create(['amount' => 5]);

        $this->post(route('shop.cart.store'), [
            'productId' => $product->id,
            'amount' => 4,
        ]);

        $this->delete(route('shop.cart.destroy', [
            'productId' => $product->id,
            'amount' => 4,
        ]));

        $this->assertEmpty(session()->get('cart'));
    }

    /**
     * @test Cart can be cleared
     */
    public function test_cart_can_be_cleared()
    {
        $product = Product::factory()->create(['amount' => 5]);

        $this->post(route('shop.cart.store'), [
            'productId' => $product->id,
            'amount' => 2,
        ]);

        $this->delete(route('shop.cart.clear'));

        $this->assertEmpty(session()->get('cart'));
    }

    /**
     * @test Should be redirected back if product is not found
     */
    public function test_should_be_redirected_back_if_product_is_not_found()
    {
        $response = $this->post(route('shop.cart.store'), [
            'productId' => Str::uuid(),
            'amount' => 1,
        ]);

        $response->assertRedirect();
    }

    /**
     * @test Should be redirected back if product amount is not valid
     */
    public function test_should_be_redirected_back_if_product_amount_is_not_valid()
    {
        $product = Product::factory()->create(['amount' => 1]);

        $response = $this->post(route('shop.cart.store'), [
            'productId' => $product->id,
            'amount' => 2,
        ]);

        $response->assertRedirect();
    }
}

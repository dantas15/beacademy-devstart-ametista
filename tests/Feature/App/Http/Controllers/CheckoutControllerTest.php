<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Order;
use App\Models\PaymentMethod;
use App\Models\Product;
use App\Models\User;
use Database\Seeders\OrderStatusSeeder;
use Database\Seeders\PaymentMethodsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class CheckoutControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test User should be see selectAddress page if authenticated
     */
    public function user_should_be_see_selectAddress_page_if_authenticated()
    {
        $this->get(route('shop.checkout.selectAddress'))->assertRedirect(route('login'));

        $user = User::factory()->create();

        $this->actingAs($user)->get(route('shop.checkout.selectAddress'))->assertViewIs('shop.checkout.select-address');
    }

    /**
     * @test User can see paymentForm if all datas are correct
     */
    public function test_user_can_see_payment_form_if_all_datas_are_correct()
    {
        $this->seed(PaymentMethodsSeeder::class);

        $address = Address::factory()->create();
        $user = $address->user;

        $this
            ->actingAs($user)
            ->get(route('shop.checkout.paymentForm', ['addressId' => Str::uuid()]))
            ->assertRedirect(route('shop.checkout.selectAddress'));
        $this
            ->actingAs($user)
            ->get(route('shop.checkout.paymentForm', ['addressId' => $address->id]))
            ->assertViewIs('shop.checkout.payment');
    }

    /**
     * @test Payment should return errorrs if there is missing data for 'boleto' payment method
     */
    public function test_payment_should_return_errors_if_there_is_missing_data_for_boleto_payment_method()
    {
        $this->seed([
            OrderStatusSeeder::class,
            PaymentMethodsSeeder::class,
        ]);

        $boleto = PaymentMethod::where('name', 'boleto')->first();

        $address = Address::factory()->create();
        $user = $address->user;

        $payload = [
            'paymentMethodId' => $boleto->id,
            'document_id' => 'test',
            'name' => 'test',
        ];

        $response = $this->actingAs($user)->post(route('shop.checkout.payment', ['addressId' => $address->id]), $payload);

        $response->assertSessionHasErrors(['document_id', 'name']);
    }

    /**
     * @test Payment should return errors if there is missing data for 'credit_card' payment method
     */
    public function test_payment_should_return_errors_if_there_is_missing_data_for_credit_card_payment_method()
    {
        $this->seed([
            OrderStatusSeeder::class,
            PaymentMethodsSeeder::class,
        ]);

        $card = PaymentMethod::where('name', 'credit_card')->first();

        $address = Address::factory()->create();
        $user = $address->user;

        $payload = [
            'paymentMethodId' => $card->id,
            'email' => '',
            'name' => '',
            'creditNumber' => '',
            'expDate' => '',
            'cvc' => '',
        ];

        $response = $this->actingAs($user)->post(route('shop.checkout.payment', ['addressId' => $address->id]), $payload);

        $response->assertSessionHasErrors([
            'email',
            'name',
            'creditNumber',
            'expDate',
            'cvc',
        ]);
    }

    /**
     * @test Payment should redirect to paymentForm if specified payment method is not found
     */
    public function test_payment_should_redirect_to_payment_form_if_specified_payment_method_is_not_found()
    {
        $this->seed([
            OrderStatusSeeder::class,
            PaymentMethodsSeeder::class,
        ]);

        $address = Address::factory()->create();
        $user = $address->user;

        $payload = [
            'paymentMethodId' => 999,
            'addressId' => $address->id,
        ];
        $response = $this->actingAs($user)->post(route('shop.checkout.payment', ['addressId' => $address->id]), $payload);

        $response->assertRedirect(route('shop.checkout.paymentForm', ['addressId' => $address->id]));
    }

    /**
     * @test Payment should create an Order and OrderProducts to every product if all datas are correct
     */
    public function test_payment_should_create_an_order_and_order_products_to_every_product_if_all_datas_are_correct()
    {
        $this->seed([
            OrderStatusSeeder::class,
            PaymentMethodsSeeder::class,
        ]);

        $boleto = PaymentMethod::where('name', 'boleto')->first();
        $address = Address::factory()->create();
        $user = $address->user;

        $products = Product::factory(2)->create(['amount' => 5]);

        // Adding products to cart session to be able to checkout
        $this->actingAs($user)->post(route('shop.cart.store'), [
            'productId' => $products[0]->id,
            'amount' => $products[0]->amount,
        ]);
        $this->actingAs($user)->post(route('shop.cart.store'), [
            'productId' => $products[1]->id,
            'amount' => $products[1]->amount,
        ]);

        $expectedTotalPrice = (float)session()->get('totalCartPrice');
        $expectedCompleteAddress = $address->street . ', ' . $address->number . ', ' . $address->complement . ', ' . $address->neighborhood . ', ' . $address->city . ', ' . $address->state . ', ' . $address->country . ', ' . $address->zipCode;

        $orderPayload = [
            'addressId' => $address->id,
            'paymentMethodId' => $boleto->id,
            'document_id' => $user->document_id,
            'name' => $user->name,
        ];

        // Payment request
        $response = $this->actingAs($user)->post(route('shop.checkout.payment', ['addressId' => $address->id]), $orderPayload)->assertOk();

        $expectedOrder = [
            'user_id' => $user->id,
            'payment_method_id' => $boleto->id,
            'address_id' => $address->id,
            'complete_address' => $expectedCompleteAddress,
            'total_price' => $expectedTotalPrice,
        ];
        $expectedProductOrder1 = [
            'product_id' => $products[0]->id,
            'amount' => $products[0]->amount,
        ];
        $expectedProductOrder2 = [
            'product_id' => $products[1]->id,
            'amount' => $products[1]->amount,
        ];

        $this->assertDatabaseHas('orders', $expectedOrder);
        $this->assertDatabaseHas('order_products', $expectedProductOrder1);
        $this->assertDatabaseHas('order_products', $expectedProductOrder2);

        // If all went ok, both product amount shuould be zero
        $this->assertDatabaseHas('products', [
            'id' => $products[0]->id,
            'amount' => 0
        ]);
        $this->assertDatabaseHas('products', [
            'id' => $products[0]->id,
            'amount' => 0
        ]);
        $response->assertViewIs('shop.checkout.success');
    }
}

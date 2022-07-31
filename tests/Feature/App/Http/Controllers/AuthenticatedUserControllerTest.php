<?php

namespace App\Http\Controllers;

use App\Http\Controllers\AuthenticatedUserController;
use App\Models\{
    User,
    Address,
};
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticatedUserControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     *  Test if user is authenticated and redirect to login page if not.
     *
     * @return void
     */
    public function test_user_should_be_authenticated()
    {
        $this->get('/me')->assertRedirect('login');
    }

    /**
     * Test if user is authenticated and redirect to "Me".
     *
     * @return void
     */
    public function test_user_should_be_authenticated_and_redirect_to_me()
    {
        $user = User::factory()->create();

        $this->actingAs($user)->get(route('me.index'))->assertViewIs('me.index');
    }

    /**
     * Test update user info.
     *
     * @return void
     */
    public function test_user_should_be_authenticated_and_update_info()
    {
        $toBeUpdatedData = [
            'name' => 'Cleber',
            'email' => 'cleber@test.com',
            'phone_number' => '+5511999999999',
            'birth_date' => '2020-01-01',
        ];

        $user = User::factory()->create($toBeUpdatedData);

        $toBeUpdatedData['name'] = 'Cleber Updated';

        $request = $this->actingAs($user)->put(route('me.update'), $toBeUpdatedData);

        $request->assertSessionHasNoErrors();
        $request->assertRedirect(route('me.index'));
        $this->assertDatabaseHas('users', $toBeUpdatedData);
    }

    /**
     * Test user can see its addresses.
     *
     * @return void
     */
    public function test_user_should_be_see_its_addresses()
    {
        $address = Address::factory()->create();
        $user = $address->user;

        $this->actingAs($user)->get(route('me.addresses.index'))->assertViewIs('me.addresses.index');
    }

    /**
     * Test user should access create new address form.
     *
     * @return void
     */
    public function test_user_should_access_create_new_address_form()
    {
        $user = User::factory()->create();

        $this->actingAs($user)->get(route('me.addresses.create'))->assertViewIs('me.addresses.create');
    }

    /**
     * Test user can create new address.
     *
     * @return void
     */
    public function test_user_can_create_new_address()
    {
        $user = User::factory()->create();

        $payload = [
            'zip' => '22222222',
            'uf' => 'MG',
            'city' => 'Created city',
            'street' => 'Created street',
            'number' => '321',
            'neighborhood' => 'Created neighborhood',
            'complement' => 'Created complement',
        ];

        $request = $this->actingAs($user)->post(route('me.addresses.store'), $payload);

        $request->assertSessionHasNoErrors();
        $request->assertRedirect(route('me.addresses.index'));
        $this->assertDatabaseHas('addresses', $payload);
    }

    /**
     * Test user can not access edit other user's addres form.
     *
     * @return void
     */
    public function test_user_can_not_see_other_user_addresses_form()
    {
        $user = User::factory()->create();
        $otherUser = Address::factory()->create();

        $this->actingAs($user)->get(route('me.addresses.edit', $otherUser->id))->assertForbidden();
    }

    /**
     * Test user can see edit address form.
     *
     * @return void
     */
    public function test_user_can_see_edit_address_form()
    {
        $address = Address::factory()->create();
        $user = $address->user;

        $this->actingAs($user)->get(route('me.addresses.edit', [
            'userId' => $address->user_id,
            'id' => $address->id,
        ]))->assertViewIs('me.addresses.edit');
    }

    /**
     * Test user can update address.
     *
     * @return void
     */
    public function test_user_can_update_address()
    {
        $payload = [
            'zip' => '11111111',
            'uf' => 'SP',
            'city' => 'Created city',
            'street' => 'Created street',
            'number' => '123',
            'neighborhood' => 'Created neighborhood',
            'complement' => 'Created complement',
        ];

        $address = Address::factory()->create($payload);

        $this->assertDatabaseHas('addresses', $payload);

        $user = $address->user;

        $payload = [
            'zip' => '22222222',
            'uf' => 'MG',
            'city' => 'Updated city',
            'street' => 'Updated street',
            'number' => '321',
            'neighborhood' => 'Updated neighborhood',
            'complement' => 'Updated complement',
        ];

        $request = $this->actingAs($user)->put(route('me.addresses.update', [
            'id' => $address->id,
        ]), $payload);

        $request->assertSessionHasNoErrors();
        $request->assertRedirect(route('me.addresses.edit', [
            'id' => $address->id,
        ]));
        $this->assertDatabaseHas('addresses', $payload);
    }

    /**
     * Test user can not update other user's address.
     *
     * @return void
     */
    public function test_user_can_not_update_other_user_address()
    {
        $createdAddressData = [
            'zip' => '22222222',
            'uf' => 'MG',
            'city' => 'Created city',
            'street' => 'Created street',
            'number' => '123',
            'neighborhood' => 'Created neighborhood',
            'complement' => 'Created complement',
        ];

        $updatedAddressData = [
            'zip' => '33333333',
            'uf' => 'SP',
            'city' => 'Updated city',
            'street' => 'Updated street',
            'number' => '321',
            'neighborhood' => 'Updated neighborhood',
            'complement' => 'Updated complement',
        ];

        $user = User::factory()->create();

        $otherAddress = Address::factory()->create($createdAddressData);

        $request = $this->actingAs($user)->put(route('me.addresses.update', [
            'id' => $otherAddress->id,
        ]), $updatedAddressData);

        $request->assertForbidden();
        $this->assertDatabaseHas('addresses', $createdAddressData);
        $this->assertDatabaseMissing('addresses', $updatedAddressData);
    }

    /**
     * Test user can delete its address.
     *
     * @return void
     */
    public function test_user_can_delete_its_address()
    {
        $address = Address::factory()->create();
        $user = $address->user;

        $this->actingAs($user)->delete(route('me.addresses.destroy', [
            'id' => $address->id,
        ]))->assertRedirect(route('me.addresses.index'));
        $this->assertSoftDeleted($address);
    }

    /**
     * Test user can not delete other user's address.
     *
     * @return void
     */
    public function test_user_can_not_delete_other_user_address()
    {
        $address = Address::factory()->create();

        $otherUser = User::factory()->create();

        $this->actingAs($otherUser)->delete(route('me.addresses.destroy', [
            'id' => $address->id,
        ]))->assertForbidden();
        $this->assertDatabaseHas('addresses', ['id' => $address->id]);
    }
}

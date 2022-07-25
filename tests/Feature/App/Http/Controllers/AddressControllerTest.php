<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use App\Models\{
    User,
    Address,
};
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AddressControllerTest extends TestCase
{
    use RefreshDatabase;

    public array $validatedDataWithoutUserId = [
        'zip' => '11111111',
        'uf' => 'SP',
        'city' => 'Test',
        'street' => 'Test',
        'number' => '123',
        'neighborhood' => 'Test',
        'complement' => null,
    ];

    /**
     * Display all addresses from given user id
     *
     * @return void
     */
    public function test_display_all_addresses_from_given_user_id()
    {
        $userAdmin = User::factory()->create(['is_admin' => 1]);
        $address = Address::factory()->create();

        $this
            ->actingAs($userAdmin)
            ->get(route('admin.users.addresses.index', [
                'userId' => Str::uuid(),
            ]))
            ->assertStatus(404);

        $this
            ->actingAs($userAdmin)
            ->get(route('admin.users.addresses.index', [
                'userId' => $address->user_id,
            ]))
            ->assertViewIs('users.addresses.index');
    }

    /**
     * Show create address form based on user id
     *
     * @return void
     */
    public function test_show_create_address_form()
    {
        $userAdmin = User::factory()->create(['is_admin' => 1]);
        $address = Address::factory()->create();

        // Incorrect user id
        $this
            ->actingAs($userAdmin)
            ->get(route('admin.users.addresses.create', [
                'userId' => Str::uuid(),
            ]))
            ->assertStatus(404);

        // Correct Id's
        $this
            ->actingAs($userAdmin)
            ->get(route('admin.users.addresses.create', [
                'userId' => $address->user_id,
            ]))->assertViewIs('users.addresses.create');
    }

    /**
     * Store new address
     *
     * @return void
     */
    public function test_store_new_address()
    {
        $userAdmin = User::factory()->create(['is_admin' => 1]);
        $user = User::factory()->create();

        $payload = $this->validatedDataWithoutUserId;
        $payload['user_id'] = $user->id;

        $this
            ->actingAs($userAdmin)
            ->post(route('admin.users.addresses.store', [
                'userId' => $user->id,
            ]), $payload)
            ->assertRedirect(route('admin.users.addresses.index', [
                'userId' => $user->id,
            ]));

        $this->assertDatabaseHas('addresses', $payload);
    }

    /**
     * Show edit address form based on user id
     *
     * @return void
     */
    public function test_show_edit_address_form()
    {
        $userAdmin = User::factory()->create(['is_admin' => 1]);
        $address = Address::factory()->create();

        // Incorrect user id
        $this
            ->actingAs($userAdmin)
            ->get(route('admin.users.addresses.edit', [
                'userId' => Str::uuid(),
                'id' => Str::uuid(),
            ]))
            ->assertStatus(404);

        // Incorrect address id
        $this
            ->actingAs($userAdmin)
            ->get(route('admin.users.addresses.edit', [
                'userId' => $address->user_id,
                'id' => Str::uuid(),
            ]))
            ->assertStatus(404);

        // Correct Id's
        $this
            ->actingAs($userAdmin)
            ->get(route('admin.users.addresses.edit', [
                'userId' => $address->user_id,
                'id' => $address->id,
            ]))
            ->assertViewIs('users.addresses.edit');
    }

    /**
     * Update address data
     *
     * @return void
     */
    public function test_update_address_data()
    {
        $userAdmin = User::factory()->create(['is_admin' => 1]);
        $address = Address::factory()->create();

        $payload = [
            'zip' => '22222222',
            'uf' => 'MG',
            'city' => 'Updated city',
            'street' => 'Updated street',
            'number' => '321',
            'neighborhood' => 'Updated neighborhood',
            'complement' => 'Updated complement',
        ];

        $this
            ->actingAs($userAdmin)
            ->put(route('admin.users.addresses.update', [
                'id' => $address->id,
                'userId' => $address->user_id,
            ]), $payload)
            ->assertRedirect(route('admin.users.addresses.index', [
                'userId' => $address->user_id,
            ]));

        $this->assertDatabaseHas('addresses', $payload);
    }

    /**
     * Soft delete address
     *
     * @return void
     */
    public function test_delete_address()
    {
        $userAdmin = User::factory()->create(['is_admin' => 1]);
        $address = Address::factory()->create();

        // Incorrect address id
        $this
            ->actingAs($userAdmin)
            ->delete(route('admin.users.addresses.destroy', [
                'userId' => $address->user_id,
                'id' => Str::uuid(),
            ]))
            ->assertStatus(404);

        // Correct Id's
        $this
            ->actingAs($userAdmin)
            ->delete(route('admin.users.addresses.destroy', [
                'userId' => $address->user_id,
                'id' => $address->id,
            ]))
            ->assertRedirect(route('admin.users.addresses.index', [
                'userId' => $address->user_id,
            ]));

        $this->assertSoftDeleted($address);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Ramsey\Uuid\Uuid;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test admin can see all users.
     *
     * @return void
     */
    public function test_admin_can_see_all_users()
    {
        $user = User::factory()->create(['is_admin' => 1]);

        $response = $this->actingAs($user)->get('/admin/users');

        $response->assertViewIs('users.index');
    }

    /**
     * Test admin can see new user form
     *
     * @return void
     */
    public function test_admin_can_see_new_user_form()
    {
        $user = User::factory()->create(['is_admin' => 1]);

        $response = $this->actingAs($user)->get(route('admin.users.create'));

        $response->assertViewIs('users.create');
    }

    /**
     * Test it should return status code 404 if user not found.
     *
     * @return void
     */
    public function test_it_should_return_status_code_404_if_user_not_found()
    {
        $user = User::factory()->create(['is_admin' => 1]);

        $response = $this->actingAs($user)->get('/admin/users/' . Uuid::uuid4());

        $response->assertStatus(404);
    }

    /**
     * Test admin can see user details.
     *
     * @return void
     */
    public function test_admin_can_see_user_details()
    {
        $admin = User::factory()->create(['is_admin' => 1]);
        $user = User::factory()->create();

        $response = $this->actingAs($admin)->get('/admin/users/' . $user->id);

        $response->assertViewIs('users.show');
    }

    /**
     * Test admin can see edit user form.
     *
     * @return void
     */
    public function test_admin_can_see_edit_user_form()
    {
        $admin = User::factory()->create(['is_admin' => 1]);
        $user = User::factory()->create();

        $response = $this->actingAs($admin)->get(route('admin.users.edit', $user->id));

        $response->assertViewIs('users.edit');
    }

    /**
     * Test admin can not create user if payload is not valid
     *
     * @return void
     */
    public function test_admin_can_not_create_user_if_payload_is_not_valid()
    {
        $admin = User::factory()->create(['is_admin' => 1]);

        $userData = [
            'name' => 'John Doe',
//            'email' => 'john@test.com',
//            'birth_date' => '2000-01-01',
//            'password' => 'password',
//            'password_confirmation' => 'password',
//            'phone_number' => '+5511999999999',
//            'document_id' => '99999999999',
        ];

        $this->actingAs($admin)->post(route('admin.users.store'), $userData)->assertSessionHasErrors(['email', 'birth_date', 'password', 'phone_number', 'document_id']);
    }

    /**
     * Test admin can create user if payload is valid.
     *
     * @return void
     */
    public function test_admin_can_create_user_if_payload_is_valid()
    {
        $admin = User::factory()->create(['is_admin' => 1]);

        $userData = [
            'name' => 'John Doe',
            'email' => 'john@test.com',
            'birth_date' => '2000-01-01',
            'password' => 'password',
            'phone_number' => '+5511999999999',
            'document_id' => '99999999999',
        ];

        $userDataWithPasswordConfirmation = $userData;
        $userDataWithPasswordConfirmation['password_confirmation'] = 'password';
        $request = $this->actingAs($admin)->post(route('admin.users.store'), $userDataWithPasswordConfirmation);

        $request->assertSessionHasNoErrors();
        $request->assertRedirect(route('admin.users.index'));
        $this->assertDatabaseHas('users', $userData);
    }

    /**
     * Test edit unknown user id should return 404.
     *
     * @return void
     */
    public function test_edit_unknown_user_id_should_return_404()
    {
        $admin = User::factory()->create(['is_admin' => 1]);

        $response = $this->actingAs($admin)->get(route('admin.users.edit', ['id' => Uuid::uuid4()]));

        $response->assertStatus(404);
    }

    /**
     * Test admin can not update user info if payload is not valid.
     *
     * @return void
     */
    public function test_admin_can_not_update_user_info_if_payload_is_not_valid()
    {
        $admin = User::factory()->create(['is_admin' => 1]);
        $user = User::factory()->create();

        $response = $this->actingAs($admin)->put(route('admin.users.update', ['id' => $user->id]), []);

        $response->assertSessionHasErrors(['email', 'phone_number', 'birth_date']);
    }

    /**
     * Test admin can update user info.
     *
     * @return void
     */
    public function test_admin_can_update_user_info()
    {
        $userData = [
            'name' => 'Cleber',
            'email' => 'cleber@test.com',
            'phone_number' => '5511999999999',
            'birth_date' => '2020-01-01',
        ];

        $admin = User::factory()->create(['is_admin' => 1]);
        $user = User::factory()->create($userData);

        $userData = [
            'name' => 'Cleber updated',
            'email' => 'cleber@test.com',
            'phone_number' => '5511999999999',
            'birth_date' => '2020-01-01',
        ];

        $this->actingAs($admin)->put(route('admin.users.update', ['id' => $user->id]), $userData)->assertSessionHasNoErrors();

        $this->assertDatabaseHas('users', $userData);
    }

    /**
     * Test delete unknown user id should return 404.
     *
     * @return void
     */
    public function test_delete_unknown_user_id_should_return_404()
    {
        $admin = User::factory()->create(['is_admin' => 1]);

        $response = $this->actingAs($admin)->delete(route('admin.users.destroy', ['id' => Uuid::uuid4()]), []);

        $response->assertStatus(404);
    }

    /**
     * Test admin can delete user.
     *
     * @return void
     */
    public function test_admin_can_delete_user()
    {
        $admin = User::factory()->create(['is_admin' => 1]);
        $user = User::factory()->create();

        $request = $this->actingAs($admin)->delete(route('admin.users.destroy', ['id' => $user->id]))->assertSessionHasNoErrors();

        $request->assertRedirect(route('admin.users.index'));

        $this->assertSoftDeleted('users', $user->toArray());
    }
}

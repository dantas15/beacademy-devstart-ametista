<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddressRequest;
use App\Models\Address;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\View;
use Illuminate\Http\{
    RedirectResponse,
    Request
};
use Ramsey\Uuid\Uuid;

class AddressController extends Controller
{
    /**
     * Show all addresses from user
     *
     * @param string $userId
     * @return Application|View
     */
    public function index(string $userId)
    {
        $user = User::find($userId);

        if (is_null($user)) {
            return abort(404);
        }

        return view('users.addresses.index', [
            'userId' => $userId,
            'addresses' => $user->addresses,
        ]);
    }

    /**
     * Show new address form.
     *
     * @param string $userId
     * @return Application|View
     */
    public function create($userId)
    {
        $user = User::find($userId);

        if (is_null($user)) {
            abort(404);
        }

        return view('users.addresses.create', ['user' => $user]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param AddressRequest $request
     * @param $userId
     * @return RedirectResponse
     */
    public function store(AddressRequest $request, $userId)
    {
        $validated = $request->validationData();

        $validated['id'] = Uuid::uuid4();

        $address = new Address($validated);

        $user = User::find($userId);

        $user->addresses()->save($address);

        return redirect()->route('admin.users.addresses.index', ['userId' => $userId]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param string $userId User id
     * @param string $id Address id
     * @return Application|View
     */
    public function edit(string $userId, string $id)
    {
        $user = User::find($userId);

        if (is_null($user)) {
            return abort(404);
        }

        $address = Address::find($id);

        if (is_null($address)) {
            abort(404);
        }

        return view('users.addresses.edit', [
            'user' => $user,
            'address' => $address,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param AddressRequest $request
     * @return Application|View|RedirectResponse
     */
    public function update(AddressRequest $request)
    {
        $validated = $request->validated();

        $address = Address::find($request->id);

        $address->update($validated);

        return redirect()->route('admin.users.addresses.index', ['userId' => $address->user_id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function destroy(Request $request)
    {
        $address = Address::find($request->id);

        if (is_null($address)) {
            return abort(404);
        }

        $address->delete();

        return redirect()->route('admin.users.addresses.index', [
            'userId' => $address->user_id,
        ]);
    }
}

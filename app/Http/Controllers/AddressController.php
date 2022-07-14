<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\View;
use Illuminate\Http\{
    RedirectResponse,
    Request
};
use Illuminate\Support\Facades\Validator;
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
     * @param Request $request
     * @param $userId
     * @return RedirectResponse
     */
    public function store(Request $request, $userId)
    {

        $validator = Validator::make($request->all(), Address::$createRules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }

        $validated = $validator->safe()->only([
            'zip',
            'uf',
            'city',
            'street',
            'number',
            'neighborhood',
            'complement',
        ]);

        $address = new Address();
        $address->id = Uuid::uuid4();
        $this->extracted($validated, $address);

        $user = User::find($userId);

        $user->addresses()->save($address);

        return redirect()->route('users.addresses.index', ['userId' => $userId]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param string $userId User id
     * @param string $id Address id
     * @return Application|View
     */
    public function edit($userId, $id)
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
     * @param Request $request
     * @return Application|View|RedirectResponse
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), Address::$updateRules);

        $address = Address::find($request->id);

        if (is_null($address)) {
            return redirect()->back()->withErrors(['addressNotFound' => 'Endereço não cadastrado no sistema']);
        }

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }

        $validated = $validator->safe()->only([
            'zip',
            'uf',
            'city',
            'street',
            'number',
            'neighborhood',
            'complement',
        ]);

        $this->extracted($validated, $address);

        $address->save();

        return redirect()->route('users.addresses.index', ['userId' => $address->user->id]);
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

        return redirect()->route('users.addresses.index', ['userId' => $address->user_id]);
    }

    /**
     * @param array $validated
     * @param $address
     * @return void
     */
    public function extracted(array $validated, $address): void
    {
        $address->zip = $validated['zip'];
        $address->uf = $validated['uf'];
        $address->city = $validated['city'];
        $address->street = $validated['street'];
        $address->number = $validated['number'];
        $address->neighborhood = $validated['neighborhood'];
        $address->complement = $validated['complement'];
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddressRequest;
use App\Http\Requests\UserRequest;
use App\Models\Address;
use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Ramsey\Uuid\Uuid;

class AuthenticatedUserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the user's info.
     *
     * @return Renderable
     */
    public function index()
    {
        return view('me.index', ['user' => User::find(Auth::user()->id)]);
    }

    /**
     * Updates current user info
     *
     * @param UserRequest $request
     * @return RedirectResponse
     */
    public function update(UserRequest $request)
    {
        $validated = $request->validationData();

        $user = User::find(Auth::user()->id);

        $user->update($validated);

        $request->session()->regenerate();

        return redirect()->route('me.index');
    }

    /**
     * Displays authenticated user's addresses
     *
     * @return View
     */
    public function addresses()
    {
        $user = User::find(Auth::user()->id);

        return view('me.addresses.index', [
            'addresses' => $user->addresses,
        ]);
    }

    /**
     * Show new address form.
     *
     * @param string $userId
     * @return View
     */
    public function createAddress()
    {
        return view('me.addresses.create');
    }

    /**
     * Store a newly created address in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function storeAddress(AddressRequest $request)
    {
        $validated = $request->validationData();

        $validated['id'] = Uuid::uuid4();

        $address = new Address($validated);

        $user = Auth::user();

        $user->addresses()->save($address);

        return redirect()->route('me.addresses.index');
    }

    /**
     * Show the form for editing the specified address.
     *
     * @return View
     */
    public function editAddress($id)
    {
        $address = Address::find($id);

        if (is_null($address) || $address->user_id != Auth::user()->id) {
            return abort(404);
        }

        return view('me.addresses.edit', [
            'user' => Auth::user(),
            'address' => $address,
        ]);
    }

    /**
     * Update the specified address in storage.
     *
     * @param AddressRequest $request
     * @return RedirectResponse
     */
    public function updateAddress(AddressRequest $request)
    {
        $validated = $request->validated();

        $address = Address::find($request->id);

        $address->update($validated);

        return redirect()
            ->route('me.addresses.edit', [
                'id' => $address->id
            ])
            ->with('success', 'Dados alterados com sucesso');
    }

    /**
     * Remove the specified address from storage.
     *
     * @param string $id
     * @return RedirectResponse
     */
    public function destroyAddress(string $id)
    {
        $address = Address::find($id);

        if (is_null($address) || $address->user_id != Auth::user()->id) {
            return abort(404);
        }

        $address->delete();

        return redirect()->route('me.addresses.index', ['userId' => $address->user_id]);
    }
}

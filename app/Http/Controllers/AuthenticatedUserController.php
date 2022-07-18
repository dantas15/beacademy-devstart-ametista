<?php

namespace App\Http\Controllers;

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
     * @param Request $request
     * @return RedirectResponse
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), User::$updateRules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }

        $validated = $validator->safe()->only([
            'name',
            'email',
            'phone_number',
            'birth_date',
        ]);

        $user = User::find(Auth::user()->id);

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->phone_number = $validated['phone_number'];
        $user->birth_date = $validated['birth_date'];

        $user->save();
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
    public function storeAddress(Request $request)
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
        $this->extractedAddress($validated, $address);

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
     * @param Request $request
     * @return RedirectResponse
     */
    public function updateAddress(Request $request)
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

        $this->extractedAddress($validated, $address);

        $address->save();

        return redirect()->route('me.addresses.edit', [
            'id' => $address->id
        ])->with('success', 'Dados alterados com sucesso');
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

    /**
     * @param array $validated
     * @param $address
     * @return void
     */
    public function extractedAddress(array $validated, $address): void
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

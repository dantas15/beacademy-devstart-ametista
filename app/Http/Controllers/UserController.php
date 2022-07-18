<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;
use Illuminate\Http\{
    RedirectResponse,
    Request
};
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function __construct(User $user)
    {
        $this->model = $user;
    }

    public function index()
    {
        $users = User::all();

        return view('users.index', [
            'users' => $users,
        ]);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|never
     */
    public function show($id)
    {
        $user = User::find($id);

        if (is_null($user)) {
            return abort(404);
        }

        return view('users.show', [
            'user' => $user,
            'addresses' => $user->addresses,
        ]);
    }

    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a new user in the database.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), User::$createRules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }

        $validated = $validator->safe()->only([
            'name',
            'email',
            'password',
            'phone_number',
            'birth_date',
            'document_id',
        ]);

        // Replace the validated document_id to numbers only
        $documentNumbers = preg_replace('/[^0-9]/', '', $validated['document_id']);

        if (DB::table('users')->where('document_id', $documentNumbers)->exists()) {
            return redirect()->back()->withErrors(['document_id' => 'CPF/CNPJ já cadastrado no sistema!']);
        }

        $user = new User();
        $user->id = Uuid::uuid4();
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->password = bcrypt($validated['password']);
        $user->phone_number = $validated['phone_number'];
        $user->birth_date = $validated['birth_date'];
        $user->document_id = $documentNumbers;

        $user->save();

        return redirect()->route('admin.users.index');
    }

    public function edit($id)
    {
        $user = User::find($id);

        if (is_null($user)) {
            return abort(404);
        }

        return view('users.edit', [
            'user' => $user,
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|RedirectResponse
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), User::$updateRules);

        $user = User::find($request->id);

        if (is_null($user)) {
            return redirect()->back()->withErrors(['userNotFound' => 'Usuário não cadastrado no sistema']);
        }

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }

        $validated = $validator->safe()->only([
            'name',
            'email',
            'phone_number',
            'birth_date',
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->phone_number = $validated['phone_number'];
        $user->birth_date = $validated['birth_date'];

        $user->save();

        return view('users.show', [
            'user' => $user,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param string $id
     * @return RedirectResponse
     */
    public function destroy(string $id)
    {
        // TODO Make validations when using admin

        $user = User::find($id);

        if (is_null($user)) {
            return abort(404);
        }

        Address::where('user_id', $id)->delete();

        $user->delete();

        return redirect()->route('admin.users.index');
    }
}

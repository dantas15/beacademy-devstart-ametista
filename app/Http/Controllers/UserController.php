<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\Address;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;
use Illuminate\Http\RedirectResponse;
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
     * @return Application|\Illuminate\Contracts\View\Factory|View|never
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
     * @param UserRequest $request
     * @return RedirectResponse
     */
    public function store(UserRequest $request)
    {
        $validated = $request->validationData();

        $validated['id'] = Uuid::uuid4();

        $user = new User($validated);

        $user->save();

        return redirect()->route('admin.users.index');
    }

    /**
     * Show edit user form.
     *
     * @param string $id User id
     * @return View
     */
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
     * @param UserRequest $request
     * @return RedirectResponse
     */
    public function update(UserRequest $request)
    {
        $validated = $request->validationData();

        $user = User::find($request->id);

        $user->update($validated);

        return redirect()->route('admin.users.show', [
            'id' => $user->id
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
        $user = User::find($id);

        if (is_null($user)) {
            return abort(404);
        }

        Address::where('user_id', $id)->delete();

        $user->delete();

        return redirect()->route('admin.users.index');
    }
}

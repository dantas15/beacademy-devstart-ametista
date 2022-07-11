<?php

namespace App\Http\Controllers;

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

        // dd($users);
        return view('users.index', compact('users'));

    }

    /**
     * @param $id
     * @return
     */
    public function show($id)
    {
        $user = User::find($id);

        if (is_null($user)) {
            return abort(404);
        }

        return view('users.show', [
            'user' => $user,
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
    public function store(Request $request): RedirectResponse
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
        if (strlen($documentNumbers) != 11 && strlen($documentNumbers) != 14) {
            return redirect()->back()->withErrors(['document_id' => 'CPF/CNPJ inválido!']);
        }

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

        return redirect()->route('users.index');
    }

    public function edit(Request $request)
    {
        $validator = Validator::make($request->all(), User::$updateRules);

//        dd($request->id);

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
}

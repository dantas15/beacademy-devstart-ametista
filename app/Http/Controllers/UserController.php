<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

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

    public function show($id) 
    {
        // $user = User::find($id);

        // return $user;

        if(!$user = User::find($id))
            return redirect()->route('users.index');
        
        $title = $user->name;

        return view('users.show', compact('user', 'title'));
        
    }

    public function create() 
    {
        
        return view('users.create');

    }
    /**
     * Store a new flight in the database.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = $request->validate(User::$createRules);

        if ($validator->fails()) {
            return redirect('usuarios/criar')->withErrors($validator)->withInput();
        }

        $validated = $validator->safe()->only([
            'name',
            'email',
            'password',
            'phone_number',
            'birth_date',
            'document_id',
        ]);

        $documentNumbers = preg_replace('/[^0-9]/', '', $validated->document_id);
        if (strlen($documentNumbers) != 11 && strlen($documentNumbers) != 14) {
            throw ValidationException::withMessages(['document_id' => 'Invalid document_id length']);
        }

        // TODO Verificar endereço

        $user = new User();

        $data = $request->all();
        $data['password'] = bcrypt($request->password);

        $this->model->create($data);

            return redirect()->route('users.index');
    }
}

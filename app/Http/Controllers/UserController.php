<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    // public function index() 
    // {
    //     $users = [
    //         'nomes' => ['José Lira', 
    //                     'Marcelo Almeida'
    //         ]
    //     ];

    //     dd($users);
    // }

    public function show($id) 
    {
        // $user = User::find($id);

        // return $user;

        if(!$user = User::find($id))
            return \redirect()->route('users.index');

        return view('users.show', \compact('user'));
        
    }

    public function index() 
    {
        $users = User::all();

        // dd($users);
        return view('users.index', \compact('users'));

    }
}


// php artisan optimize (para limpar cache)

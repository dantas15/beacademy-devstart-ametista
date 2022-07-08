@extends('layouts.home')
@section('title', 'Listar usuários')
@section('content')
    <h1 class="container">{{ $user->name }}</h1>
    <table class="table container">
        <thead class="table-light">
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Nome</th>
                <th scope="col">e-mail</th>
                <th scope="col">Data Cadastro</th>
                <th scope="col">Ações</th>
            </tr>
        </thead>
        <tbody class="table-group-divider">
            <tr>
                <th scope="row">{{ $user->id }}</th>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ date('d/m/Y', strtotime($user->created_at)) }}</td>
                <td>
                    <a href="" class="btn btn-warning text-white">Editar</a>
                    <a href="" class="btn btn-danger text-white">Deletar</a>
                </td>
            </tr>
        </tbody>
    </table>
@endsection

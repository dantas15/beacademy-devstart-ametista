@extends('layouts.home')
@section('title', 'Visualizar usuário')
@section('content')
    <h2>Informações pessoas</h2>
    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-3">
                    <p class="mb-0">Nome</p>
                </div>
                <div class="col-sm-9">
                    <p class="text-muted mb-0">{{ $user->name }}</p>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-sm-3">
                    <p class="mb-0">Email</p>
                </div>
                <div class="col-sm-9">
                    <p class="text-muted mb-0">{{ $user->email }}</p>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-sm-3">
                    <p class="mb-0">Telefone</p>
                </div>
                <div class="col-sm-9">
                    <p class="text-muted mb-0">{{ $user->phone_number }}</p>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-sm-3">
                    <p class="mb-0">Data de nascimento</p>
                </div>
                <div class="col-sm-9">
                    <p class="text-muted mb-0">{{ $user->birth_date }}</p>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-sm-3">
                    <p class="mb-0">CPF / CNPJ</p>
                </div>
                <div class="col-sm-9">
                    <p class="text-muted mb-0">{{ $user->document_id }}</p>
                </div>
            </div>
        </div>
    </div>

    <h2>Endereços cadastrados</h2>
    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-3">
                    <p class="mb-0">Endereço 1</p>
                </div>
                <div class="col-sm-9">
                    <p class="text-muted mb-0">Bay Area, San Francisco, CA</p>
                </div>
            </div>
        </div>
    </div>

    <div class="w-100 gap-2 d-flex flex-row-reverse" role="group">
        <button type="button" class="btn btn-danger">Remover</button>
        <a href="{{ route('users.edit', ['id' => $user->id ]) }}" class="btn btn-warning">Editar</a>
    </div>
@endsection

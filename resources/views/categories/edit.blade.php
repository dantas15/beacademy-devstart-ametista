@extends('layouts.dashboard')
@section('title', 'Editar usuário')
@section('content')
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="{{ route('admin.users.edit', ['id' => $user->id])}}">
                Dados principais
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.users.addresses.index', ['userId' => $user->id]) }}">
                Endereços
            </a>
        </li>
    </ul>
    <hr class="mt-0 mb-4">
    <div class="card mb-4">
        <div class="card-header">Dados principais</div>
        <div class="card-body">
            <form action="{{ route('admin.users.update', ['id' => $user->id]) }}" method="post">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="name" class="form-label">Nome</label>
                    <input value="{{ $user->name }}" type="text" class="form-control" id="name" name="name"
                           placeholder="João da Silva" required>
                </div>
                @error('name')
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->get('name') as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @enderror

                <div class="mb-3">
                    <label for="document_id" class="form-label">Documento (CPF ou CNPJ)</label>
                    <input value="{{ $user->document_id }}" type="text" class="form-control" id="document_id"
                           name="document_id" disabled>
                </div>


                <div class="mb-3">
                    <label for="email" class="form-label">E-mail</label>
                    <input value="{{ $user->email }}" type="email" class="form-control" id="email" name="email"
                           placeholder="joao@dominio.com">
                </div>

                <div class="mb-3">
                    <label for="phone_number" class="form-label">Número de telefone</label>
                    <input value="{{ $user->phone_number }}" type="text" class="form-control" id="phone_number"
                           name="phone_number"
                           placeholder="99 999999999" required>
                </div>
                @error('phone_number')
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->get('phone_number') as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @enderror

                <div class="mb-3">
                    <label for="birth_date" class="form-label">Data de nascimento</label>
                    <input value="{{ $user->birth_date }}" type="date" class="form-control" id="birth_date"
                           name="birth_date" required>
                </div>
                @error('birth_date')
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->get('birth_date') as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @enderror

                <div class="d-flex flex-row-reverse w-100">
                    <button type="submit" class="btn btn-primary">Enviar</button>
                </div>
            </form>
        </div>
    </div>
@endsection

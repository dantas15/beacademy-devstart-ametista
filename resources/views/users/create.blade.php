@extends('layouts.home')
@section('title', 'Cadastrar')
@section('content')
    <h1>Novo Usuário</h1>
    <form action="{{ route('users.store') }}" method="post">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Nome</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="João da Silva" required>
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
            <input type="text" class="form-control" id="document_id" name="document_id" required>
        </div>
        @error('document_id')
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->get('document_id') as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @enderror

        <div class="mb-3">
            <label for="email" class="form-label">E-mail</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="joao@dominio.com" required>
        </div>
        @error('email')
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->get('email') as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @enderror

        <div class="mb-3">
            <label for="password" class="form-label">Senha</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        @error('password')
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->get('password') as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @enderror

        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Confirme sua senha</label>
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"
                   required>
        </div>
        @error('password_confirmation')
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->get('password_confirmation') as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @enderror

        <div class="mb-3">
            <label for="phone_number" class="form-label">Número de telefone</label>
            <input type="text" class="form-control" id="phone_number" name="phone_number"
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
            <input type="date" class="form-control" id="birth_date" name="birth_date" required>
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

        <button type="submit" class="btn btn-primary">Enviar</button>
    </form>

@endsection

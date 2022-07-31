@extends('layouts.dashboard')
@section('title', 'Cadastrar')
@section('content')
<h1>Nova categoria</h1>
<form action="{{ route('admin.categories.store') }}" method="post" enctype="multipart/form-data">
    @csrf

    <div class="mb-3">
        <label for="name" class="form-label">Nome</label>
        <input type="text" class="form-control" id="name" name="name" placeholder="Nome da categoria">
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

                <button type="submit" class="btn btn-primary ml-3">Salvar</button>
            
        </form>

@endsection

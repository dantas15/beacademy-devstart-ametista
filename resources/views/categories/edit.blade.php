@extends('layouts.dashboard')
@section('title', 'Editar categoria')
@section('content')
<ul class="nav nav-tabs">
    <li class="nav-item">
        <a class="nav-link active" aria-current="page" href="{{ route('admin.categories.edit', $category->id)}}">
            Informações da categoria
        </a>
    </li>

</ul>
<hr class="mt-0 mb-4">
<div class="card mb-4">
    <!-- <div class="card-header">Informações principais</div> -->
    <div class="card-body">
        <form action="{{ route('admin.categories.update', $category->id) }}" method="post">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="name" class="form-label">Nome</label>
                <input value="{{ $category->name }}" type="text" class="form-control" id="name" name="name" placeholder="Digite uma categoria">
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
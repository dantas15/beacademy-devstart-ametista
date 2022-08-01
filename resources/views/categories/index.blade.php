@extends('layouts.dashboard')
@section('title', 'Categorias')
@section('content')
    <h1 class="container">Listagem de Categorias</h1>
    <a href="{{ route('admin.categories.create') }}" class="btn btn-success">Nova Categoria</a>
    <table class="table container">
        <thead class="table-light">
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Nome</th>
                <th scope="col">Ações</th>
            </tr>
        </thead>
        <tbody class="table-group-divider">
            @foreach ($categories as $category)
                <tr>
                    <th scope="row">{{ $category->id }}</th>
                    <td>{{ $category->name }}</td>
                    <td>{{ date('d/m/Y', strtotime($category->created_at)) }}</td>

                    <td><a href="{{-- route('admin.categories.show', $category->id) --}}" class="btn btn-info text-white">Visualizar</a></td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="row" >
            <div class="col-md-12">
                {{ $categories->links('pagination::bootstrap-5') }}
            </div>
        </div>

@endsection


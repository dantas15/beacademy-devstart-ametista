@extends('layouts.dashboard')
@section('title', 'Usuários')
@section('content')
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Laravel 9 CRUD Tutorial Example</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-2">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left">
                    <h2>Tela de Produtos</h2>
                </div>
                <div class="pull-right mb-2">
                    <a class="btn btn-success" href="{{ route('admin.products.create') }}"> Criar novo produto</a>
                </div>
                <div class="pull-right mb-2">
                    <a class="btn btn-success" href="{{ route('admin.categories.create') }}"> Criar nova categoria</a>
                </div>   
            </div>
        </div>
        @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
        @endif
        <table class="table table-bordered">
            <tr>
                <th>id</th>
                <th>Nome</th>
                <th>Descrição</th>
                <th>Categoria</th>
                <th>Quantidade</th>
                <th>Preço de custo</th>
                <th>Preço de venda</th>
                <th>Foto principal</th>
                <th width="280px">Ação</th>
            </tr>
            @foreach ($products as $product)
            <tr>
                <td>{{ $product->id }}</td>
                <td>{{ $product->name }}</td>
                <td>{{ $product->description }}</td>
                <td>{{ $product->category->name }}</td>
                <td>{{ $product->amount }}</td>
                <td>{{ number_format($product->cost_price, 2,',','.') }}</td>
                <td>{{ number_format($product->sale_price, 2,',','.') }}</td>
                <td>
                    <img src="{{ $product->main_photo }}" width="100">
                </td>
                <td>
                    <form action="{{ route('admin.products.destroy',$product->id) }}" method="Post">
                        <a class="btn btn-primary" href="{{ route('admin.products.edit',$product->id) }}">Editar</a>
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Deletar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </table>

        <div class="row" >
            <div class="col-md-12">
                {!! $products->links() !!}
            </div>
        </div>
    </div>

</body>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    $('.shadow-sm').hide();
</script>

</html>

@endsection

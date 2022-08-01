@extends('layouts.dashboard')
@section('title', 'Produtos')
@section('content')

    <div class="row">
        <div class="col-md-12">

            <h1 class="container">Listagem de Produtos</h1>
            <a href="{{ route('admin.products.create') }}" class="btn btn-success">Novo Produto</a>
            <table class="table container">
                <thead class="table-light">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nome</th>
                        <th scope="col">Descrição</th>
                        <th scope="col">Categoria</th>
                        <th scope="col">Quantidade</th>
                        <th scope="col">Preço de custo</th>
                        <th scope="col">Preço de venda</th>
                        <th scope="col">Foto principal</th>
                        <th scope="col">Ações</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    @foreach ($products as $product)
                        <tr>
                            <th scope="row">{{ $product->id }}</th>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->description }}</td>
                            <td>{{ $product->category->name }}</td>
                            <td>{{ $product->amount }}</td>
                            <td>{{ number_format($product->cost_price, 2,',','.') }}</td>
                            <td>{{ number_format($product->sale_price, 2,',','.') }}</td>
                            <td>
                                <img src="/{{ $product->main_photo }}" width="100">
                            </td>
                            <td><a href="{{ route('admin.products.show', $product->id) }}" class="btn btn-info text-white">Visualizar</a></td>
                        </tr>
                    @endforeach
                </tbody>

            </table>
            
            </div>
        </div>

        <div class="row" >
            <div class="col-md-12">
                {{ $products->links('pagination::bootstrap-4') }}
            </div>
        </div>

@endsection

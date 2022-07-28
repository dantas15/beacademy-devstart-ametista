@extends('layouts.dashboard')
@section('title', 'Editar produto')
@section('content')
<ul class="nav nav-tabs">
    <li class="nav-item">
        <a class="nav-link active" aria-current="page" href="{{ route('admin.products.edit', $product->id)}}">
            Informações do produto
        </a>
    </li>

</ul>
<hr class="mt-0 mb-4">
<div class="card mb-4">
    <!-- <div class="card-header">Informações principais</div> -->
    <div class="card-body">
        <form action="{{ route('admin.products.update', $product->id) }}" method="post">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="name" class="form-label">Nome</label>
                <input value="{{ $product->name }}" type="text" class="form-control" id="name" name="name" placeholder="João da Silva" >
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
                <label for="description" class="form-label">Descrição</label>
                <input value="{{ $product->name }}" type="text" class="form-control" id="description" name="description" placeholder="Descrição do produto" >
            </div>
            @error('description')
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->get('description') as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @enderror

            <div class="mb-3">
                <label for="category_id" class="form-label">Categoria</label>
                <select name="category_id" class="form-control">
                    <option value="">Selecione</option>
                    @foreach($categories as $category)
                    <option value="{{$category->id}}" @if( $category->id == $product->category_id )
                        selected
                        @endif

                        >

                        {{$category->name}}

                    </option>
                    @endforeach
                </select>
            </div>
            @error('category')
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->get('category_id') as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @enderror

            <div class="mb-3">
                <label for="amount" class="form-label">Quantidade</label>
                <input value="{{$product->amount}}" type="number" class="form-control" id="number" name="amount"  placeholder="Quantidade de produto">
            </div>
            @error('password')
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->get('amount') as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @enderror

            <div class="mb-3">
                <label for="cost_price" class="form-label">Preço de custo</label>
                <input value="{{$product->cost_price}}" type="text" class="form-control money" id="number" name="cost_price" placeholder="Preço de custo do produto" >
            </div>
            @error('cost_price')
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->get('cost_price') as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @enderror

            <div class="mb-3">
                <label for="sale_price" class="form-label">Preço de venda</label>
                <input value="{{$product->sale_price}}" type="text" class="form-control money" id="sale_price" name="sale_price" placeholder="Preço de venda do produto" >
            </div>
            @error('sale_price')
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->get('sale_price') as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @enderror

            <div class="mb-3">
                <label for="main_photo" class="form-label">Foto principal</label>
                <input type="file" class="form-control" id="main_photo" name="main_photo" >

                <div style="margin-top:5px">
                    <img width="120" src="/{{$product->main_photo}}">
                </div>

            </div>
            @error('main_photo')
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->get('main_photo') as $error)
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

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js" type="text/javascript"></script>
<script src="/js/jquery.maskMoney.js" type="text/javascript"></script>

<script>
    $(function() {
        // $('.money').maskMoney();
        $(".money").maskMoney({
            prefix: 'R$ ',
            allowNegative: true,
            thousands: '.',
            decimal: ',',
            affixesStay: false
        });
    })
</script>


@endsection
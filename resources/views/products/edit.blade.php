<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Editar produto</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-2">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left">
                    <h2>Editar produto</h2>
                </div>
                <div class="pull-right">
                    <a class="btn btn-primary" href="{{ route('admin.products.index') }}" enctype="multipart/form-data"> Voltar</a>
                </div>
            </div>
        </div>
        @if(session('status'))
        <div class="alert alert-success mb-1 mt-1">
            {{ session('status') }}
        </div>
        @endif
        <form action="{{ route('admin.products.update',$product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Nome:</strong>
                        <input type="text" name="name" value="{{ $product->name }}" class="form-control" placeholder="Nome do produto...">
                        @error('name')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Descrição:</strong>
                        <input type="text" name="description" value="{{ $product->description }}" class="form-control" placeholder="Descrição do produto...">
                        @error('description')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Categoria:</strong>
                        <select name="category_id" class="form-control" >
                            <option value="">Selecione</option>
                            @foreach($categories as $category)
                                <option @if( $category->id == $product->category_id )
                                    selected
                                @endif value="{{$category->id}}">  {{$category->name}}</option>
                            @endforeach
                        </select>
                        <!-- <input type="text" name="descricao" value="{{ $product->descricao }}" class="form-control" placeholder="Descrição do product..."> -->
                        @error('category_id')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Quantidade:</strong>
                        <input type="text" name="amount" class="form-control" placeholder="Quantidade do produto..." value="{{ $product->amount }}">
                        @error('amount')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Preço de custo:</strong>
                        <input type="text" name="cost_price" class="form-control money" placeholder="Preço de custo do produto..." value="{{ $product->cost_price }}">
                        @error('cost_price')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Preço de venda:</strong>
                        <input type="text" name="sale_price" class="form-control money" placeholder="Preço de venda do produto..." value="{{ $product->sale_price }}">
                        @error('sale_price')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Foto principal:</strong>
                        <input type="file" name="main_photo" class="form-control" value="{{ $product->main_photo }}" >
                        <!-- <input type="text" name="foto_principal" class="form-control" placeholder="Foto principal do product..."> -->
                        @error('main_photo')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <button type="submit" class="btn btn-primary ml-3">Editar</button>
            </div>
        </form>
    </div>
</body>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js" type="text/javascript"></script>
<script src="/js/jquery.maskMoney.js" type="text/javascript"></script>

<script>
  $(function() {
    // $('.money').maskMoney();
    $(".money").maskMoney({prefix:'R$ ', allowNegative: true, thousands:'.', decimal:',', affixesStay: false});
  })

</script>

</html>

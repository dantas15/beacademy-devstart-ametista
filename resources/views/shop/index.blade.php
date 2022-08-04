@extends('layouts.home')
@section('title', 'Shop')
@section('content')
    <div class="row">
        <div class="col-md-12">
            @if(session()->get('success') != null)
                <div class="alert alert-success">
                    {{ session()->get('success') }}
                </div>
            @endif
            @if(isset($products))
                <div class="d-flex mb-2">
                    @if(isset($searchQuery))
                        <h2 class="ms-0 flex-grow-1">Exibindo resultados para: <span
                                class="fs-3 fw-lighter fst-italic">{{ $searchQuery }}</span></h2>
                    @else
                        <h2 class="ms-0 flex-grow-1">Todos os produtos disponíveis</h2>
                    @endif
                    <form action="{{ route('shop.index') }}" class="d-flex text-white" role="search">
                        <input class="form-control me-2" type="search" placeholder="Pesquisar por nome ou descrição"
                               aria-label="Search" value="{{ $searchQuery ?? '' }}" name="search">
                        <button class="btn btn-success text-white" type="submit">Pesquisar</button>
                    </form>
                </div>

                <hr/>

                <div class="row">
                    @if(count($products) == 0)
                        <div class="col-md-12">
                            <div class="alert alert-info">
                                Nenhum produto encontrado.
                            </div>
                        </div>
                    @endif

                    @foreach($products as $product)
                        <div class="col-md-3 mb-4">
                            <div class="card">
                                <img class="card-img-top" src="{{ $product->main_photo }}"
                                     alt="Card image cap">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $product->name }}</h5>
                                    <p class="card-text">{{ $product->description }}</p>
                                    <p class="card-text fw-bold">R$ {{ $product->sale_price }}</p>
                                    <form
                                        action="{{ route('shop.cart.store', ['productId' => $product->id, 'amount' => 1]) }}"
                                        method="post">
                                        @csrf
                                        @method('POST')
                                        <button type="submit" class="btn btn-outline-success">
                                            Adicionar ao carrinho
                                        </button>
                                    </form>
                                    {{--                                    <a href="#" class="btn btn-ouline-primary">Visualizar</a>--}}
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <div class="row">
                        <div class="col-md-12">
                            {{ $products->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

@extends('layouts.home')
@section('title', 'Carrinho')
@section('content')
    <div class="row">
        <div class="col-md-12">
            @if(session()->get('success') != null)
                <div class="alert alert-success">
                    {{ session()->get('success') }}
                </div>
            @endif

            @if(session()->get('cart') != null)
                <div class="d-flex justify-content-between">
                    <h2>Produtos no carrinho</h2>
                    <form
                        action="{{ route('shop.cart.clear') }}"
                        method="Post"
                    >
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Limpar carrinho</button>
                    </form>
                </div>

                <hr/>

                @foreach(session()->get('cart') as $item)
                    <div class="list-group">
                        <div class="list-group-item mb-2">
                            <div class="d-flex w-100 justify-content-between">
                                <h5 class="mb-1">{{ $item['name'] }}</h5>

                                <form
                                    action="{{ route('shop.cart.destroy', ['productId' => $item['id'], 'amount' => $item['amount']]) }}"
                                    method="Post"
                                >
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger">Remover</button>
                                </form>
                                {{--<small class="text-muted">3 days ago</small>--}}
                            </div>
                            <p class="mb-1">
                                Preço: R$ {{ $item['price'] }}
                            </p>
                            <small class="text-muted">
                                <span class="fw-bold">Preço por unidade: </span>
                                R$ {{ $item['price'] }} ({{ $item['amount'] }} unidades)

                                <form
                                    action="{{ route('shop.cart.destroy', ['productId' => $item['id'], 'amount' => 1]) }}"
                                    method="post" class="d-inline"
                                >
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger"> - 1</button>
                                </form>
                            </small>
                        </div>
                    </div>
                @endforeach

                <h2>Total: R$ <span class="fw-bold">{{ session()->get('totalCartPrice') }}</span></h2>

                <a class="btn btn-success" href="{{ route('shop.checkout.selectAddress') }}">Finalizar pedido</a>

            @else
                <div class="alert alert-info">
                    Nenhum produto no carrinho.
                </div>
            @endif
        </div>
    </div>
@endsection

@extends('layouts.home')
@section('title', 'Página incial')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                @if(isset($products))
                    <h2>Produtos <a href="#" class="btn btn-primary">Ver todos</a></h2>
                    <div class="row">
                        @foreach($products as $product)
                            <div class="col-md-3 mb-4">
                                <div class="card">
                                    <img class="card-img-top" src="{{ $product->main_photo }}"
                                         alt="Card image cap">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $product->name }}</h5>
                                        <p class="card-text">{{ $product->description }}</p>
{{--                                        <a href="" class="btn btn-ouline-primary">Visualizar</a>--}}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <a href="{{ route('shop.index') }}" class="btn btn-primary">Ver todos...</a>
                @endif
            </div>
        </div>

@endsection

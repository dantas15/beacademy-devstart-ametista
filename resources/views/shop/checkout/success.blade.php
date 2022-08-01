@extends('layouts.home')
@section('title', 'Sucesso')
@section('content')
    @if(session()->get('success') != null)
        <div class="alert alert-success">
            {{ session()->get('success') }}
        </div>
    @endif
    @if(session()->get('error') != null)
        <div class="alert alert-danger">
            {{ session()->get('error') }}
        </div>
    @endif

    <div class="d-flex justify-content-center align-items-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h2 class="card-title">Compra realizada com sucesso!</h2>
                    <p class="card-text">
                        Obrigado por comprar conosco!
                    </p>
                    <a href="{{ route('shop.index') }}" class="btn btn-primary">
                        Continuar comprando
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

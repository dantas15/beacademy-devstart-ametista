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
            @if(session()->get('error') != null)
                <div class="alert alert-danger">
                    {{ session()->get('error') }}
                </div>
            @endif

            <h2>Selecione um endereço</h2>
            
            @if(count($addresses) <= 0)
                <span class="fs-5 text-muted">Nenhum endereço encontrado!</span>
            @endif

            @if (count($addresses) > 0)
            @endif
            @foreach ($addresses as $address)
                <div class="card mb-4" role="link">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">Endereço {{ $loop->index + 1 }}</p>
                            </div>
                            <div class="col-sm-6">
                                <p class="text-muted mb-0">
                                    {{ $address->street }}
                                    , {{ $address->number ?? 'Sem número' }}
                                    , {{ $address->complement ?? 'Sem complemento' }}
                                    , {{ $address->neighborhood ?? 'Sem bairro' }}
                                </p>
                                <p class="text-muted mb-0">
                                    {{ $address->zip }}. {{ $address->city }} - {{ $address->uf }}
                                </p>
                            </div>
                            <div class="col-sm-3 d-flex flex-row-reverse align-content-start flex-wrap">
                                <div class="btn-group" role="group">
                                    <a href="{{ route('me.addresses.edit', ['id' => $address->id]) }}"
                                       class="btn btn-outline-secondary">
                                        Editar
                                    </a>
                                    <a
                                        class="btn btn-primary"
                                        href="{{ route('shop.checkout.paymentForm', ['addressId' => $address->id]) }}">
                                        Selecionar
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

            <div class="w-100 gap-2 d-flex flex-row-reverse" role="group">
                <a href="{{ route('me.addresses.create') }}" class="btn btn-outline-secondary">
                    <span class="fs-6">+</span> Cadastrar Novo
                </a>
            </div>
        </div>
    </div>
@endsection

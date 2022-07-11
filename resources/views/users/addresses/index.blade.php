@extends('layouts.home')
@section('title', 'Editar usuário')
@section('content')
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('users.edit', ['id' => $userId])}}">
                Dados principais
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" aria-current="page"
               href="{{ route('users.addresses.index', ['userId' => $userId]) }}">
                Endereços
            </a>
        </li>
    </ul>

    <h2 class="mt-2">Endereços cadastrados</h2>

    @if(count($addresses) <= 0)
        <span class="fs-5 text-muted">Nenhum endereço encontrado!</span>
    @endif

    @foreach($addresses as $address)

        <div class="card mb-4">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-3">
                        <p class="mb-0">Endereço {{ $loop->index + 1 }}</p>
                    </div>
                    <div class="col-sm-6">
                        <p class="text-muted mb-0">
                            {{ $address->street }}
                            , {{ $address->number ?? 'Sem número'}}
                            , {{ $address->complement ?? 'Sem complemento' }}
                            , {{ $address->neighborhood ?? 'Sem bairro' }}
                        </p>
                        <p class="text-muted mb-0">
                            {{ $address->zip }}. {{ $address->city }} - {{ $address->uf }}
                        </p>
                    </div>
                    <div class="col-sm-3 d-flex flex-row-reverse align-content-start flex-wrap">
                        <div class="btn-group" role="group">
                            <a href="#" class="btn btn-danger">Remover</a>
                            <a href="{{ route('users.addresses.edit', [ 'userId' => $userId, 'id' => $address->id]) }}"
                               class="btn btn-warning">
                                Editar
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <div class="w-100 gap-2 d-flex flex-row-reverse" role="group">
        <a href="{{ route('users.addresses.create', ['userId' => $userId]) }}" class="btn btn-outline-success">
            <span class="fs-6">+</span> Cadastrar Novo
        </a>
    </div>

@endsection

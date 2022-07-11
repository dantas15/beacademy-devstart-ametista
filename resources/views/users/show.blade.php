@extends('layouts.home')
@section('title', 'Visualizar usuário')
@section('content')
    <h2>Informações pessoas</h2>
    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-3">
                    <p class="mb-0">Nome</p>
                </div>
                <div class="col-sm-9">
                    <p class="text-muted mb-0">{{ $user->name }}</p>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-sm-3">
                    <p class="mb-0">Email</p>
                </div>
                <div class="col-sm-9">
                    <p class="text-muted mb-0">{{ $user->email }}</p>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-sm-3">
                    <p class="mb-0">Telefone</p>
                </div>
                <div class="col-sm-9">
                    <p class="text-muted mb-0">{{ $user->phone_number }}</p>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-sm-3">
                    <p class="mb-0">Data de nascimento</p>
                </div>
                <div class="col-sm-9">
                    <p class="text-muted mb-0">{{ $user->birth_date }}</p>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-sm-3">
                    <p class="mb-0">CPF / CNPJ</p>
                </div>
                <div class="col-sm-9">
                    <p class="text-muted mb-0">{{ $user->document_id }}</p>
                </div>
            </div>
        </div>
    </div>

    <h2>Endereços cadastrados</h2>

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
                    <div class="col-sm-9">
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
                </div>
            </div>
        </div>
    @endforeach

    <div class="w-100 gap-2 d-flex flex-row-reverse" role="group">
        <a href="javascript:void(0)" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#destroyModal">
            Remover
        </a>
        <a href="{{ route('users.edit', ['id' => $user->id ]) }}" class="btn btn-warning">Editar</a>
    </div>

    <div class="modal fade" id="destroyModal" tabindex="-1" aria-labelledby="destroyModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="destroyModalLabel">Você tem certeza?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Este usuário será excluído
                </div>
                <div class="modal-footer">
                    <a href="{{ route('users.destroy', [ 'id' => $user->id]) }}" id="confirm_address_destroy"
                       class="btn btn-warning">
                        Excluir
                    </a>
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">
                        Manter usuário
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

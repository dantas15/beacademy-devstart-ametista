@extends('layouts.home')
@section('title', 'Editar meus endereços')
@section('content')
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('me.index') }}">
                Dados principais
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="{{ route('me.addresses.index') }}">
                Endereços
            </a>
        </li>
    </ul>

    <h2 class="mt-2">Endereços cadastrados</h2>

    @if (count($addresses) <= 0)
        <span class="fs-5 text-muted">Nenhum endereço encontrado!</span>
    @endif

    @foreach ($addresses as $address)
        <div class="card mb-4">
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
                            <a href="javascript:void(0)" onclick="selectAddressId('{{ $address->id }}')"
                                data-bs-toggle="modal" data-bs-target="#destroyModal" class="btn btn-danger">
                                Remover
                            </a>
                            <a href="{{ route('me.addresses.edit', ['id' => $address->id]) }}" class="btn btn-warning">
                                Editar
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <div class="w-100 gap-2 d-flex flex-row-reverse" role="group">
        <a href="{{ route('me.addresses.create') }}" class="btn btn-outline-success">
            <span class="fs-6">+</span> Cadastrar Novo
        </a>
    </div>

    <div class="modal fade" id="destroyModal" tabindex="-1" aria-labelledby="destroyModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="destroyModalLabel">Você tem certeza?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Este endereço será excluído
                </div>
                <div class="modal-footer">
                    <form id="confirm_address_destroy" action="" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-warning">
                            Excluir
                        </button>
                    </form>
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">
                        Manter endereço
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        const destroyAddressUrl = "{{ route('me.addresses.destroy', ['id' => 'addressId']) }}";

        function selectAddressId(addressId) {
            const form = document.getElementById('confirm_address_destroy');

            form.action = destroyAddressUrl.replace('addressId', addressId);
        }
    </script>

@endsection

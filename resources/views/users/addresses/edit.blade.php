@extends('layouts.home')
@section('title', 'Cadastrar endereço')
@section('content')
    <h1>Editar endereço de {{ $user->name }}</h1>
    <form action="{{ route('users.addresses.update', ['userId' => $user->id, 'id' => $address->id]) }}" method="post">
        @method('PUT')
        @csrf
        <div class="row mb-3">
            <div class="col-12 col-md-6">
                <div>
                    <label for="zip" class="form-label">CEP</label>
                    <input value="{{$address->zip}}" type="text" class="form-control" id="zip" name="zip"
                           minlength="8" maxlength="9" pattern="(^[0-9]{5}-?[0-9]{3}$)" required>
                </div>
                @error('zip')
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->get('zip') as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @enderror
            </div>
            <div class="col-12 col-md-6">
                <div>
                    <label for="neighborhood" class="form-label">Bairro</label>
                    <input value="{{$address->neighborhood}}" type="text" class="form-control" id="neighborhood"
                           name="neighborhood" required>
                </div>
                @error('neighborhood')
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->get('neighborhood') as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-9 col-md-6">
                <div>
                    <label for="street" class="form-label">Rua</label>
                    <input value="{{$address->street}}" type="text" class="form-control" id="street" name="street"
                           required>
                </div>
                @error('street')
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->get('street') as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @enderror
            </div>
            <div class="col-3 col-md-2">
                <div>
                    <label for="number" class="form-label">Número</label>
                    <input value="{{$address->number}}" type="text" class="form-control" id="number" name="number"
                           required>
                </div>
                @error('number')
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->get('number') as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @enderror
            </div>
            <div class="col-9 col-md-3">
                <div>
                    <label for="city" class="form-label">Cidade</label>
                    <input value="{{$address->city}}" type="text" class="form-control" id="city" name="city" required>
                </div>
                @error('city')
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->get('city') as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @enderror
            </div>
            <div class="col-3 col-md-1">
                <div>
                    <label for="uf" class="form-label">UF</label>
                    <input value="{{$address->uf}}" type="text" class="form-control" id="uf" name="uf" maxlength="2"
                           required>
                </div>
                @error('uf')
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->get('uf') as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @enderror
            </div>
        </div>

        <div class="form-floating mb-3">
            <textarea id="complement" name="complement" class="form-control"
                      placeholder="Digite algumas informações adicionais..."
            >
                {{$address->complement}}
            </textarea>
            <label for="complement">Complemento (opcional)</label>
        </div>
        @error('complement')
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->get('complement') as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @enderror

        <div class="d-flex gap-2 flex-row-reverse">
            <button type="submit" class="btn btn-primary">Enviar</button>
            <button type="button" class="btn btn-outline-warning" data-bs-toggle="modal" data-bs-target="#cancelModal">
                Cancelar
            </button>
        </div>
    </form>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Modal -->
    <div class="modal fade" id="cancelModal" tabindex="-1" aria-labelledby="cancelModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cancelModalLabel">Você tem certeza?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Os dados não salvos serão perdido
                </div>
                <div class="modal-footer">
                    <a href="{{ route('users.addresses.index', ['userId' => $user->id]) }}" class="btn btn-secondary">
                        Cancelar mesmo assim
                    </a>
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">
                        Continuar editando
                    </button>
                </div>
            </div>
        </div>
    </div>

@endsection

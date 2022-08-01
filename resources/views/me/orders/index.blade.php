@extends('layouts.home')
@section('title', 'Editar meus dados')
@section('content')
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('me.index') }}">
                Dados principais
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('me.addresses.index') }}">
                Endereços
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="{{ route('me.orders') }}">
                Pedidos
            </a>
        </li>
    </ul>

    <hr class="mt-0 mb-4">

    <div class="card mb-4">
        <div class="card-header">Pedidos</div>
        <div class="card-body">
            @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p>{{ $message }}</p>
                </div>
            @endif

            <table class="table table-striped">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Status</th>
                    <th>Data</th>
                    <th>Total</th>
                    <th>Produtos</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($orders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>
                            @if ($order->status_id == 1)
                                <span class="badge text-dark">Pendente</span>
                            @endif
                            @if($order->status_id == 2)
                                <span class="badge text-dark">Pago</span>
                            @endif
                            @if ($order->status_id == 3)
                                <span class="badge text-dark">Cancelado</span>
                            @endif
                        </td>
                        <td>{{ $order->created_at }}</td>
                        <td>{{ $order->total_price }}</td>
                        <td>
                            @foreach ($order->order_products as $orderProd)
                                <p class="badge text-dark">{{ $orderProd->product->name }}</p>
                            @endforeach
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{ $orders->links('pagination::bootstrap-5') }}
        </div>
    </div>

@endsection

@extends('layouts.dashboard')
@section('title', 'Pedidos')
@section('content')
    <div class="row justify-content-center">
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
                        <th>Usuário</th>
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
                            <td>
                                <a href="{{ route('admin.users.show', $order->user->id) }}"
                                   class="btn btn-sm btn-info text-white">
                                    {{ $order->user->name }}
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {{ $orders->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
@endsection

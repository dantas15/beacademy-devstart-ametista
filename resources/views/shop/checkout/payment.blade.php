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

            <section aria-labelledby="payment-heading"
                     class="d-flex overflow-auto">
                <div class="mx-auto">

                    <div id="selectPaymentButtons">
                        <h2 class="text-center py-40 fs-4">Escolha o Método de Pagamento</h2>
                        <div class="d-flex justify-content-center">
                            <div>
                                <button onclick="showPayment('creditCard')" type="submit"
                                        class="btn btn-outline-success py-2 px-20 rounded-1">
                                    Cartão de crédito
                                </button>
                                <button onclick="showPayment('boleto')" type="submit"
                                        class="btn btn-outline-success py-2 px-20 rounded-1">
                                    Boleto
                                </button>
                            </div>
                        </div>
                    </div>

                    <div
                        id="paymentCreditCard"
                        style="display: none;"
                    >
                        <h2 class="text-center fs-4">
                            Pagamento por cartão de crédito -
                            <button class="btn btn-outline-secondary" type="button" onclick="showPayment('select')">
                                Selecionar outro método de pagamento
                            </button>
                        </h2>

                        <form class="mt-6" action="{{ route('shop.checkout.payment', ['addressId' => $address->id, 'payment_method' => 'credit_card']) }}" method="POST">
                            @csrf
                            <div class="container-sm px-5">

                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" placeholder="joao@gmail.com"
                                           name="email" value="{{ Auth::user()->email }}">
                                </div>

                                <div class="mb-3">
                                    <label for="name" class="form-label">Nome no cartão</label>
                                    <input type="text" class="form-control" id="name" placeholder="João da Silva"
                                           name="name" value="{{ Auth::user()->name }}">
                                </div>

                                <div class="mb-3">
                                    <label for="creditNumber" class="form-label">Número no cartão</label>
                                    <input type="text" class="form-control" id="creditNumber" name="creditNumber">
                                </div>

                                <div class="row mb-3">
                                    <div class="col-6">
                                        <label for="expDate" class="form-label">Data de expedição</label>
                                        <input type="month" class="form-control" id="expDate" name="expDate">
                                    </div>

                                    <div class="col-6">
                                        <label for="cvc" class="form-label">CVC</label>
                                        <input type="number" maxlength="3" class="form-control" id="cvc" name="cvc">
                                    </div>
                                </div>

                                <button type="submit"
                                        class="btn btn-success">
                                    Pagar R$ <span class="fw-bold">{{ session()->get('totalCartPrice') }}</span>
                                </button>
                            </div>
                        </form>
                    </div>

                    <div
                        id="paymentBoleto"
                        style="display: none;"
                    >
                        <h2 class="flex justify-center py-5">
                            Pagamento por Boleto -
                            <button class="btn btn-outline-secondary" type="button" onclick="showPayment('select')">
                                Selecionar outro método de pagamento
                            </button>
                        </h2>
                        <form class="mt-6" action="{{ route('shop.checkout.payment', ['addressId' => $address->id, 'payment_method' => 'boleto']) }}" method="POST">
                            @csrf
                            <div class="row mb-3">
                                <div class="col-6">
                                    <label for="name" class="form-label">Nome completo</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                           value="{{ Auth::user()->name  }}" disabled>
                                </div>

                                <div class="col-6">
                                    <label for="document_id" class="form-label">Documento (CPF)</label>
                                    <input type="text" class="form-control" id="document_id"
                                           name="document_id" value="{{Auth::user()->document_id}}" disabled>
                                </div>
                            </div>

                            <button type="submit"
                                    class="btn btn-success">
                                Pagar R$ <span class="fw-bold">{{ session()->get('totalCartPrice') }}</span>
                            </button>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <script>
        function showPayment(payment) {
            if (payment === 'creditCard') {
                document.getElementById('paymentCreditCard').style.display = 'block';
                document.getElementById('selectPaymentButtons').style.display = 'none';
            }

            if (payment === 'boleto') {
                document.getElementById('paymentBoleto').style.display = 'block';
                document.getElementById('selectPaymentButtons').style.display = 'none';
            }

            if (payment === 'select') {
                document.getElementById('selectPaymentButtons').style.display = 'block';
                document.getElementById('paymentCreditCard').style.display = 'none';
                document.getElementById('paymentBoleto').style.display = 'none';
            }
        }
    </script>
@endsection

@extends('layouts.app')
@section('content')

<div class="main-content app-content mt-0">
    <div class="side-app">

        <!-- CONTAINER -->
        <div class="main-container container-fluid">

            <!-- PAGE-HEADER -->
            <div class="page-header">
                <h1>Pendapatan</h1>
            </div>
            <!-- PAGE-HEADER END -->

            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <a href="{{ route('finance.piutang.sales-order.index') }}">
                                        <div class="card text-white card-transparent" style="background-color: #59758B;">
                                            <div class="card-body" style="text-align: center">
                                                <img src="{{ url('assets/images/icon/sales-order.png') }}" alt="">
                                                <h4 class="card-title mt-2">Sales Order</h4>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-md-4">
                                    <a href="{{ route('finance.piutang.invoice.index') }}">
                                        <div class="card text-white card-transparent" style="background-color: #59758B;">
                                            <div class="card-body" style="text-align: center">
                                                <img src="{{ url('assets/images/icon/invoice.png') }}" alt="">
                                                <h4 class="card-title mt-2">Invoice</h4>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-md-4">
                                    <a href="{{ route('finance.piutang.receive-payment.index') }}">
                                        <div class="card text-white card-transparent" style="background-color: #59758B;">
                                            <div class="card-body" style="text-align: center">
                                                <img src="{{ url('assets/images/icon/receive-payment.png') }}" alt="">
                                                <h4 class="card-title mt-2">Receive Payment</h4>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- CONTAINER CLOSED -->
    </div>
</div>

@endsection
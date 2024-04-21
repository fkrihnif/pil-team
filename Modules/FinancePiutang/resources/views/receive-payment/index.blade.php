@extends('layouts.app')
@section('content')

    <div class="main-content app-content mt-0">
        <div class="side-app">

            <!-- CONTAINER -->
            <div class="main-container container-fluid">

                <!-- PAGE-HEADER -->
                <div class="page-header">
                    <h1>Receive Payment</h1>
                </div>
                <!-- PAGE-HEADER END -->

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="d-flex d-inline">
                            <input type="text" class="form-control col-5" placeholder="Searching.....">&nbsp;&nbsp;
                            <a class="btn btn-primary" href="{{ route('finance.piutang.receive-payment.create') }}"><i
                                    class="fe fe-plus me-2"></i>Add New</a>&nbsp;&nbsp;
                            <button type="button" class="btn btn-light"><img
                                    src="{{ url('assets/images/icon/filter.png') }}" alt=""></button>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body">
                                @if ($errors->any())
                                    <div class="alert alert-danger" role="alert">
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-hidden="true">×</button>
                                        <strong>Whoops!</strong>
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <div class="table-responsive">
                                    <table class="table text-nowrap text-md-nowrap mb-0">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Date</th>
                                                <th>Job Order ID</th>
                                                <th>No Transaksi</th>
                                                <th>Customer Name</th>
                                                <th>Description</th>
                                                <th>Value</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>1</td>
                                                <td>14/01/2023</td>
                                                <td>MPIL-00002</td>
                                                <td>SJ00002</td>
                                                <td>Ahmad</td>
                                                <td>Pengantaran Barang</td>
                                                <td>Rp. 100.000</td>
                                                <td><span class="badge bg-primary">Waiting To Approval</span></td>
                                                <td>
                                                    <div class="dropdown" style="position: absolute; display: inline-block;">
                                                        <a href="javascript:void(0)" data-bs-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fe fe-more-vertical"></i></a>
                                                        <div class="dropdown-menu" style="min-width: 7rem; z-index: 999999999;">
                                                            <a href="" class="btn text-purple btn-sm dropdown-item"><span
                                                                    class="fe fe-eye fs-14"></span> Detail</a>
                                                            <a href="" class="btn text-warning btn-sm dropdown-item"><span
                                                                    class="fe fe-edit fs-14"></span> Edit</a>
                                                            <a href="" class="btn text-danger btn-sm dropdown-item" onclick="if (confirm('Are you sure want to delete this item?')) {
                                                                event.preventDefault();
                                                                document.getElementById('').submit();
                                                            }else{
                                                                event.preventDefault();
                                                            }"><span class="fe fe-trash fs-14"></span> Delete</a>

                                                            <form id="" action="" style="display: none;" method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                            </form>   
                                                            
                                                            <a href="" class="btn text-green btn-sm dropdown-item"><span
                                                                class="fe fe-file-text fs-14"></span> Journal</a>
                                                            <a href="" class="btn text-green btn-sm dropdown-item"><span
                                                                class="fe fe-check fs-14"></span> Approval</a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>2</td>
                                                <td>29/01/2023</td>
                                                <td>MPIL-00001</td>
                                                <td>SJ00001</td>
                                                <td>Ahmad</td>
                                                <td>Pengantaran Barang</td>
                                                <td>Rp. 5.000.000</td>
                                                <td><span class="badge bg-success">Approved</span></td>
                                                <td>
                                                    <div class="dropdown" style="position: absolute; display: inline-block;">
                                                        <a href="javascript:void(0)" data-bs-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fe fe-more-vertical"></i></a>
                                                        <div class="dropdown-menu" style="min-width: 7rem; z-index: 999999999;">
                                                            <a href="" class="btn text-purple btn-sm dropdown-item"><span
                                                                    class="fe fe-eye fs-14"></span> Detail</a>
                                                            
                                                            <a href="" class="btn text-green btn-sm dropdown-item"><span
                                                                class="fe fe-file-text fs-14"></span> Journal</a>
                                                            <a href="" class="btn text-red btn-sm dropdown-item"><span
                                                                class="fe fe-corner-up-left fs-14"></span> Open</a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
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

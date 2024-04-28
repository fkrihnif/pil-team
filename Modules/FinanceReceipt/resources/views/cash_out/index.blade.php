@extends('layouts.app')
@section('content')

    <div class="main-content app-content mt-0">
        <div class="side-app">

            <!-- CONTAINER -->
            <div class="main-container container-fluid">

                <!-- PAGE-HEADER -->
                <div class="page-header">
                    <h1>Pengeluaran</h1>
                </div>
                <!-- PAGE-HEADER END -->

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="d-flex d-inline">
                            <input type="text" class="form-control col-5" placeholder="Searching.....">&nbsp;&nbsp;
                            <a class="btn btn-warning-light btn-wave" href="{{ route('finance.receipt.cash-out.create') }}"><i
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
                                                <th>No Transaksi</th>
                                                <th>Nama</th>
                                                <th>Description</th>
                                                <th>Value</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($data as $item)
                                            @php
                                                $pageNumber = $data->currentPage();
                                                $index = ($pageNumber - 1) * $data->perPage() + $loop->index + 1;
                                            @endphp
                                                <tr>
                                                    <td>{{ $index }}</td>
                                                    <td>{{ isset($item->date) ? $item->date : null }}</td>
                                                    <td>{{ isset($item->transaction_no) ? $item->transaction_no : null }}</td>
                                                    <td>{{ isset($item->name) ? $item->name : null }}</td>
                                                    <td>{{ isset($item->description) ? $item->description : null }}</td>
                                                    <td>{{ isset($item->has_details_sum_total) ? $item->initial." ".$item->has_details_sum_total : null }}</td>
                                                    <td>
                                                        @if ($item->status == 2)
                                                            <span class="badge bg-success">Approve</span></td>
                                                        @else
                                                            <span class="badge bg-warning">Open</span>
                                                        @endif
                                                    <td>
                                                        <div class="dropdown" style="position: absolute; display: inline-block;">
                                                            <a href="javascript:void(0)" data-bs-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fe fe-more-vertical"></i></a>
                                                            <div class="dropdown-menu" style="min-width: 7rem; z-index: 999999999;">
                                                                <a href="" class="btn text-purple btn-sm dropdown-item"><span
                                                                        class="fe fe-eye fs-14"></span> Detail</a>
                                                                <a href="/finance/receipt/cash-out/{{ $item->encryptId}}/edit" class="btn text-warning btn-sm dropdown-item"><span
                                                                        class="fe fe-edit fs-14"></span> Edit</a>
                                                                <a href="" class="btn text-danger btn-sm dropdown-item" onclick="if (confirm('Are you sure want to delete this item?')) {
                                                                    event.preventDefault();
                                                                    document.getElementById('').submit();
                                                                }else{
                                                                    event.preventDefault();
                                                                }"><span class="fe fe-trash fs-14"></span> Delete</a>
                                                                <a href="" class="btn text-green btn-sm dropdown-item"><span class="bi bi-journal-text"></span> Journal</a>
                                                                <form id="" action="" style="display: none;" method="POST">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                </form>      
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                            <tr>
                                                <td colspan="8">No data display</td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                {!! $data->withQueryString()->links() !!}
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!-- CONTAINER CLOSED -->
        </div>
    </div>

@endsection

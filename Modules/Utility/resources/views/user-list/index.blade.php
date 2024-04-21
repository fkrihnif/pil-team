@extends('layouts.app')
@section('content')

<div class="main-content app-content mt-0">
    <div class="side-app">

        <!-- CONTAINER -->
        <div class="main-container container-fluid">

            <!-- PAGE-HEADER -->
            <div class="page-header mb-0">
                <h1>Utility</h1>
            </div>
            <!-- PAGE-HEADER END -->
            <h3>User List</h3>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <div class="d-flex d-inline">
                        <input type="text" class="form-control col-5" placeholder="Searching.....">&nbsp;&nbsp;
                        <a href="{{ route('utility.user-list.create') }}" class="btn btn-primary"><i class="fe fe-plus me-2"></i>Add New</a>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table text-nowrap text-md-nowrap mb-0">
                                    <thead>
                                        <tr style="text-align: center;">
                                            <th>No</th>
                                            <th>Name</th>
                                            <th>Username</th>
                                            <th>Departement</th>
                                            <th>Level</th>
                                            <th style="width: 5%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($users as $user)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $user->name }}</td>
                                                <td>{{ $user->username }}</td>
                                                <td>{{ $user->department }}</td>
                                                <td>
                                                    @forelse ($user->getRoleNames() as $role)
                                                        <span class="badge bg-primary">{{ $role }}</span>
                                                    @empty
                                                    @endforelse
                                                </td>
                                                <td>
                                                
                                                    <a class="btn text-primary btn-sm"
                                                    data-bs-toggle="tooltip"
                                                    data-bs-original-title="Detail"><span
                                                        class="fe fe-eye fs-14"></span></a>

                                                    @if (in_array('Super Admin', $user->getRoleNames()->toArray() ?? []) )
                                                        @if (Auth::user()->hasRole('Super Admin'))
                                                            <a class="btn text-primary btn-sm"
                                                            data-bs-toggle="tooltip"
                                                            data-bs-original-title="Edit"><span
                                                                class="fe fe-edit fs-14"></span></a>
                                                        @endif
                                                    @else
                                                        @can('edit-user')
                                                            <a class="btn text-primary btn-sm"
                                                            data-bs-toggle="tooltip"
                                                            data-bs-original-title="Edit"><span
                                                                class="fe fe-edit fs-14"></span></a>
                                                        @endcan

                                                        @can('delete-user')
                                                            @if (Auth::user()->id!=$user->id)
                                                                <a class="btn text-danger btn-sm"
                                                                data-bs-toggle="tooltip"
                                                                data-bs-original-title="Delete"><span
                                                                    class="fe fe-trash-2 fs-14"></span></a>
                                                            @endif
                                                        @endcan
                                                    @endif
                                                </td>
                                            </tr>
                                            
                                        @empty
                                            
                                        @endforelse
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
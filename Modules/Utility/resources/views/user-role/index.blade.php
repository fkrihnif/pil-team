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
            <h3>User Role</h3>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <div class="d-flex d-inline">
                        <input type="text" class="form-control col-5" placeholder="Searching.....">&nbsp;&nbsp;

                        <a class="modal-effect btn btn-primary" data-bs-effect="effect-scale" data-bs-toggle="modal" href="#modaldemo8"><i class="fe fe-plus me-2"></i>Add New</a>
                    
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
                                        <tr>
                                            <th>No</th>
                                            <th>Level</th>
                                            <th style="width: 5%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($roles as $role)
                                            <tr>
                                                <th scope="row">{{ $loop->iteration }}</th>
                                                <td>{{ $role->name }}</td>
                                                <td>
                                                
                                                    <a class="btn text-primary btn-sm"
                                                    data-bs-toggle="tooltip"
                                                    data-bs-original-title="Permisson"><span
                                                        class="fe fe-shield fs-14"></span></a>

                                                    @if ($role->name!='Super Admin')
                                                        @can('edit-role')
                                                        <a class="btn text-primary btn-sm"
                                                        data-bs-toggle="tooltip"
                                                        data-bs-original-title="Edit"><span
                                                            class="fe fe-edit fs-14"></span></a>
                                                        @endcan
                        
                                                        @can('delete-role')
                                                            @if ($role->name!=Auth::user()->hasRole($role->name))
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


{{-- modal --}}

<div class="modal fade" id="modaldemo8">
    <div class="modal-dialog modal-dialog-centered text-center" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Add New User Role</h6><button aria-label="Close" class="btn-close" data-bs-dismiss="modal"><span aria-hidden="true">&times;</span></button>
            </div>
            <form action="{{ route('utility.user-role.store') }}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label class="form-label" style="text-align: left">Level</label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="fill the text" autofocus required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" type="submit">Save</button> 
                    <button class="btn btn-light" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
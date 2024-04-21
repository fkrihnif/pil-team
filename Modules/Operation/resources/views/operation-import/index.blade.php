@extends('layouts.app')
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}" />

<div class="main-content app-content mt-0">
    <div class="side-app">

        <!-- CONTAINER -->
        <div class="main-container container-fluid">

            <!-- PAGE-HEADER -->
            <div class="page-header mb-0">
                <h1>Operation</h1>
            </div>
            <!-- PAGE-HEADER END -->
            <h3>Import</h3>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <form action="{{ route('operation.import.index') }}">
                        <div class="d-flex d-inline">
                                <input type="text" name="search" id="search" value="{{ $search }}" class="form-control" placeholder="Searching.....">
                                &nbsp;&nbsp;
                                <button type="submit" class="btn btn-primary"><i class="fe fe-search me-1"></i>Search&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</button>
                            </div>
                        </form>
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
                                            <th>Job Order ID</th>
                                            <th>Departure Date</th>
                                            <th>Arrival Date</th>
                                            <th>Origin</th>
                                            <th>Destination</th>
                                            <th>Nama Penerima</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($operationImports as $key => $data)
                                        <tr>
                                            <td>{{ $operationImports->firstItem() + $key }}</td>
                                            <td>
                                                {{ $data->marketing->job_order_id }}
                                            </td>
                                            <td>{{ $data->departure_date }}</td>
                                            <td>{{ $data->arrival_date }}</td>
                                            <td>{{ $data->origin }}</td>
                                            <td>{{ $data->destination }}</td>
                                            <td>{{ $data->recepient_name }}</td>
                                            <td>
                                                @if ($data->status == 1)
                                                    On - Progress
                                                @elseif($data->status == 2)
                                                    End - Progress
                                                @endif
                                            </td>
                                            <td>
                                                <div class="g-2">
                                                    <a href="{{ route('operation.import.show', $data->id) }}" class="btn text-purple btn-sm"
                                                    data-bs-toggle="tooltip"
                                                    data-bs-original-title="Show"><span
                                                        class="fe fe-eye fs-14"></span></a>
                                                    <a href="javascript:void(0)" id="btn-progress"
                                                            data-id="{{ $data->id }}"
                                                            class="btn text-green btn-sm" data-bs-toggle="tooltip"
                                                            data-bs-original-title="Update Progress"><span
                                                                class="fe fe-file-text fs-14"></span></a>
                                                    <a href="{{ route('operation.import.edit', $data->id) }}" class="btn text-warning btn-sm"
                                                            data-bs-toggle="tooltip"
                                                            data-bs-original-title="Edit"><span
                                                                class="fe fe-edit fs-14"></span></a>
                                  
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                        <td colspan="12" align="center">
                                            <span class="text-danger">
                                                <strong>Data is Empty</strong>
                                            </span>
                                        </td>
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


{{-- modal progress --}}
<div class="modal fade" id="modal-progress" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Progress</h5>
                <button class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="progress_before"></div>
                <a href="javascript:void(0)" class="btn btn-default btn-block"
                    id="addProgress">
                    <span><i class="fa fa-plus"></i></span> Add Progress
                </a>
                <form id="formCreateProgress" style="display: none" action="{{ route('operation.import.store-progress') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="operation_import_id" id="operation_import_id">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label class="form-label">Tanggal</label>
                                        <input type="date" class="form-control" name="date_progress" id="date_progress" value="{{ old('date_progress') }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Jam</label>
                                        <input type="time" class="form-control" name="time_progress" id="time_progress" value="{{ old('time_progress') }}">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-label">Lokasi Progress Selanjutnya</label>
                                        <input type="text" class="form-control mb-2" name="location" id="location" value="{{ old('location') }}" placeholder="Nama tempat"  >
                                        <input type="text" class="form-control mb-2" name="location_desc" id="location_desc" value="{{ old('location_desc') }}" placeholder="alamat lengkap tempat"  >
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-label">Transportasi</label>
                                        <select class="form-control select2 form-select"
                                            data-placeholder="Choose one" name="transportation">
                                            <option label="Choose one" selected disabled></option>
                                            <option value="1" {{ old('transportation') == 1 ? "selected" : "" }}>Air Freight</option>
                                            <option value="2" {{ old('transportation') == 2 ? "selected" : "" }}>Sea Freight</option>
                                            <option value="3" {{ old('transportation') == 3 ? "selected" : "" }}>Land Trucking</option>
                                        </select>
                                        <div id="radio_buttons"></div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-label">Carrier / Pengangkut</label>
                                        <input type="text" class="form-control" name="carrier" id="carrier" value="{{ old('carrier') }}" placeholder="fill the text..">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-label">Keterangan Progress Selanjutnya</label>
                                        <input type="text" class="form-control" name="description" id="description" value="{{ old('description') }}" placeholder="fill the text..">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-label">Document</label>
                                        <input type="file" class="form-control" name="documents[]" accept=".pdf" multiple>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-3" style="text-align: center">
                            <a class="btn btn-white color-grey" data-bs-dismiss="modal">Close</a>
                            <button type="submit" class="btn btn-primary">Save</button>
                            <button type="submit" class="btn btn-dark">Save & Notification</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-edit-progress" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title">Edit Progress</h5>
                <button class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="progress_edit"></div>
            </div>
        </div>
    </div>
</div>


@endsection

@push('scripts')
    <!-- SELECT2 JS -->
    <script src="{{ url('assets/plugins/select2/select2.full.min.js') }}"></script>
    <script src="{{ url('assets/js/select2.js') }}"></script>

    <!-- MULTI SELECT JS-->
    <script src="{{ url('assets/plugins/multipleselect/multiple-select.js') }}"></script>
    <script src="{{ url('assets/plugins/multipleselect/multi-select.js') }}"></script>

    <script>
        $(document).ready(function() {
             //show edit data
             $('body').on('click', '#btn-progress', function() {
                let id = $(this).data('id');
   
                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    type: 'GET',
                    dataType: 'json',
                    data: {'id':id},
                    url: '{{ route('operation.import.create-progress') }}',
                    success: function(response) {

                        $("#progress_before").html("");

                        $.each(response.data, function (key, item) {

                        var idProgress = item.id;
                        var itemTransportation = item.transportation;
                        var itemTransportationDesc = item.transportation_desc;

                        let content = `<div class="row">
                                <div class="col-md-4">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label class="form-label">Tanggal</label>
                                                <input type="date" class="form-control" value="${item.date_progress}" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="form-label">Jam</label>
                                                <input type="time" class="form-control" value="${item.time_progress}" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="form-label">Lokasi Progress ${key+2} </label>
                                                <input type="text" class="form-control mb-2" name="location" id="location" value="${item.location}" placeholder="Nama tempat" disabled>
                                                <input type="text" class="form-control mb-2" value="${item.location_desc}" disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="form-label">Transportasi</label>
                                                <select class="form-control select2 form-select" data-placeholder="Choose one" disabled>
                                                    <option value="1" ${itemTransportation == 1 ? 'selected' : ''}>Air Freight</option>
                                                    <option value="2" ${itemTransportation == 2 ? 'selected' : ''}>Sea Freight</option>
                                                    <option value="3" ${itemTransportation == 3 ? 'selected' : ''}>Land Trucking</option>
                                                </select>
                              
                                                <label class="custom-control custom-radio">
                                                    <input type="radio" class="custom-control-input"
                                                        value="${item.transportation_desc}" checked>
                                                    <span class="custom-control-label">${item.transportation_desc}</span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="form-label">Carrier / Pengangkut</label>
                                                <input type="text" class="form-control" value="${item.carrier}" disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>
            
                                <div class="col-md-4">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="form-label">Keterangan Progress ${key+2} </label>
                                                <input type="text" class="form-control" value="${item.description}" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="form-label">Document</label>
                                                <input type="file" class="form-control" name="documents[]" accept=".pdf" multiple disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <div class="g-2">
                                            <form action="{{ route('operation.import.delete-progress', ':id_progress') }}" method="POST" class="d-inline" onclick="return confirm('Are you sure wantsss to delete this item');">
                                                @csrf
                                                @method('delete')
                                                <button class="btn text-danger">
                                                    <i class="fe fe-trash-2 fs-14"></i>
                                                </button>
                                            </form> 
                                            <a href="javascript:void(0)" class="modal-effect btn text-warning btn-sm"
                                                data-bs-toggle="tooltip" data-bs-effect="effect-scale" data-id="${item.id}"
                                                data-bs-original-title="Edit Progress" id="btn-edit-progress"><span
                                                    class="fe fe-edit fs-14"></span></a>
                                            <a href="javascript:void(0)" class="badge bg-dark">Send Notification</a>
                                        </div>
                                    </div>
                                </div>
                                <hr>
            
                            </div>`;

                        // Ganti placeholder ':id_progress' dengan nilai yang sebenarnya
                        content = content.replace(':id_progress', idProgress);
                        $('#progress_before').append(content);
                        });


                        $('#operation_import_id').val(id);

                        $('#modal-progress').modal('show');
                    }
                });
            });

            $('body').on('click', '#btn-edit-progress', function() {
                let id = $(this).data('id');
                console.log(id);

                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    type: 'GET',
                    dataType: 'json',
                    data: {'id':id},
                    url: '{{ route('operation.import.edit-progress') }}',
                    success: function(response) {
                        console.log(response);

                        $("#progress_edit").html("");

                        var idProgress = response.data.id;
                        var itemTransportation = response.data.transportation;
                        var itemTransportationDesc = response.data.transportation_desc;


                        // Panggil fungsi saat select box berubah
                        $('select[name="transportation_edit"]').change(function () {
                            console.log(this.value);
                            var transportation_desc_before =  document.getElementById("transportation_desc_before");
                            transportation_desc_before.style['display'] = 'none';
                            if (this.value == '1') {
                                $("#radio_buttons").html("");
                                var radioBtn = $(`<label class="custom-control custom-radio">
                                                        <input type="radio" class="custom-control-input"
                                                            name="transportation_desc" value="Hand Carry" ${itemTransportationDesc == "Hand Carry" ? 'checked' : ''}>
                                                        <span class="custom-control-label">Hand Carry</span>
                                                    </label>
                                                    <label class="custom-control custom-radio">
                                                        <input type="radio" class="custom-control-input"
                                                            name="transportation_desc" value="Express" ${itemTransportationDesc == "Express" ? 'checked' : ''}>
                                                        <span class="custom-control-label">Express</span>
                                                    </label>
                                                    <label class="custom-control custom-radio">
                                                        <input type="radio" class="custom-control-input"
                                                            name="transportation_desc" value="Regular" ${itemTransportationDesc == "Regular" ? 'checked' : ''}>
                                                        <span class="custom-control-label">Regular</span>
                                                    </label>`);
                                radioBtn.appendTo('#radio_buttons');
                            }
                            else if (this.value == '2') {
                                $("#radio_buttons").html("");
                                var radioBtn = $(`<label class="custom-control custom-radio">
                                                        <input type="radio" class="custom-control-input"
                                                            name="transportation_desc" value="FCL" ${itemTransportationDesc == "FCL" ? 'checked' : ''}>
                                                        <span class="custom-control-label">FCL</span>
                                                    </label>
                                                    <label class="custom-control custom-radio">
                                                        <input type="radio" class="custom-control-input"
                                                            name="transportation_desc" value="LCL" ${itemTransportationDesc == "LCL" ? 'checked' : ''}>
                                                        <span class="custom-control-label">LCL</span>
                                                    </label>`);
                                radioBtn.appendTo('#radio_buttons');
                            }
                            else if (this.value == '3') {
                                $("#radio_buttons").html("");
                            }
                        });


                        let content = `
                        <form action="{{ route('operation.import.update-progress') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                        <input type="hidden" name="id" value="${response.data.id}">
                        
                        <div class="row">
                                <div class="col-md-5">
                                    <div class="row">
                                        <div class="col-md-7">
                                            <div class="form-group">
                                                <label class="form-label">Tanggal</label>
                                                <input type="date" class="form-control" name="date_progress" value="${response.data.date_progress}">
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <label class="form-label">Jam</label>
                                                <input type="time" class="form-control" name="time_progress" value="${response.data.time_progress}">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="form-label">Lokasi Progress</label>
                                                <input type="text" class="form-control mb-2" name="location" id="location" value="${response.data.location}" placeholder="Nama tempat">
                                                <input type="text" class="form-control mb-2" name="location_desc" value="${response.data.location_desc}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="form-label">Transportasi</label>
                                                <select class="form-control select2 form-select" data-placeholder="Choose one" name="transportation_edit">
                                                    <option value="1" ${itemTransportation == 1 ? 'selected' : ''}>Air Freight</option>
                                                    <option value="2" ${itemTransportation == 2 ? 'selected' : ''}>Sea Freight</option>
                                                    <option value="3" ${itemTransportation == 3 ? 'selected' : ''}>Land Trucking</option>
                                                </select>
                              
                                                <div id="transportation_desc_before" style="display: block">
                                    
                        `;

                        if (itemTransportation == 1) {
                            content += `<label class="custom-control custom-radio">
                                                            <input type="radio" class="custom-control-input"
                                                                name="transportation_desc" value="Hand Carry" ${itemTransportationDesc == "Hand Carry" ? 'checked' : ''}>
                                                            <span class="custom-control-label">Hand Carry</span>
                                                        </label>
                                                        <label class="custom-control custom-radio">
                                                            <input type="radio" class="custom-control-input"
                                                                name="transportation_desc" value="Express" ${itemTransportationDesc == "Express" ? 'checked' : ''}>
                                                            <span class="custom-control-label">Express</span>
                                                        </label>
                                                        <label class="custom-control custom-radio">
                                                            <input type="radio" class="custom-control-input"
                                                                name="transportation_desc" value="Regular" ${itemTransportationDesc == "Regular" ? 'checked' : ''}>
                                                            <span class="custom-control-label">Regular</span>
                                                        </label>`;
                        } else if (itemTransportation == 2){
                            content += `                         <label class="custom-control custom-radio">
                                                            <input type="radio" class="custom-control-input"
                                                                name="transportation_desc" value="FCL" ${itemTransportationDesc == "FCL" ? 'checked' : ''}>
                                                            <span class="custom-control-label">FCL</span>
                                                        </label>
                                                        <label class="custom-control custom-radio">
                                                            <input type="radio" class="custom-control-input"
                                                                name="transportation_desc" value="LCL" ${itemTransportationDesc == "LCL" ? 'checked' : ''}>
                                                            <span class="custom-control-label">LCL</span>
                                                        </label>`;
                        }

                        content += `</div>
                                                <div class="custom-controls-stacked">
                                                    <div id="radio_buttons"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="form-label">Carrier / Pengangkut</label>
                                                <input type="text" class="form-control" name="carrier" value="${response.data.carrier}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
            
                                <div class="col-md-4">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="form-label">Keterangan Progress</label>
                                                <input type="text" class="form-control" name="description" value="${response.data.description}">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="form-label">Document</label>
                                                <input type="file" class="form-control" name="documents[]" accept=".pdf" multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <hr>
            
                        </div>
                        <div class="mt-3" style="text-align: right">
                            <a class="btn btn-white color-grey" data-bs-dismiss="modal">Close</a>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                        </form>`


                        $('#progress_edit').append(content);
              


                        $('#modal-edit-progress').modal('show');
                    }
                });



            });

            //display form create progress when click button add progress
            $('#addProgress').on('click', function () {
                var addProgress =  document.getElementById("addProgress");
                var formCreateProgress =  document.getElementById("formCreateProgress");
    
                addProgress.style['display'] = 'none';
                formCreateProgress.style['display'] = 'block';

            });

            //redio button transportation
            $('select[name="transportation"]').change(function () {
                if (this.value == '1') {
                    $("#radio_buttons").html("");
                    var radioBtn = $(`<label class="custom-control custom-radio">
                                            <input type="radio" class="custom-control-input"
                                                name="transportation_desc" value="Hand Carry" {{ old('transportation_desc') == "Hand Carry" ? "checked" : "" }}>
                                            <span class="custom-control-label">Hand Carry</span>
                                        </label>
                                        <label class="custom-control custom-radio">
                                            <input type="radio" class="custom-control-input"
                                                name="transportation_desc" value="Express" {{ old('transportation_desc') == "Express" ? "checked" : "" }}>
                                            <span class="custom-control-label">Express</span>
                                        </label>
                                        <label class="custom-control custom-radio">
                                            <input type="radio" class="custom-control-input"
                                                name="transportation_desc" value="Regular" {{ old('transportation_desc') == "Regular" ? "checked" : "" }}>
                                            <span class="custom-control-label">Regular</span>
                                        </label>`);
                    radioBtn.appendTo('#radio_buttons');
                }
                else if (this.value == '2') {
                    $("#radio_buttons").html("");
                    var radioBtn = $(`<label class="custom-control custom-radio">
                                            <input type="radio" class="custom-control-input"
                                                name="transportation_desc" value="FCL" {{ old('transportation_desc') == "FCL" ? "checked" : "" }}>
                                            <span class="custom-control-label">FCL</span>
                                        </label>
                                        <label class="custom-control custom-radio">
                                            <input type="radio" class="custom-control-input"
                                                name="transportation_desc" value="LCL" {{ old('transportation_desc') == "LCL" ? "checked" : "" }}>
                                            <span class="custom-control-label">LCL</span>`);
                    radioBtn.appendTo('#radio_buttons');
                }
                else if (this.value == '3') {
                    $("#radio_buttons").html("");
                }
            });


        })

    </script>    

@endpush
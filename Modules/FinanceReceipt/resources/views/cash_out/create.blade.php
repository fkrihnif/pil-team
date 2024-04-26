@extends('layouts.app')
@section('content')

<div class="main-content app-content mt-0">
    <div class="side-app">

        <!-- CONTAINER -->
        <div class="main-container container-fluid">
        <form action="" method="POST" enctype="multipart/form-data">
            @csrf
            <!-- PAGE-HEADER -->
            <div class="page-header mb-0">
                <h4>Payment</h4>
            </div>
            <h1 style="color: #015377"><b>Add New</b></h1>
            <!-- PAGE-HEADER END -->

            <div class="row">
                <div class="col-md-12">
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
                            <div class="row">
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <div class="d-flex justify-content-center">
                                            <span class="avatar avatar-xxl me-2 rounded-circle">
                                                <img src="{{ url('assets/images/brand/logo-1.png') }}" alt="">
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Penerima</label>
                                        <div class="d-flex d-inline">
                                            <select class="form-control select2 form-select"
                                                data-placeholder="Choose one" name="contact_id" id="contact_id" required>
                                                <option label="Choose one" selected disabled></option>
                                                @foreach ($contacts as $c)
                                                    @if (in_array(1, json_decode($c->type)))
                                                    <option value="{{ $c->id }}">{{ $c->customer_name }}</option>   
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                        <a data-bs-effect="effect-scale" data-bs-toggle="modal" href="#modal-create"><i class="fe fe-plus me-1"></i>Create New Penerima</a>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Dari Akun</label>
                                        <div class="d-flex d-inline">
                                            <select class="form-control select2 form-select"
                                                data-placeholder="Choose one" name="account_id" id="account_id" required>
                                                <option label="Choose one" selected disabled></option>
                                                @foreach ($accounts as $a)
                                                    <option value="{{ $a->id }}">{{ $a->account_name }}</option>   
                                                @endforeach
                                            </select>
                                        </div>
                                        <a data-bs-effect="effect-scale" data-bs-toggle="modal" href="#modal-create"><i class="fe fe-plus me-1"></i>Create New Account</a>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="" class="form-label">Mata Uang</label>
                                        <select class="form-control select2 form-select"
                                            data-placeholder="Choose one" name="customer_id" id="customer_id" required>
                                            <option label="Choose one" selected disabled></option>
                                            @foreach ($currencies as $c)
                                                <option value="{{ $c->id }}">{{ $c->initial }}</option>   
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="" class="form-label">Date</label>
                                        <input type="date" class="form-control" name="no_cipl" id="no_cipl" value="{{ old('no_cipl') }}" placeholder="100001"  >
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="" class="form-label">Nomor Transaksi <a data-bs-effect="effect-scale" data-bs-toggle="modal" href="#modal-transaction-format"><i class="fa fa-cog"></i></a></label>
                                        <select class="form-control select2 form-select"
                                            data-placeholder="Choose one" name="customer_id" id="customer_id" required>
                                            <option label="Choose one" selected disabled></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="" class="form-label">Description</label>
                                        <input type="text" class="form-control" name="no_cipl" id="no_cipl" value="{{ old('no_cipl') }}" placeholder="Sales Order - No Transaksi"  >
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="custom-control custom-radio">
                                        <input type="checkbox" class="custom-control-input" id="choose_job_order" name="choose_job_order"
                                            value="1">
                                        <span class="custom-control-label"><b>Choose Job Order</b></span>
                                    </label>
                                </div>
                            </div>
                            <div style="display: none" id="job_order_display">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="" class="form-label">Job Order</label>
                                            <select class="form-control select2 form-select"
                                                data-placeholder="Choose one" name="job_order_id" id="job_order_id" required>
                                                <option label="Choose one" selected disabled></option>
                                                @foreach ($job_orders as $j)
                                                <option data-type="{{ $j->type }}" data-consignee="{{ $j->consignee }}" data-shipper="{{ $j->shipper }}" data-transportation="{{ $j->transportation }}" data-transportation_desc="{{ $j->transportation_desc }}" value="{{ $j->id }}">{{ "(".$j->job_order_id.") - ".$j->type }}</option>   
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="" class="form-label">Consignee</label>
                                            <input type="text" class="form-control" name="no_cipl" id="no_cipl" value="{{ old('no_cipl') }}" placeholder=""  disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="" class="form-label">Shipper</label>
                                            <input type="text" class="form-control" name="no_cipl" id="no_cipl" value="{{ old('no_cipl') }}" placeholder=""  disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="" class="form-label">Transportation</label>
                                            <select class="form-control select2 form-select" disabled
                                                data-placeholder="Auto Select" name="transportation">
                                                <option label="Choose one" selected disabled></option>
                                                <option value="1">Air Freight</option>
                                                <option value="2">Sea Freight</option>
                                                <option value="3">Land Trucking</option>
                                            </select>
                                        </div>
                                        <label class="custom-control custom-radio">
                                            <input type="radio" class="custom-control-input"
                                                name="transportation_desc" value="Express" checked>
                                            <span class="custom-control-label">Hand Carry</span>
                                        </label>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="" class="form-label">Commodity</label>
                                            <input type="text" class="form-control" name="no_cipl" id="no_cipl" value="{{ old('no_cipl') }}" placeholder="" disabled>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table border">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Description</th>
                                            <th>Akun</th>
                                            <th>Total</th>
                                            <th>#</th>
                                        </tr>
                                    </thead>
                                    <tbody id="table-body">
                                        <!-- Group forms will be added dynamically here -->
                                        <tr class="group-form theDimensions1" >
                                            <input type="hidden" name="seq_detail[]" id="dimension[1][seq_detail]" data-row="1" value="1" >
                                            <td width="5%"></td>
                                            <td width="40%">
                                                <input type="text" class="form-control description-input" name="description_detail[]"  id="dimension[1][description_detail]" data-row="1" placeholder="Desc" />
                                                <label for="" class="form-label">Remark</label>
                                                <input type="text" class="form-control remark-input mt-2" name="remark_detail[]" id="dimension[1][remark_detail]" data-row="1"  placeholder="Text.." />
                                                
                                            </td>
                                            <td width="20%"> 
                                                <select class="form-control select2 form-select"
                                                    data-placeholder="Choose one" name="account_detail[]" id="dimension[1][account_detail]" data-row="1"  required>
                                                    <option label="Choose one" selected disabled></option>
                                                    @foreach ($accounts as $a)
                                                        <option value="{{ $a->id }}">{{ $a->account_name }}</option>   
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td width="25%">
                                                <input type="text" class="form-control remark-input" name="total_detail[]" id="dimension[1][total_detail]" data-row="1"  />
                                            </td>
                                            <td width="10%" style="text-align: center;">
                                                <a href="javascript:void(0)" class="btn text-danger remove-dimension"><span class="fe fe-trash-2 fs-14"></span></a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="row">
                                <a href="javascript:void(0)" class="btn btn-default"
                                    id="addDimension">
                                    <span><i class="fa fa-plus"></i></span> Add New Column
                                </a>
                            </div>
                            <div class="row justify-content-end">
                                <div class="col-lg-6">
                                    <table width="50%" class="table mt-5">
                                        <tr>
                                            <td>
                                                <div class="d-flex justify-content-between">
                                                    Biaya Lain
                                                    <input type="text" style="width: 50%" class="form-control remark-input" name="remark_${groupChar}[]" placeholder="0" />
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="d-flex justify-content-between">
                                                    Diskon (-)
                                                    <div style="width: 10%">
                                                        <select class="form-control select2 form-select" style="width: 5%" name="" id="">
                                                            <option value="persen">%</option>
                                                            <option value="nominal">0</option>
                                                        </select>
                                                    </div>
                                                    <input type="text" style="width: 10%" class="form-control remark-input" name="remark_${groupChar}[]" placeholder="0" />
                                                    <input type="text" style="width: 50%" class="form-control remark-input" name="remark_${groupChar}[]" placeholder="Rp 0,00" />
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="d-flex justify-content-between">
                                                    Total
                                                    <input type="text" style="width: 50%" class="form-control remark-input" name="remark_${groupChar}[]" placeholder="Rp 0,00" />
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <div class="btn-list text-end">
                                            <a href="javascript: history.go(-1)" class="btn btn-default">Cancel</a>
                                            <button type="submit" class="btn btn-primary">Save</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        </div>
        <!-- CONTAINER CLOSED -->
    </div>
</div>

{{-- modal transaction format --}}
<div class="modal fade" id="modal-transaction-format" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Pengaturan Nomor Transaksi</h5>
                <button class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-primary">
                            <div class="tab-menu-heading tab-menu-heading-boxed">
                                <div class="tabs-menu tabs-menu-border">
                                    <!-- Tabs -->
                                    <ul class="nav panel-tabs">
                                        <li><a href="#tab29" class="active" data-bs-toggle="tab">Custom Format</a></li>
                                        <li><a href="#tab30" data-bs-toggle="tab">Tambah Baru</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="panel-body tabs-menu-body mt-3">
                                <div class="tab-content">
                                    <div class="tab-pane active" id="tab29">
                                        <div class="d-flex d-inline">
                                            <select class="form-control select2 form-select"
                                                data-placeholder="INV/019//2021/XY/01" name="customer_id" id="customer_id" required>
                                                <option label="Choose one" selected disabled></option>
                                            </select>
                                            <a href="#" class="btn text-danger btn-sm"
                                            data-bs-toggle="tooltip"
                                            data-bs-original-title="Delete" onclick="if (confirm('Are you sure want to delete this item?')) {
                                                        event.preventDefault();
                                                        document.getElementById('').submit();
                                                    }else{
                                                        event.preventDefault();
                                                    }">
                                                <span class="fe fe-trash-2 fs-14"></span>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="tab30">
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <input type="text" class="form-control remark-input" name="remark_${groupChar}[]" placeholder="Example: INV/"  />
                                                </div>
                                                <div class="col-lg-4">
                                                    <input type="text" class="form-control remark-input" name="remark_${groupChar}[]" disabled placeholder="tahun" />
                                                </div>
                                                <div class="col-lg-4">
                                                    <input type="text" class="form-control remark-input" name="remark_${groupChar}[]" placeholder="Example: /XV" />
                                                </div>
                                            </div>
                                        <div class="form-group">
                                            <label for="" class="form-label">Mulai Dari Nomor</label>
                                            <input type="text" class="form-control" name="no_cipl" id="no_cipl" value="{{ old('no_cipl') }}" placeholder=""  >
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br><br><br><br><br>
                        <div class="mt-3" style="text-align: right">
                            <a class="btn btn-white color-grey" data-bs-dismiss="modal">Close</a>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- modal input contact --}}
<div class="modal fade" id="modal-create" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">+ Add Contact</h5>
                <button class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-primary">
                            <div class=" tab-menu-heading">
                                <div class="tabs-menu1">
                                    <!-- Tabs -->
                                    <ul class="nav panel-tabs">
                                        <li><a href="#tab1" class="active" data-bs-toggle="tab">Customer</a></li>
                                        <li><a href="#tab2" data-bs-toggle="tab">Company</a></li>
                                        <li><a href="#tab3" data-bs-toggle="tab">Address</a></li>
                                        <li><a href="#tab4" data-bs-toggle="tab">Others</a></li>
                                    </ul>
                                </div>
                            </div>
                            <form action="{{ route('finance.master-data.contact.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="panel-body tabs-menu-body">
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="tab1">
                                            <h4><u>Customer</u></h4>
                                            <div class="form-group">
                                                <label>Customer ID</label>
                                                <input type="text" name="customer_id" id="customer_id" value="{{ old('customer_id') }}" class="form-control" disabled>
                                            </div>
                                            <div class="form-group">
                                                <label>Customer Name</label>
                                                <input type="text" name="customer_name" id="customer_name" value="{{ old('customer_name') }}"class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label>Title</label>
                                                <input type="text" name="title" value="{{ old('title') }}" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label>Mobile Phone Number</label>
                                                <input type="text" name="phone_number" value="{{ old('phone_humber') }}" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label>Email</label>
                                                <input type="text" name="email" value="{{ old('email') }}" class="form-control">
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-6">
                                                    <label>NPWP/KTP</label>
                                                    <input type="text" name="npwp_ktp" value="{{ old('npwp_ktp') }}" class="form-control">
                                                </div>
                                                <div class="form-group col-6">
                                                    <label>Upload Document</label>
                                                    <input type="file" name="document" class="form-control">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label>Category</label>
                                                    <div class="custom-controls-stacked d-flex d-inline">
                                                        <label class="custom-control custom-checkbox">
                                                                <input type="checkbox" class="custom-control-input" id="contact_type1" name="contact_type[]" value="1" @if(is_array(old('contact_type')) && in_array(1,old('contact_type'))) checked @endif>
                                                                <span class="custom-control-label">Customer</span>
                                                            </label>
                                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        <label class="custom-control custom-checkbox">
                                                                <input type="checkbox" class="custom-control-input" id="contact_type2" name="contact_type[]" value="2" @if(is_array(old('contact_type')) && in_array(2,old('contact_type'))) checked @endif>
                                                                <span class="custom-control-label">Vendor</span>
                                                            </label>
                                                            &nbsp;&nbsp;&nbsp;&nbsp;    
                                                        <label class="custom-control custom-checkbox">
                                                                <input type="checkbox" class="custom-control-input" id="contact_type3" name="contact_type[]" value="3" @if(is_array(old('contact_type')) && in_array(3,old('contact_type'))) checked @endif>
                                                                <span class="custom-control-label">Karyawan</span>
                                                            </label>
                                                            &nbsp;&nbsp;&nbsp;&nbsp;
                                                        <label class="custom-control custom-checkbox">
                                                                <input type="checkbox" class="custom-control-input" id="contact_type4" name="contact_type[]" value="4" @if(is_array(old('contact_type')) && in_array(4,old('contact_type'))) checked @endif>
                                                                <span class="custom-control-label">Supplier</span>
                                                            </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row input_fields_wrap_new mt-2">
                                                <div class="col-10">
                                                    <div class="form-group" style="margin-bottom: 0px; margin-top: 0px">
                                                        <label>Term Of Payment</label>
                                                        <select class="form-control select2 form-select"
                                                            data-placeholder="Choose one" name="term_payment_id[]">
                                                            {{-- @foreach ($terms as $term)
                                                                <option {{ old('term_payment_id[]') == $term->id ? "selected" : "" }} value="{{ $term->id }}">{{ $term->name }}</option>
                                                            @endforeach --}}
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mt-2">
                                                <div class="col-3">
                                                    <button type="button" id="tambahKolomNew" class="btn btn-primary btn-sm add_field_button_new"><i class="fe fe-plus me-2"></i>Add New Term</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="tab2">
                                            <h4><u>Company</u></h4>
                                            <div class="form-group">
                                                <label>Company Name</label>
                                                <input type="text" name="company_name" value="{{ old('company_name') }}" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label>Type Of Company</label>
                                                <div class="d-flex d-inline">
                                                    <label class="custom-control custom-radio">
                                                        <input type="radio" class="custom-control-input"
                                                        name="type_of_company" value="1"  @if(is_array(old('type_of_company')) && in_array(1,old('type_of_company'))) checked @endif>
                                                        <span class="custom-control-label">PT / Ltd</span>
                                                    </label>
                                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                                    <label class="custom-control custom-radio">
                                                        <input type="radio" class="custom-control-input"
                                                        name="type_of_company" value="2" @if(is_array(old('type_of_company')) && in_array(2,old('type_of_company'))) checked @endif>
                                                        <span class="custom-control-label">CV</span>
                                                    </label>
                                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                                    <label class="custom-control custom-radio">
                                                        <input type="radio" class="custom-control-input"
                                                        name="type_of_company" value="3" @if(is_array(old('type_of_company')) && in_array(3,old('type_of_company'))) checked @endif>
                                                        <span class="custom-control-label">UD</span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Company Tax Status</label>
                                                <div class="d-flex d-inline">
                                                    <label class="custom-control custom-radio">
                                                        <input type="radio" class="custom-control-input"
                                                        name="company_tax_status" value="1"  @if(is_array(old('company_tax_status')) && in_array(1,old('company_tax_status'))) checked @endif>
                                                        <span class="custom-control-label">Taxable</span>
                                                    </label>
                                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                                    <label class="custom-control custom-radio">
                                                        <input type="radio" class="custom-control-input"
                                                        name="company_tax_status" value="2" @if(is_array(old('company_tax_status')) && in_array(2,old('company_tax_status'))) checked @endif>
                                                        <span class="custom-control-label">Non Taxable</span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div id="input_vendor"></div>
                                        </div>
                                        <div class="tab-pane" id="tab3">
                                            <h4><u>Address</u></h4>
                                            <div class="form-group">
                                                <label>Address</label>
                                                <input type="text" name="address" value="{{ old('address') }}" class="form-control">
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    <label>City</label>
                                                    <input type="text" name="city" value="{{ old('city') }}" class="form-control">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label>Postal Code</label>
                                                    <input type="text" name="postal_code" value="{{ old('postal_code') }}" class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Country</label>
                                                <input type="text" name="country" value="{{ old('country') }}" class="form-control">
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="tab4">
                                            <h4><u>Others</u></h4>
                                            <div class="form-group">
                                                <label>PIC for Urgent Status</label>
                                                <input type="text" name="pic_for_urgent_status" value="{{ old('pic_for_urgent_status') }}" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label>Mobile Number</label>
                                                <input type="text" name="mobile_number" value="{{ old('mobile_number') }}" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-3" style="text-align: right">
                                        <a class="btn btn-white color-grey" data-bs-dismiss="modal">Close</a>
                                        <button type="submit" class="btn btn-primary">Save</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
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

        {{-- <!-- FILE UPLOADES JS -->
    <script src="{{ url('assets/plugins/fileuploads/js/fileupload.js') }}"></script>
    <script src="{{ url('assets/plugins/fileuploads/js/file-upload.js') }}"></script>

    <!-- INTERNAL File-Uploads Js-->
    <script src="{{ url('assets/plugins/fancyuploder/jquery.ui.widget.js') }}"></script>
    <script src="{{ url('assets/plugins/fancyuploder/jquery.fileupload.js') }}"></script>
    <script src="{{ url('assets/plugins/fancyuploder/jquery.iframe-transport.js') }}"></script>
    <script src="{{ url('assets/plugins/fancyuploder/jquery.fancy-fileupload.js') }}"></script>
    <script src="{{ url('assets/plugins/fancyuploder/fancy-uploader.js') }}"></script> --}}

    <script>
        $(document).ready(function () {
            $("input:checkbox[name^='choose_job_order']").on('change', function () {
                var job_order_display =  document.getElementById("job_order_display");
                if ($('#choose_job_order').prop('checked')) {
                    console.log('pencet ini');
                    job_order_display.style['display'] = 'block';
                } else {
                    job_order_display.style['display'] = 'none';
                }
            });




            $('select[name="transportation"]').change(function () {
                if (this.value == '1') {
                    $("#radio_buttons").html("");
                    var radioBtn = $(`<label class="custom-control custom-radio">
                                            <input type="radio" class="custom-control-input"
                                                name="transportation_desc" value="Hand Carry">
                                            <span class="custom-control-label">Hand Carry</span>
                                        </label>
                                        <label class="custom-control custom-radio">
                                            <input type="radio" class="custom-control-input"
                                                name="transportation_desc" value="Express">
                                            <span class="custom-control-label">Express</span>
                                        </label>
                                        <label class="custom-control custom-radio">
                                            <input type="radio" class="custom-control-input"
                                                name="transportation_desc" value="Regular">
                                            <span class="custom-control-label">Regular</span>
                                        </label>`);
                    radioBtn.appendTo('#radio_buttons');
                }
                else if (this.value == '2') {
                    $("#radio_buttons").html("");
                    var radioBtn = $(`<label class="custom-control custom-radio">
                                            <input type="radio" class="custom-control-input"
                                                name="transportation_desc" value="FCL">
                                            <span class="custom-control-label">FCL</span>
                                        </label>
                                        <label class="custom-control custom-radio">
                                            <input type="radio" class="custom-control-input"
                                                name="transportation_desc" value="LCL">
                                            <span class="custom-control-label">LCL</span>`);
                    radioBtn.appendTo('#radio_buttons');
                }
                else if (this.value == '3') {
                    $("#radio_buttons").html("");
                }
            });


            // show beneficiary - siwft code if select checkbox vendor value
            $("input:checkbox[name^='contact_type']").on('change', function () {
                if ($('#contact_type2').prop('checked')) {
                    $("#input_vendor").html("");
                    var radioBtn = $(`<div class="form-group">
                                            <label>Beneficiary Bank/Branch</label>
                                            <input type="text" name="bank_branch" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label>Beneficiary Acc Name</label>
                                            <input type="text" name="acc_name" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label>Beneficiary Acc No</label>
                                            <input type="text" name="acc_no" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label>Swift Code</label>
                                            <input type="text" name="swift_code" class="form-control">
                                        </div>`);
                    radioBtn.appendTo('#input_vendor');
                } else {
                    $("#input_vendor").html("");
                }
            });

            //multiple input dropdown Term of Payment
            var max_fields_new      = 50; //maximum input boxes allowed
            var wrapper_new         = $(".input_fields_wrap_new"); //Fields wrapper
            var add_button_new      = $(".add_field_button_new"); //Add button ID

            var x = 1; //initlal text box count
            $(add_button_new).click(function(e){ //on add input button click
                e.preventDefault();
                if(x < max_fields_new){ //max input box allowed
                    x++; //text box increment
                    $(wrapper_new).append(`
                        <div class="row input_fields_wrap_new">
                            <div class="col-10">
                                <div class="form-group" style="margin-bottom: 0px; margin-top: 0px">
                                    <label>Term Of Payment</label>
                                    <select class="form-control select2 form-select"
                                        data-placeholder="Choose one" name="term_payment_id[]">
                                        
                                    </select>
                                </div>
                            </div>
                            <div class="col-2">
                                <button type="button" class="btn text-danger btn-sm remove_field_new" style="margin-top: 30px;"><span class="fe fe-trash-2 fs-14"></span></button>
                            </div>
                        </div>`); //add input box
                }
            });

            $(wrapper_new).on("click",".remove_field_new", function(e){ //user click on remove text
                e.preventDefault(); 
                $(this).parent().parent().remove(); x--;
            })
            
            let seq = 1;
            $('#addDimension').on('click', function () {

                var currentDimension = $('tbody tr[class*="theDimensions"]').length;

                increaseNumDimensions = currentDimension + 1;

                if (increaseNumDimensions == 1) {
                    seq = 1;
                    var dimensions = `
                        <div class="table-responsive">
                            <table class="table border" id="dimensionTable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Description</th>
                                        <th>Akun</th>
                                        <th>Total</th>
                                        <th>#</th>
                                    </tr>
                                </thead>
                                <tbody id="table-body">
                                    <tr class="group-form theDimensions`+ increaseNumDimensions + `">
                                        <input type="hidden" name="seq_detail[]" id="dimension[`+ increaseNumDimensions + `][seq_detail]" data-row="` + increaseNumDimensions + `" value="` + seq + `">
                                        <td width="5%"></td>
                                        <td width="40%">
                                            <input type="text" class="form-control description-input" name="description_detail[]" id="dimension[`+ increaseNumDimensions + `][description_detail]" data-row="` + increaseNumDimensions + `" placeholder="Desc..">
                                            <label for="" class="form-label">Remark</label>
                                            <input type="text" class="form-control description-input" name="remark_detail[]" id="dimension[`+ increaseNumDimensions + `][remark_detail]" data-row="` + increaseNumDimensions + `" placeholder="Text..">
            
                                        </td>
                                        <td width="20%">
                                            <select class="form-control select2 form-select"
                                                data-placeholder="Choose one" name="account_detail[]" id="dimension[`+ increaseNumDimensions + `][account_detail]" data-row="` + increaseNumDimensions + `" required>
                                                <option label="Choose one" selected disabled></option>
                                                @foreach ($accounts as $a)
                                                    <option value="{{ $a->id }}">{{ $a->account_name }}</option>   
                                                @endforeach
                                            </select>
                                        </td>
                                        <td width="25%">
                                            <input type="text" class="form-control remark-input" name="total_detail[]" id="dimension[`+ increaseNumDimensions + `][total_detail]" data-row="` + increaseNumDimensions + `" />
                                        </td>
                                        <td width="10%" style="text-align: center;">
                                            <a href="javascript:void(0)" class="btn text-danger remove-dimension"><span class="fe fe-trash-2 fs-14"></span></a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>`;

                    $('#addDimension').before(dimensions);
                }

                if (increaseNumDimensions > 1) {
                    seq++;
                    var newDimension = `
                        
                        <tr class="group-form theDimensions`+ increaseNumDimensions + `">
                            <input type="hidden" name="seq_detail[]" id="dimension[`+ increaseNumDimensions + `][seq_detail]" data-row="` + increaseNumDimensions + `" value="` + seq + `">
                            <td width="5%"></td>
                            <td width="40%">
                                <input type="text" class="form-control description-input" name="description_detail[]" id="dimension[`+ increaseNumDimensions + `][description_detail]" data-row="` + increaseNumDimensions + `" placeholder="Desc..">
                                <label for="" class="form-label">Remark</label>
                                <input type="text" class="form-control description-input" name="remark_detail[]" id="dimension[`+ increaseNumDimensions + `][remark_detail]" data-row="` + increaseNumDimensions + `" placeholder="Text..">
  
                            </td>
                            <td width="20%">
                                <select class="form-control select2 form-select"
                                    data-placeholder="Choose one" name="account_detail[]" id="dimension[`+ increaseNumDimensions + `][account_detail]" data-row="` + increaseNumDimensions + `" required>
                                    <option label="Choose one" selected disabled></option>
                                    @foreach ($accounts as $a)
                                        <option value="{{ $a->id }}">{{ $a->account_name }}</option>   
                                    @endforeach
                                </select>
                            </td>
                            <td width="25%">
                                <input type="text" class="form-control remark-input" name="total_detail[]" id="dimension[`+ increaseNumDimensions + `][total_detail]" data-row="` + increaseNumDimensions + `" />
                            </td>
                            <td width="10%" style="text-align: center;">
                                <a href="javascript:void(0)" class="btn text-danger remove-dimension"><span class="fe fe-trash-2 fs-14"></span></a>
                            </td>
                        </tr>
                    `;
                    
                    $('.theDimensions' + currentDimension).after(newDimension);

                    $(".form-select").select2({
                        placeholder: "Select",
                        width: "100%",
                    });
                
                }
            });

            $(document).on('click', '.remove-dimension', function () {

                var deletedDimensionRow = $(this).closest('tr');

                deletedDimensionRow.remove();

                var remainingDimensionRows = $('tbody tr[class*="theDimensions"]');

                remainingDimensionRows.each(function (index) {

                    var numDimension = index + 1;

                    removeDimensionClass = $(this).removeClass();
                    addDimensionClass = $(this).addClass("form-control-sm theDimensions" + numDimension);

                    $(this).find('[id^="dimension["]').each(function () {

                        var oldName = $(this).attr('id');
                        var newName = oldName.replace(/\[\d+\]/, '[' + numDimension + ']');
                        $(this).attr('id', newName);
                    });
                });

                var getRemainingDimensionRowsAgain = $('tbody tr[class*="theDimensions"]');

                if (getRemainingDimensionRowsAgain.length == 0) {

                    var getDimensionLabel = $('h3[class$="dimension-label"]');

                    getDimensionLabel.remove();

                    var getTableResponsive = $('div[class="table-responsive"]');

                    getTableResponsive.remove();
                }

                if (getRemainingDimensionRowsAgain.length > 0) {

                    // calculateTotal();
                }
                // calculateGrandTotal();
                });
        
        });

    </script>

@endpush
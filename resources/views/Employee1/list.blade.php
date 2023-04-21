@extends('layouts.app')

@section('content')
<div class="app-main flex-column flex-row-fluid" id="kt_app_main">
    <!--begin::Content wrapper-->
    <div class="d-flex flex-column flex-column-fluid">
        <!--begin::Toolbar-->
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <!--begin::Toolbar container-->
            <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
                <!--begin::Page title-->
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <!--begin::Title-->
                    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Employee List</h1>
                    <!--end::Title-->
                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">
                            <a href="#" class="text-muted text-hover-primary">Home</a>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-400 w-5px h-2px"></span>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">Employee</li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-400 w-5px h-2px"></span>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">List</li>
                        <!--end::Item-->
                    </ul>
                    <!--end::Breadcrumb-->
                </div>
                <!--end::Page title-->

            </div>
        </div>
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <div id="kt_app_content_container" class="app-container container-xxl">
                <div class="card">
                    @if (session('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                    </div>
                    @endif
                    @if (session('error'))
                    <div class="alert alert-danger" role="alert">
                        {{ session('error') }}
                    </div>
                    @endif
                    <div class="card-header border-0 pt-6">

                        <div class="card-title">

                        </div>

                        <div class="card-toolbar">
                            <!--begin::Toolbar-->
                            <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                                <!--begin::Filter-->

                                <!--begin::Add user-->
                                <button type="button" class="btn switchPrimaryBtn " data-bs-toggle="modal" data-bs-target="#kt_modal_add_user">
                                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr075.svg-->
                                    <span class="svg-icon svg-icon-2">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1" transform="rotate(-90 11.364 20.364)" fill="currentColor" />
                                            <rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="currentColor" />
                                        </svg>
                                    </span>
                                    <!--end::Svg Icon-->Add</button>
                                <!--end::Add user-->
                            </div>
                            <!--end::Toolbar-->
                            <!--begin::Group actions-->
                            <div class="d-flex justify-content-end align-items-center d-none" data-kt-user-table-toolbar="selected">
                                <div class="fw-bold me-5">
                                    <span class="me-2" data-kt-user-table-select="selected_count"></span>Selected
                                </div>
                                <button type="button" class="btn btn-danger" data-kt-user-table-select="delete_selected">Delete Selected</button>
                            </div>
                            <!--end::Group actions-->

                            <!--begin::Modal - Add task-->
                            <div class="modal fade" id="kt_modal_add_user" tabindex="-1" aria-hidden="true">
                                <!--begin::Modal dialog-->
                                <div class="modal-dialog modal-dialog-centered mw-850px">
                                    <!--begin::Modal content-->
                                    <div class="modal-content">

                                        <!--begin::Modal header-->
                                        <div class="modal-header" id="kt_modal_add_user_header">
                                            <!--begin::Modal title-->
                                            <h2 class="fw-bold">Add</h2>
                                            <!--end::Modal title-->
                                            <!--begin::Close-->
                                            <div class="btn btn-icon btn-sm btn-active-icon-primary" data-kt-users-modal-action="close">
                                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                                                <span class="svg-icon svg-icon-1">
                                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor" />
                                                        <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor" />
                                                    </svg>
                                                </span>
                                                <!--end::Svg Icon-->
                                            </div>
                                            <!--end::Close-->
                                        </div>
                                        <!--end::Modal header-->
                                        <!--begin::Modal body-->
                                        <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">

                                            <form id="designation_form" class="form" method="post" enctype="multipart/form-data" action="{{url('employees')}}">
                                                @csrf
                                                <div class="fv-row mb-7">
                                                    <!--begin::Wrapper-->
                                                    <div class="d-flex flex-stack">
                                                        <!--begin::Label-->
                                                        <div class="me-5">
                                                            <!--begin::Label-->
                                                            <label class="fs-6 fw-semibold">Active</label>
                                                            <!--end::Label-->

                                                        </div>
                                                        <!--end::Label-->
                                                        <!--begin::Switch-->
                                                        <label class="form-check form-switch form-check-custom form-check-solid">
                                                            <!--begin::Input-->
                                                            <input class="form-check-input" name="is_active" type="checkbox" value="1" id="kt_modal_add_customer_billing" checked="checked" />
                                                            <!--end::Input-->
                                                            <!--begin::Label-->
                                                            <span class="form-check-label fw-semibold text-muted" for="kt_modal_add_customer_billing">Yes</span>
                                                            <!--end::Label-->
                                                        </label>
                                                        <!--end::Switch-->
                                                    </div>
                                                    <!--begin::Wrapper-->
                                                </div>
                                                <!--end::Input group-->

                                                <div class="row g-9 mb-7">
                                                    <!--begin::Col-->
                                                    <div class="col-md-6 fv-row">
                                                        <!--begin::Label-->
                                                        <label class="required fs-6 fw-semibold mb-2">First Name</label>
                                                        <!--end::Label-->
                                                        <!--begin::Input-->
                                                        <input type="text" class="form-control form-control-solid" placeholder="Enter First Name" name="first_name" />
                                                        <!--end::Input-->
                                                    </div>
                                                    <!--end::Col-->

                                                      <!--begin::Col-->
                                                      <div class="col-md-6 fv-row">
                                                        <!--begin::Label-->
                                                        <label class="required fs-6 fw-semibold mb-2">Last Name</label>
                                                        <!--end::Label-->
                                                        <!--begin::Input-->
                                                        <input type="text" class="form-control form-control-solid" placeholder="Enter Last Name" name="last_name" />
                                                        <!--end::Input-->
                                                    </div>
                                                    <!--end::Col-->

                                                      <!--begin::Col-->
                                                      <div class="col-md-6 fv-row">
                                                        <!--begin::Label-->
                                                        <label class="required fs-6 fw-semibold mb-2">Email</label>
                                                        <!--end::Label-->
                                                        <!--begin::Input-->
                                                        <input type="email" class="form-control form-control-solid" placeholder="Enter Email" name="email" />
                                                        <!--end::Input-->
                                                    </div>
                                                    <!--end::Col-->


                                                        <!--begin::Col-->
                                                        <div class="col-md-6 fv-row">
                                                            <!--begin::Label-->
                                                            <label class="required fs-6 fw-semibold mb-2">Mobile</label>
                                                            <!--end::Label-->
                                                            <!--begin::Input-->
                                                            <input type="number" class="form-control form-control-solid" placeholder="Enter Mobile" name="mobile" />
                                                            <!--end::Input-->
                                                        </div>
                                                        <!--end::Col-->


                                                         <!--begin::Col-->
                                                         <div class="col-md-6 fv-row">
                                                            <!--begin::Label-->
                                                            <label class="required fs-6 fw-semibold mb-2">Department</label>
                                                            <!--end::Label-->
                                                            <!--begin::Input-->
                                                            <select class="form-control form-control-solid" name="department_id">
                                                                <option value="">Select</option>
                                                                @foreach ($departments as $dept)
                                                                    <option value="<?php echo $dept['id'];?>"><?php echo $dept['name'];?></option>
                                                                @endforeach
                                                            </select>
                                                            <!--end::Input-->
                                                        </div>
                                                        <!--end::Col-->

                                                         <!--begin::Col-->
                                                         <div class="col-md-6 fv-row">
                                                            <!--begin::Label-->
                                                            <label class="required fs-6 fw-semibold mb-2">Designation</label>
                                                            <!--end::Label-->
                                                            <!--begin::Input-->
                                                            <select class="form-control form-control-solid" name="designation_id">
                                                                <option value="">Select</option>
                                                                @foreach ($designation as $des)
                                                                <option value="<?php echo $des['id'];?>"><?php echo $des['name'];?></option>
                                                            @endforeach
                                                            </select>
                                                            <!--end::Input-->
                                                        </div>
                                                        <!--end::Col-->

                                                         <!--begin::Col-->
                                                         <div class="col-md-6 fv-row">
                                                            <!--begin::Label-->
                                                            <label class="required fs-6 fw-semibold mb-2">SAP-id</label>
                                                            <!--end::Label-->
                                                            <!--begin::Input-->
                                                            <input type="text" class="form-control form-control-solid" placeholder="Enter SAP-id" name="sap_id" />
                                                            <!--end::Input-->
                                                        </div>
                                                        <!--end::Col-->

                                                           <!--begin::Col-->
                                                           <div class="col-md-6 fv-row">
                                                            <!--begin::Label-->
                                                            <label class="required fs-6 fw-semibold mb-2">Profie</label>
                                                            <!--end::Label-->
                                                            <!--begin::Input-->
                                                            <input type="file" class="form-control form-control-solid" name="profile_image" />
                                                            <!--end::Input-->
                                                        </div>
                                                        <!--end::Col-->

                                                            <!--begin::Col-->
                                                            <div class="col-md-6 fv-row">
                                                                <!--begin::Label-->
                                                                <label class="required fs-6 fw-semibold mb-2">Signature</label>
                                                                <!--end::Label-->
                                                                <!--begin::Input-->
                                                                <input type="file" class="form-control form-control-solid" name="sign_image" />
                                                                <!--end::Input-->
                                                            </div>
                                                            <!--end::Col-->


                                                    <!--begin::Col-->
                                                    <div class="col-md-12 fv-row">
                                                        <!--begin::Label-->
                                                        <label class="required fs-6 fw-semibold mb-2">Address</label>
                                                        <!--end::Label-->
                                                        <!--begin::Input-->
                                                        <textarea class="form-control form-control-solid" name="address" rows="4" cols="50"></textarea>

                                                        <!--end::Input-->
                                                    </div>
                                                    <!--end::Col-->
                                                </div>

                                                {{-- FORM --}}
                                                <div class="text-center pt-15">
                                                    <button type="reset" class="btn btn-light me-3" data-kt-users-modal-action="cancel">Reset</button>
                                                    <button type="submit" class="btn switchPrimaryBtn " data-kt-users-modal-action="submit">
                                                        <span class="indicator-label">Save and Exit</span>
                                                        <span class="indicator-progress">Please wait...
                                                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                                    </button>
                                                </div>

                                            </form>

                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!--end::Card header-->
                    <!--begin::Card body-->
                    <div class="card-body py-4">
                        <!--begin::Table-->
                        <table class="table align-middle table-row-dashed fs-6 gy-5" id="service_table">
                            <!--begin::Table head-->
                            <thead>
                                <!--begin::Table row-->
                                <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">

                                    <th class="min-w-125px">Name</th>
                                    <th class="min-w-125px">SAP-id</th>
                                    <th class="min-w-125px">Mobile</th>
                                    <th class="min-w-125px">Department</th>
                                    <th class="min-w-125px">Designation</th>
                                    <th class="min-w-125px">Status</th>
                                    <th class="text-end min-w-100px">Actions</th>
                                </tr>
                                <!--end::Table row-->
                            </thead>
                            <!--end::Table head-->
                            <!--begin::Table body-->
                            <tbody class="text-gray-600 fw-semibold">
                                <!--begin::Table row-->
                                @foreach($employee_all as $key=>$d)
                                <tr>
                                    <!--begin::Checkbox-->

                                    <!--end::Checkbox-->
                                    <!--begin::User=-->
                                   

                                    <td class="">
                                        <!--begin:: Avatar -->
                                        <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                            <a href="javascript:void(0);">
                                                <div class="symbol-label">
                                                    <img src="{{ asset('images/'.$d->profile_image) }}" alt="{{$d->first_name}}" width="50" height="50" class="w-100" />
                                                </div>
                                            </a>
                                        </div>
                                        <!--end::Avatar-->
                                        <!--begin::User details-->
                                        <div class="d-flex flex-column">
                                            <a href="javascript:void(0);" class="text-gray-800 text-hover-primary mb-1"><?php echo $d->first_name.' '.$d->last_name;?></a>
                                            <span>Email:{{$d->email}}</span>
                                        </div>
                                        <!--begin::User details-->
                                    </td>
                                    <td>{{$d->sap_id}}</td>
                                    <td>{{$d->mobile}}</td>
                                    <td>{{$d->department_name}}</td>
                                    <td>{{$d->designation_name}}</td>
                                    <td>@if ($d->employee_status==1)
                                          Active
                                        @else
                                          In-Active
                                        @endif
                                </td>
                                    <td class="text-end">
                                        <a href="#" class="btn btn-light btn-active-light-primary btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions

                                            <span class="svg-icon svg-icon-5 m-0">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="currentColor" />
                                                </svg>
                                            </span>
                                        </a>
                                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                                            <div class="menu-item px-3">
                                                <a href="#" class="menu-link px-3" data-bs-toggle="modal" data-bs-target="#kt_modal_add_customer<?php echo $d->id; ?>">Edit</a>
                                            </div>
                                            <div class="menu-item px-3">
                                                <a href="javascript:void(0);" class="menu-link px-3" onclick="delete_item(<?php echo $d->id; ?>);">Delete</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Edit Model -->
@foreach($employee as $key=>$d)
<div class="modal fade" id="kt_modal_add_customer<?php echo $d['id']; ?>" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-850px">
        <!--begin::Modal content-->
        <div class="modal-content">

            <!--begin::Modal header-->
            <div class="modal-header" id="kt_modal_add_user_header">
                <!--begin::Modal title-->
                <h2 class="fw-bold">Add</h2>
                <!--end::Modal title-->
                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-kt-users-modal-action="close">
                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                    <span class="svg-icon svg-icon-1">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor" />
                            <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor" />
                        </svg>
                    </span>
                    <!--end::Svg Icon-->
                </div>
                <!--end::Close-->
            </div>
            <!--end::Modal header-->
            <!--begin::Modal body-->
            <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">

               
                <form id="designation_form" class="form" method="post" enctype="multipart/form-data" action="{{url('employees')}}">
                    @csrf
                    <div class="fv-row mb-7">
                        <!--begin::Wrapper-->
                        <div class="d-flex flex-stack">
                            <!--begin::Label-->
                            <div class="me-5">
                                <!--begin::Label-->
                                <label class="fs-6 fw-semibold">Active</label>
                                <!--end::Label-->

                            </div>
                            <!--end::Label-->
                            <!--begin::Switch-->
                            <label class="form-check form-switch form-check-custom form-check-solid">
                                <!--begin::Input-->
                                <input class="form-check-input" name="is_active" type="checkbox" value="1" id="kt_modal_add_customer_billing" <?php if ($d['is_active'] == 1) {
                                    echo "checked";
                                } ?>/>
                                <!--end::Input-->
                                <!--begin::Label-->
                                <span class="form-check-label fw-semibold text-muted" for="kt_modal_add_customer_billing">Yes</span>
                                <!--end::Label-->
                            </label>
                            <!--end::Switch-->
                        </div>
                        <!--begin::Wrapper-->
                    </div>
                    <!--end::Input group-->

                    <div class="row g-9 mb-7">
                        <!--begin::Col-->
                        <div class="col-md-6 fv-row">
                            <!--begin::Label-->
                            <label class="required fs-6 fw-semibold mb-2">First Name</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" class="form-control form-control-solid" placeholder="Enter First Name" name="first_name" value="{{$d['first_name']}}"/>
                            <!--end::Input-->
                        </div>
                        <!--end::Col-->

                          <!--begin::Col-->
                          <div class="col-md-6 fv-row">
                            <!--begin::Label-->
                            <label class="required fs-6 fw-semibold mb-2">Last Name</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" class="form-control form-control-solid" placeholder="Enter Last Name" name="last_name" value="{{$d['last_name']}}"/>
                            <!--end::Input-->
                        </div>
                        <!--end::Col-->

                          <!--begin::Col-->
                          <div class="col-md-6 fv-row">
                            <!--begin::Label-->
                            <label class="required fs-6 fw-semibold mb-2">Email</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="email" class="form-control form-control-solid" placeholder="Enter Email" name="email" value="{{$d['email']}}"/>
                            <!--end::Input-->
                        </div>
                        <!--end::Col-->


                            <!--begin::Col-->
                            <div class="col-md-6 fv-row">
                                <!--begin::Label-->
                                <label class="required fs-6 fw-semibold mb-2">Mobile</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="number" class="form-control form-control-solid" placeholder="Enter Mobile" name="mobile" value="{{$d['mobile']}}"/>
                                <!--end::Input-->
                            </div>
                            <!--end::Col-->


                             <!--begin::Col-->
                             <div class="col-md-6 fv-row">
                                <!--begin::Label-->
                                <label class="required fs-6 fw-semibold mb-2">Department</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <select class="form-control form-control-solid" name="department_id">
                                    <option value="">Select</option>
                                    @foreach ($departments as $dept)
                                        <option <?php if($d['department_id']==$dept['id']){ echo "selected";}?> value="<?php echo $dept['id'];?>"><?php echo $dept['name'];?></option>
                                    @endforeach
                                </select>
                                <!--end::Input-->
                            </div>
                            <!--end::Col-->

                             <!--begin::Col-->
                             <div class="col-md-6 fv-row">
                                <!--begin::Label-->
                                <label class="required fs-6 fw-semibold mb-2">Designation</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <select class="form-control form-control-solid" name="designation_id">
                                    <option value="">Select</option>
                                    @foreach ($designation as $des)
                                    <option <?php if($d['designation_id']==$des['id']){ echo "selected";}?> value="<?php echo $des['id'];?>"><?php echo $des['name'];?></option>
                                @endforeach
                                </select>
                                <!--end::Input-->
                            </div>
                            <!--end::Col-->

                             <!--begin::Col-->
                             <div class="col-md-6 fv-row">
                                <!--begin::Label-->
                                <label class="required fs-6 fw-semibold mb-2">SAP-id</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" class="form-control form-control-solid" placeholder="Enter SAP-id" name="sap_id" value="{{$d['sap_id']}}"/>
                                <!--end::Input-->
                            </div>
                            <!--end::Col-->

                               <!--begin::Col-->
                               <div class="col-md-6 fv-row">
                                <!--begin::Label-->
                                <label class="required fs-6 fw-semibold mb-2">Profie</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="file" class="form-control form-control-solid" name="profile_image" />
                                <!--end::Input-->
                                <img src="{{ asset('images/'.$d['profile_image']) }}" width="50" height="50">
                            </div>
                            <!--end::Col-->

                                <!--begin::Col-->
                                <div class="col-md-6 fv-row">
                                    <!--begin::Label-->
                                    <label class="required fs-6 fw-semibold mb-2">Signature</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="file" class="form-control form-control-solid" name="sign_image" />
                                    <!--end::Input-->
                                    <img src="{{ asset('images/'.$d['sign_image']) }}" width="50" height="50">
                                </div>
                                <!--end::Col-->


                        <!--begin::Col-->
                        <div class="col-md-12 fv-row">
                            <!--begin::Label-->
                            <label class="required fs-6 fw-semibold mb-2">Address</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <textarea class="form-control form-control-solid" name="address" rows="4" cols="50">{{$d['address']}}</textarea>
                            <input type="hidden" name="id" value="{{$d['id']}}">
                            <!--end::Input-->
                        </div>
                        <!--end::Col-->
                    </div>

                    {{-- FORM --}}
                    <div class="text-center pt-15">
                        <button type="reset" class="btn btn-light me-3" data-kt-users-modal-action="cancel">Reset</button>
                        <button type="submit" class="btn switchPrimaryBtn " data-kt-users-modal-action="submit">
                            <span class="indicator-label">Save and Exit</span>
                            <span class="indicator-progress">Please wait...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                        </button>
                    </div>

                </form>

            </div>

        </div>
    </div>
</div>

@endforeach

@endsection
<script data-require="jquery@*" data-semver="3.0.0" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.js"></script>
<script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.js"></script>
<script>
    $(document).ready(function() {
        // on form submit
        $("#designation_form1").on('submit', function() {
            // to each unchecked checkbox
            $(this).find('input[type=checkbox]:not(:checked)').prop('checked', true).val(0);
        })
    })

    $(document).ready(
        function() {
            $('#service_table').DataTable({
                "lengthMenu": [
                    [10, 25, 50, -1],
                    [10, 25, 50, "All"]
                ]
            });

        });



    function delete_item(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3565ed',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then(isConfirmed => {
            if (isConfirmed.value) {
                $.ajax({
                    url: "{{url('employees')}}"+"/"+id,
                    type: 'ajax',
                    method: 'delete',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        id: id,
                    },
                    success: function(result) {
                        if (result) {
                            window.location.reload();
                        }
                    }
                });
                if (isConfirmed.value) {
                    Swal.fire(
                        'Deleted!',
                        'Employee has been deleted.',
                        'success'
                    );

                }
            }
        });
    }
</script>
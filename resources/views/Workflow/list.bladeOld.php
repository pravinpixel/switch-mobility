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
                    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Workflow</h1>
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
                        <li class="breadcrumb-item text-muted">Workflow</li>
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
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_add_user">
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
                            <div class="modal fade" id="kt_modal_add_user" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
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
                                            <div class="btn btn-icon btn-sm btn-active-icon-danger" data-bs-dismiss="modal">
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

                                            <form id="designation_form" class="form" method="post" enctype="multipart/form-data" action="{{url('workflow')}}">
                                                @csrf
                                                <div class="fv-row mb-7">
                                                    <!--begin::Wrapper-->
                                                    <div class="d-flex flex-stack">
                                                        <!--begin::Label-->
                                                        <div class="me-5">


                                                        </div>
                                                        <!--end::Label-->
                                                        <!--begin::Switch-->
                                                        <label class="form-check form-switch form-check-custom form-check-solid">
                                                            <!--begin::Input-->
                                                            <span class="form-check-label fw-semibold text-muted" for="kt_modal_add_customer_billing">Full</span>&nbsp;

                                                            <input class="form-check-input partial" name="workflow_type" type="checkbox" id="kt_modal_add_customer_billing" />
                                                            <!--end::Input-->
                                                            <!--begin::Label-->
                                                            <span class="form-check-label fw-semibold text-muted" for="kt_modal_add_customer_billing">Parial</span>
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
                                                        <label class="required fs-6 fw-semibold mb-2">Work Flow Code</label>
                                                        <!--end::Label-->
                                                        <!--begin::Input-->
                                                        <input type="text" class="form-control form-control-solid" placeholder="Enter Work Flow Code" name="workflow_code" required />
                                                        <!--end::Input-->
                                                    </div>
                                                    <!--end::Col-->

                                                    <!--begin::Col-->
                                                    <div class="col-md-6 fv-row">
                                                        <!--begin::Label-->
                                                        <label class="required fs-6 fw-semibold mb-2">Work Flow Name</label>
                                                        <!--end::Label-->
                                                        <!--begin::Input-->
                                                        <input type="text" class="form-control form-control-solid" placeholder="Enter Work Flow Name" name="workflow_name" required />
                                                        <!--end::Input-->
                                                    </div>
                                                    <!--end::Col-->
                                                    <div class="">
                                                        <div class="">
                                                            <table class="table">
                                                                <colgroup>
                                                                    <col width="40%">
                                                                    <col width="20%">
                                                                    <col width="">
                                                                </colgroup>
                                                                <thead>
                                                                    <tr>
                                                                        <th>Levels </th>
                                                                        <th class="text-center">Approver Designation</th>
                                                                    </tr>
                                                                </thead>

                                                            </table>
                                                        </div>
                                                    </div>

                                                    <div class="full_level">
                                                        <div class="near_by_hotel_container">
                                                            <table class="table no-border custom_table dataTable no-footer dtr-inline">
                                                                <colgroup>
                                                                    <col width="40%">
                                                                    <col width="20%">
                                                                    <col width="">
                                                                </colgroup>

                                                                <tbody>
                                                                    @for ($i=0; $i<=10; $i++) <tr>
                                                                        <td>
                                                                            <label>Level-{{$i+1}}</label>
                                                                            <input type="hidden" name="levels[]" value="{{$i+1}}" class="full_work">
                                                                        </td>
                                                                        <td class="text-center">
                                                                            <select class="form-control full_work select2" name="approver_designation{{$i+1}}[]" multiple>
                                                                                <option value="">Select</option>
                                                                                @foreach($designation as $desi)
                                                                                <option value="{{$desi['id']}}">{{$desi['name']}}</option>
                                                                                @endforeach

                                                                            </select>
                                                                        </td>
                                                                        </tr>
                                                                        @endfor
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>

                                                    <div class="multi-field-wrapper">
                                                        <div class="multi-fields">
                                                            <div class="multi-field">
                                                                <table class="table no-border custom_table dataTable no-footer dtr-inline">
                                                                    <colgroup>
                                                                        <col width="40%">
                                                                        <col width="20%">
                                                                        <col width="">
                                                                    </colgroup>

                                                                    <tbody>
                                                                        <tr>
                                                                            <td>
                                                                                <select class="form-control select_level" name="levels[]">
                                                                                    <option value="0">Select</option>
                                                                                    @for($i=1;$i<=11;$i++) <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                                                                        @endfor
                                                                                </select>

                                                                              
                                                                                <!-- <label>Level-<span class="level_name">1</span></label> -->
                                                                                <input type="hidden" name="levels[]" class="levels" value="1">
                                                                            </td>
                                                                            <td class="text-center">
                                                                                <select class="form-control designation select2" name="approver_designation[]" multiple>
                                                                                    <option value="">Select</option>
                                                                                    @foreach($designation as $desi)
                                                                                    <option value="{{$desi['id']}}">{{$desi['name']}}</option>
                                                                                    @endforeach

                                                                                </select>
                                                                            </td>
                                                                        </tr>

                                                                    </tbody>
                                                                </table>
                                                                <button type="button" class="remove-field btn btn-sm btn-danger">Remove</button>
                                                            </div>
                                                        </div>
                                                        <button type="button" class="add-field btn btn-sm btn-success" style="margin-left: 639px;margin-top: -36px;">Add</button>
                                                    </div>




                                                </div>
                                                <b>Note: The Maximum possible level is 11</b>
                                                {{-- FORM --}}
                                                <div class="text-center pt-15">
                                                    <button type="reset" class="btn btn-light me-3" data-kt-users-modal-action="cancel">Reset</button>
                                                    <button type="submit" class="btn btn-primary" data-kt-users-modal-action="submit">
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
                        <div class="card-title">
                            <!--begin::Search-->
                            <div class="d-flex align-items-center position-relative my-1">
                                <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                                <span class="svg-icon svg-icon-1 position-absolute ms-6">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor" />
                                        <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="currentColor" />
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->
                                <input type="text" id="searchInput" data-kt-user-table-filter="search" class="form-control form-control-solid w-250px ps-14" placeholder="Search" />
                            </div>
                            <!--end::Search-->
                        </div>
                        <!--begin::Table-->
                        <table class="table align-middle table-row-bordered fs-6 gy-5" id="service_table">
                            <!--begin::Table head-->
                            <thead>
                                <!--begin::Table row-->
                                <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                    <th class="min-w-125px">S.no</th>
                                    <th class="min-w-125px">Work Flow Name </th>
                                    <th class="min-w-125px">Work Flow Code </th>
                                    <th class="min-w-125px">Levels</th>

                                    <th class="text-end min-w-100px">Actions</th>
                                </tr>
                                <!--end::Table row-->
                            </thead>
                            <!--end::Table head-->
                            <!--begin::Table body-->
                            <tbody class="text-gray-600 fw-semibold">
                                <!--begin::Table row-->
                                @foreach($workflow as $key=>$d)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{$d['workflow_name']}}</td>
                                    <td>{{$d['workflow_code']}}</td>
                                    <td>{{$d['total_levels']}}</td>

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
                                                <a href="#" class="menu-link px-3" data-bs-toggle="modal" data-bs-target="#kt_modal_add_customer<?php echo $d['id']; ?>" onclick="get_workflow_type(<?php echo $d['id']; ?>);">Edit</a>
                                            </div>
                                            <div class="menu-item px-3">
                                                <a href="javascript:void(0);" class="menu-link px-3" onclick="delete_item(<?php echo $d['id']; ?>);">Delete</a>
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
@foreach($workflow as $key=>$d)
<div class="modal fade" id="kt_modal_add_customer<?php echo $d['id']; ?>" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-850px">
        <!--begin::Modal content-->
        <div class="modal-content">

            <!--begin::Modal header-->
            <div class="modal-header" id="kt_modal_add_user_header">
                <!--begin::Modal title-->
                <h2 class="fw-bold">Edit</h2>
                <!--end::Modal title-->
                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-icon-danger" data-bs-dismiss="modal">
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



                <form id="designation_form1" class="form designation_form_edit" method="post" enctype="multipart/form-data" action="{{url('workflow')}}">
                    @csrf
                    <div class="fv-row mb-7">
                        <!--begin::Wrapper-->
                        <div class="d-flex flex-stack">
                            <!--begin::Label-->
                            <div class="me-5">


                            </div>
                            <!--end::Label-->
                            <!--begin::Switch-->
                            <label class="form-check form-switch form-check-custom form-check-solid">
                                <!--begin::Input-->
                                <span class="form-check-label fw-semibold text-muted" for="kt_modal_add_customer_billing">Full</span>&nbsp;

                                <input class="form-check-input partial1" name="workflow_type" type="checkbox" <?php if ($d['workflow_type'] == 1) {
                                                                                                                    echo "checked";
                                                                                                                } ?> id="kt_modal_add_customer_billing" />
                                <!--end::Input-->
                                <!--begin::Label-->
                                <span class="form-check-label fw-semibold text-muted" for="kt_modal_add_customer_billing">Parial</span>
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
                            <label class="required fs-6 fw-semibold mb-2">Work Flow Code</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" class="form-control form-control-solid" placeholder="Enter Work Flow Code" name="workflow_code" value="{{$d['workflow_code']}}" required />
                            <!--end::Input-->
                        </div>
                        <!--end::Col-->

                        <!--begin::Col-->
                        <div class="col-md-6 fv-row">
                            <!--begin::Label-->
                            <label class="required fs-6 fw-semibold mb-2">Work Flow Name</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" class="form-control form-control-solid" placeholder="Enter Work Flow Name" name="workflow_name" value="{{$d['workflow_name']}}" required />
                            <!--end::Input-->
                        </div>
                        <!--end::Col-->
                        <div class="">
                            <div class="">
                                <table class="table">
                                    <colgroup>
                                        <col width="40%">
                                        <col width="20%">
                                        <col width="">
                                    </colgroup>
                                    <thead>
                                        <tr>
                                            <th>Levels </th>
                                            <th class="text-center">Approver Designation</th>
                                        </tr>
                                    </thead>

                                </table>
                            </div>
                        </div>

                        <div class="full_level1">
                            <div class="near_by_hotel_container">
                                <table class="table no-border custom_table dataTable no-footer dtr-inline">
                                    <colgroup>
                                        <col width="40%">
                                        <col width="20%">
                                        <col width="">
                                    </colgroup>

                                    <tbody class="append_div_full">
                                        @for ($i=0; $i<=10; $i++) <tr>
                                            <td>
                                                <label>Level-{{$i+1}}</label>
                                                <input type="hidden" name="levels[]" value="{{$i+1}}" class="full_work1">
                                            </td>
                                            <td class="text-center">
                                                <select class="form-control full_work1 select2" name="approver_designation[]" required>
                                                    <option value="">Select</option>
                                                    @foreach($designation as $desi)
                                                    <option value="{{$desi['id']}}">{{$desi['name']}}</option>
                                                    @endforeach

                                                </select>
                                            </td>
                                            </tr>
                                            @endfor
                                    </tbody>
                                </table>
                            </div>
                        </div>


                        <div class="multi-field-wrapper1 partial11">
                            <div class="multi-fields1">
                                <div class="multi-field1">
                                    <table class="table no-border custom_table dataTable no-footer dtr-inline edittable">
                                        <colgroup>
                                            <col width="40%">
                                            <col width="20%">
                                            <col width="">
                                        </colgroup>
                                        <tbody class="append_div_partial">
                                            <tr>
                                                <td>
                                                <select class="form-control select_level" name="levels[]">
                                                                                    <option value="0">Select</option>
                                                                                    @for($i=1;$i<=11;$i++) <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                                                                        @endfor
                                                                                </select>
                                                    <!-- <label>Level-<span class="level_name1">1</span></label> -->
                                                    <input type="hidden" name="levels[]" class="levels" value="1">
                                                </td>
                                                <td class="text-center">
                                                    <select class="form-control designation select2" name="approver_designation[]" multiple required>
                                                        <option value="">Select</option>
                                                        @foreach($designation as $desi)
                                                        <option value="{{$desi['id']}}">{{$desi['name']}}</option>
                                                        @endforeach

                                                    </select>
                                                </td>
                                            </tr>


                                        </tbody>
                                    </table>
                                    <button type="button" class="remove-field1 btn btn-sm btn-danger">Remove</button>
                                </div>
                            </div>
                            <button type="button" class="add-field1 btn btn-sm btn-success" style="margin-left: 639px;margin-top: -36px;">Add</button>
                        </div>



                        <input type="hidden" class="total_levels_edit" value="{{$d['total_levels']}}">
                        <input type="hidden" name="workflow_id" value="{{$d['id']}}">

                    </div>
                    <b>Note: The Maximum possible level is 11</b>
                    {{-- FORM --}}
                    <div class="text-center pt-15">
                        <button type="reset" class="btn btn-light-danger me-3" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" data-kt-users-modal-action="submit">
                            <span class="indicator-label">Update and Exit</span>
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
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script type="text/javascript">


$(document).ready(function() {

    $('.select_level').change(function() {
        $('.select_level option[value=' + $(this).val() + ']').css('color','red').attr('disabled', 'disabled');
        $(this).next('.levels').val(this.value);
        $(this).parent().next().find('.designation').attr("name","approver_designation"+this.value+"[]").end();
        // $(this).parent().next().find('.select2').select2("destroy").select2();
        // $('.select2').select2(); 
        // $('.designation').attr("id","page_navigation1");
        // $(this).parent().find('.levels').val($(this).val());
    });

    
    $(document).on("change",'.select_level1', function(){
        $('.select_level1 option[value=' + $(this).val() + ']').css('color','red').attr('disabled', 'disabled');
        $(this).next('.levels1').val(this.value);
        $(this).parent().next().find('.designation1').attr("name","approver_designation"+this.value+"[]").end();
});

});



    $(document).ready(function() {
        $('select').selectpicker();

        $("select").change(function() {

            $("select option").attr("disabled", ""); //enable everything

            //collect the values from selected;
            var arr = $.map(
                $("select option:selected"),
                function(n) {
                    return n.value;
                }
            );


            $("select option").filter(function() {

                return $.inArray($(this).val(), arr) > -1;
            }).attr("disabled", "disabled");

        });


    });
</script>
<script>
    $(document).ready(function() {
        $('.modal').each(function() {
            $(this).on('hidden.bs.modal', function() {
                window.location.reload();
                //fires when evey popup close. Ex. resetModal();
            });
        });
    });

    $(document).ready(function() {
        // on form submit
        $("#designation_form").on('submit', function() {
            // to each unchecked checkbox
            $(this).find('input[type=checkbox]:not(:checked)').prop('checked', true).val(0);
        })

        $(".designation_form_edit").on('submit', function() {
            // to each unchecked checkbox
            $(this).find('input[type=checkbox]:not(:checked)').prop('checked', true).val(0);
        })
    })

    $(document).ready(function() {
        $(".multi-field-wrapper").hide();
        $(".full_level1").hide();
        $(".partial11").hide();
        $(".levels").prop('disabled', true);
        $('.partial').change(function() {
            if (this.checked) {
                $(".full_level").hide();
                $(".multi-field-wrapper").show();
                $(".levels").prop('disabled', false);
                $(".full_work").prop('disabled', true);
            } else {
                $(".full_level").show();
                $(".levels").prop('disabled', true);
                $(".full_work").prop('disabled', false);
                $(".multi-field-wrapper").hide();
            }
        });
    });
    $(function() {
        $('.multi-field-wrapper').each(function() {
            var $wrapper = $('.multi-fields', this);

            $(".add-field", $(this)).click(function(e) {
                var length = $(".multi-field").length;
                if (length <= 10) {
                    $('.multi-field:first-child', $wrapper).clone(true).appendTo($wrapper).find('input','select').val('').end()
                        .find(".level_name").html(length + 1).end()
                        .find(".levels").select2("destroy").select2();
                        
                        // .find(".levels").val(length + 1).end();
                    focus();
                }
            });
            $('.multi-field .remove-field', $wrapper).click(function() {
                if ($('.multi-field', $wrapper).length > 1)
                    $(this).parent('.multi-field').remove();
            });
        });
    });


    // Edit


    $(document).ready(function() {
        $('.partial1').change(function() {

            if (this.checked) {
                $(".full_level1").hide();
                $(".multi-field-wrapper1").show();
                $(".levels1").prop('disabled', false);
                $(".full_work1").prop('disabled', true);
            } else {
                $(".full_level1").show();
                $(".levels1").prop('disabled', true);
                $(".full_work1").prop('disabled', false);
                $(".multi-field-wrapper1").hide();
            }
        });
    });
    $(function() {
        $('.multi-field-wrapper1').each(function() {
            var $wrapper = $('.multi-fields1', this);

            $(".add-field1", $(this)).click(function(e) {
                // $(".append_div_partial").empty();
                // $(".append_div_partial").append('<tr><td><label>Level-<span class="level_name1">1</span></label><input type="hidden" name="levels[]" class="levels1" value="1"></td><td class="text-center"><select class="form-control levels1" name="approver_designation[]" required><option value="">Select</option>@foreach($designation_edit as $desi)<option  value="{{$desi->id}}">{{$desi->name}}</option>@endforeach</select></td></tr>');
                var length = $('table.edittable tr:last').index() + 1;
                if (length + 1 <= 11) {
                    $('<tr><td> <select class="form-control select_level1" name="levels[]"> <option value="0">Select</option> @for($i=1;$i<=11;$i++) <option value="<?php echo $i; ?>"><?php echo $i; ?></option> @endfor </select> <input type="hidden" name="levels[]" class="levels1" value="1"> </td><td class="text-center"> <select class="form-control designation1 select2" name="approver_designation[]" multiple required> <option value="">Select</option> @foreach($designation as $desi) <option value="{{$desi['id']}}">{{$desi['name']}}</option> @endforeach </select> </td></tr>').appendTo(".append_div_partial").find('input').val('').end()
                        .find(".level_name1").html("").end();
                        // .find(".level_name1").html(length + 1).end()
                        // .find(".levels1").val(length + 1).end();
                    focus();
                }
            });
            $('.multi-field1 .remove-field1', $wrapper).click(function() {
                $(".edittable tr:last-child").remove();
                // if ($('.multi-field1', $wrapper).length > 1)
                // $(this).parent('.multi-field1').remove();
            });
        });
    });


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
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then(isConfirmed => {
            if (isConfirmed.value) {
                $.ajax({
                    url: "{{url('workflow')}}" + "/" + id,
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
                        'Workflow has been deleted.',
                        'success'
                    );

                }
            }
        });
    }

    function get_workflow_type(workflow_id) {
        $.ajax({
            url: "{{url('getWorkflowById')}}",
            type: 'ajax',
            method: 'post',
            data: {
                "_token": "{{ csrf_token() }}",
                workflow_id: workflow_id,
            },
            success: function(result) {
                var data = JSON.parse(result);
                if (data) {
                    var workflow_type = data.workflow_type;
                    if (workflow_type == 1) {
                        $(".full_level1").hide();
                        $(".multi-field-wrapper1").show();
                        $(".levels1").prop('disabled', false);
                        $(".full_work1").prop('disabled', true);
                    } else {
                        $(".full_level1").show();
                        $(".levels1").prop('disabled', true);
                        $(".full_work1").prop('disabled', false);
                        $(".multi-field-wrapper1").hide();
                    }

                    // Getting Workflow levels

                    $.ajax({
                        url: "{{url('getWorkflowLevels')}}",
                        type: 'ajax',
                        method: 'post',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            workflow_id: workflow_id,
                        },
                        success: function(result) {
                            var data = JSON.parse(result);
                            console.log(data);
                            if (data.workflow_levels) {

                                var levels = data.workflow_levels;
                                if (workflow_type == 1) {
                                    $(".append_div_partial").empty();
                                    for(var i = 1; i <= data.workflow.total_levels; i++){
                                        //var level = key + 1;
                                        $(".append_div_partial").append('<tr><td> <select class="form-control select_level1 lev'+data.workflow_levels[i-1]+'" name="levels[]"> <option value="0">Select</option></select> <input type="hidden" name="levels[]" class="levels1" value="1"> </td><td class="text-center"> <select class="form-control designation1 select2 des'+data.workflow_levels[i-1]+'" name="approver_designation[]" multiple required> <option value="">Select</option></select> </td></tr>');
                                        
                                        for (var j = 1; j <= 11; j++)
                                        {
                                            if (data.workflow_levels[i-1] == j) {
                                                var selected1 = "selected";
                                            } else {
                                                var selected1 = "";
                                            }

                                            var option = '<option '+selected1+' value="' + j + '">' + j +'</option>';
                                            $('.lev'+data.workflow_levels[i-1]).append(option);
                                        }
                                        
                                        $.each(data.designation, function(key, value) {
                                            if(jQuery.inArray(value.id, data.approver[i-1]) !== -1) {
                                                var selected = "selected";
                                            } else {
                                                var selected = "";
                                            }
                                            var option = '<option '+selected+' value="' + value.id + '">' + value.name +
                                                '</option>';
                                            $('.des'+data.workflow_levels[i-1]).append(option);
                                        });
                                    }
                                } else {
                                    $(".append_div_full").empty();
                                    $.each(levels, function(key, val) {
                                        var level = key + 1;

                                        $(".append_div_full").append('<tr><td><label>Level-<span class="level_name1">' + level + '</span></label><input type="hidden" name="levels[]" class="full_work1" value="' + key + 1 + '"></td><td class="text-center"><select class="des1' + level + ' form-control full_work1" name="approver_designation'+level+'[]" multiple required><option value="">Select</option></select></td></tr>');
                                        
                                        $.each(data.designation, function(key1, value) {
                                            console.log(data.approver[key]);
                                            if(jQuery.inArray(value.id, data.approver[key]) !== -1) {
                                                var selected = "selected";
                                            } else {
                                                var selected = "";
                                            }
                                            var option = '<option ' + selected + ' value="' + value.id + '">' + value.name +
                                                '</option>';
                                            $('.des1' + level).append(option);
                                        });
                                    });
                                }

                            }
                        }
                    });

                }
            }
        });
    }
</script>
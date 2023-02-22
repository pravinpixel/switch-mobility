@extends('layouts.app')

@section('content')
<style>
    input.permission {
        width: 40px;
        height: 40px;
    }

    .accordion {
        background-color: #eee;
        color: #444;
        cursor: pointer;
        padding: 18px;
        width: 100%;
        border: none;
        text-align: left;
        outline: none;
        font-size: 15px;
        transition: 0.4s;
    }

    .active,
    .accordion:hover {
        background-color: #ccc;
    }

    .accordion:after {
        content: '\002B';
        color: #777;
        font-weight: bold;
        float: right;
        margin-left: 5px;
    }

    .active:after {
        content: "\2212";
    }

    .panel {
        padding: 0 18px;
        background-color: white;
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.2s ease-out;
    }

    .checkboxes {
        display: flex;
        justify-content: start;
        align-items: center;
        vertical-align: middle;
        word-wrap: break-word;

    }

    .checkAll {
        width: 25px;
        height: 25px;
    }
</style>
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
                    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Privillages</h1>
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
                        <li class="breadcrumb-item text-muted">Privillages</li>
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
                                @if(auth()->user()->is_super_admin ==1 ||auth()->user()->can('role-create'))
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_add_user">
                                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr075.svg-->
                                    <span class="svg-icon svg-icon-2">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1" transform="rotate(-90 11.364 20.364)" fill="currentColor" />
                                            <rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="currentColor" />
                                        </svg>
                                    </span>
                                    <!--end::Svg Icon-->Add</button>@endif
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
                                <div class="modal-dialog modal-dialog-centered mw-750px">
                                    <!--begin::Modal content-->
                                    <div class="modal-content">

                                        <!--begin::Modal header-->
                                        <div class="modal-header" id="kt_modal_add_user_header">
                                            <!--begin::Modal title-->
                                            <h2 class="fw-bold">Add</h2>
                                            <!--end::Modal title-->
                                            <!--begin::Close-->
                                            <div class="btn btn-icon btn-sm btn-active-icon-danger" data-bs-dismiss="modal" onclick=" document.location.reload();">
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

                                            <form id="department_form" class="form" method="post" action="{{url('roles')}}">
                                                @csrf


                                                <div class="row g-9 mb-7">
                                                    <!--begin::Col-->
                                                    <div class="col-md-12 fv-row">
                                                        <!--begin::Label-->
                                                        <label class="required fs-6 fw-semibold mb-2">Name</label>
                                                        <!--end::Label-->
                                                        <!--begin::Input-->
                                                        <input required class="form-control form-control-solid roleName" placeholder="Enter Privillages" name="name" fieldData="" />
                                                        <!--end::Input-->
                                                        <p id="roleNameAlert" class="notifyAlert"></p>
                                                    </div>
                                                    <!--end::Col-->

                                                </div>
                                                <div class="fv-row mb-15">
                                                    <!--begin::Wrapper-->
                                                    <div class="d-flex flex-stack">
                                                        <!--begin::Label-->
                                                        <div class="me-5">
                                                            <label class="required fs-6 fw-semibold">Authority</label>
                                                        </div>
                                                        <!--end::Label-->
                                                        <!--begin::Checkboxes-->
                                                        <div class="d-flex">
                                                            <!--begin::Checkbox-->
                                                            <label class="form-radio form-radio-custom form-radio-solid me-6">
                                                                <!--begin::Input-->
                                                                <input class="form-radio-input h-20px w-20px authority_type" type="radio" value="1" name="authority_type" checked />
                                                                <!--end::Input-->
                                                                <!--begin::Label-->
                                                                <span class="form-radio-label fw-semibold">Admin/HOD</span>
                                                                <!--end::Label-->
                                                            </label>
                                                            <!--end::Checkbox-->
                                                            <!--begin::Checkbox-->
                                                            <label class="form-radio form-radio-custom form-radio-solid">
                                                                <!--begin::Input-->
                                                                <input class="form-radio-input h-20px w-20px authority_type" type="radio" value="2" name="authority_type" />
                                                                <!--end::Input-->
                                                                <!--begin::Label-->
                                                                <span class="form-radio-label fw-semibold">Employee</span>
                                                                <!--end::Label-->
                                                            </label>
                                                            <!--end::Checkbox-->
                                                        </div>
                                                        <!--end::Checkboxes-->
                                                    </div>
                                                    <!--begin::Wrapper-->
                                                </div>
                                                <div class="col-md-12 col-sm-12">
                                                    <button type="button" class="accordion">Permission</button>
                                                    <div class="panel">
                                                        <br>
                                                        <label for="checkbox1" class="checkboxes"><input type="checkbox" id="checkbox1" name="checkAll" value="" class="checkboxes checkAll" />
                                                            Check All</label>
                                                        <table class="table table-striped">
                                                            <thead>
                                                                <th scope="col" width="1%">S.No</th>
                                                                <th scope="col" width="20%">Screen Name</th>
                                                                <th scope="col" width="10%">View</th>
                                                                <th scope="col" width="10%">Create</th>
                                                                <th scope="col" width="10%">Edit </th>
                                                                <th scope="col" width="10%">Delete</th>

                                                                <th scope="col" width="10%">Upload </th>
                                                                <th scope="col" width="10%">Download</th>

                                                            </thead>

                                                            <tbody>
                                                                <tr>
                                                                    <td>1</td>
                                                                    <td>Department</td>
                                                                    <td><input type="checkbox" name="permission[]" value="department-view" class='permission permisionCreate'></td>
                                                                    <td><input type="checkbox" name="permission[]" value="department-create" class='permission permisionCreate'></td>
                                                                    <td><input type="checkbox" name="permission[]" value="department-edit" class='permission permisionCreate'></td>
                                                                    <td><input type="checkbox" name="permission[]" value="department-delete" class='permission permisionCreate'></td>
                                                                    <td><input type="checkbox" name="permission[]" value="department-upload" class='permission permisionCreate'></td>
                                                                    <td><input type="checkbox" name="permission[]" value="department-download" class='permission permisionCreate'></td>

                                                                </tr>
                                                                <tr>
                                                                    <td>2</td>
                                                                    <td>Designation</td>
                                                                    <td><input type="checkbox" name="permission[]" value="designation-view" class='permission permisionCreate'></td>
                                                                    <td><input type="checkbox" name="permission[]" value="designation-create" class='permission permisionCreate'></td>
                                                                    <td><input type="checkbox" name="permission[]" value="designation-edit" class='permission permisionCreate'></td>
                                                                    <td><input type="checkbox" name="permission[]" value="designation-delete" class='permission permisionCreate'></td>
                                                                    <td><input type="checkbox" name="permission[]" value="designation-upload" class='permission permisionCreate'></td>
                                                                    <td><input type="checkbox" name="permission[]" value="designation-download" class='permission permisionCreate'></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>3</td>
                                                                    <td>Document Type</td>
                                                                    <td><input type="checkbox" name="permission[]" value="document-type-view" class='permission permisionCreate'></td>
                                                                    <td><input type="checkbox" name="permission[]" value="document-type-create" class='permission permisionCreate'></td>
                                                                    <td><input type="checkbox" name="permission[]" value="document-type-edit" class='permission permisionCreate'></td>
                                                                    <td><input type="checkbox" name="permission[]" value="document-type-delete" class='permission permisionCreate'></td>
                                                                    <td><input type="checkbox" name="permission[]" value="document-type-upload" class='permission permisionCreate'></td>
                                                                    <td><input type="checkbox" name="permission[]" value="document-type-download" class='permission permisionCreate'></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>4</td>
                                                                    <td>Employee</td>
                                                                    <td><input type="checkbox" name="permission[]" value="employee-view" class='permission permisionCreate'></td>
                                                                    <td><input type="checkbox" name="permission[]" value="employee-create" class='permission permisionCreate'></td>
                                                                    <td><input type="checkbox" name="permission[]" value="employee-edit" class='permission permisionCreate'></td>
                                                                    <td><input type="checkbox" name="permission[]" value="employee-delete" class='permission permisionCreate'></td>
                                                                    <td><input type="checkbox" name="permission[]" value="employee-upload" class='permission permisionCreate'></td>
                                                                    <td><input type="checkbox" name="permission[]" value="employee-download" class='permission permisionCreate'></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>5</td>
                                                                    <td>Projects</td>
                                                                    <td><input type="checkbox" name="permission[]" value="project-view" class='permission permisionCreate'></td>
                                                                    <td><input type="checkbox" name="permission[]" value="project-create" class='permission permisionCreate'></td>
                                                                    <td><input type="checkbox" name="permission[]" value="project-edit" class='permission permisionCreate'></td>
                                                                    <td><input type="checkbox" name="permission[]" value="project-delete" class='permission permisionCreate'></td>
                                                                    <td><input type="checkbox" name="permission[]" value="project-upload" class='permission permisionCreate'></td>
                                                                    <td><input type="checkbox" name="permission[]" value="project-download" class='permission permisionCreate'></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>6</td>
                                                                    <td>WorkFlow</td>
                                                                    <td><input type="checkbox" name="permission[]" value="workflow-view" class='permission permisionCreate'></td>
                                                                    <td><input type="checkbox" name="permission[]" value="workflow-create" class='permission permisionCreate'></td>
                                                                    <td><input type="checkbox" name="permission[]" value="workflow-edit" class='permission permisionCreate'></td>
                                                                    <td><input type="checkbox" name="permission[]" value="workflow-delete" class='permission permisionCreate'></td>
                                                                    <td><input type="checkbox" name="permission[]" value="workflow-upload" class='permission permisionCreate'></td>
                                                                    <td><input type="checkbox" name="permission[]" value="workflow-download" class='permission permisionCreate'></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>7</td>
                                                                    <td>Role</td>
                                                                    <td><input type="checkbox" name="permission[]" value="role-view" class='permission permisionCreate'></td>
                                                                    <td><input type="checkbox" name="permission[]" value="role-create" class='permission permisionCreate'></td>
                                                                    <td><input type="checkbox" name="permission[]" value="role-edit" class='permission permisionCreate'></td>
                                                                    <td><input type="checkbox" name="permission[]" value="role-delete" class='permission permisionCreate'></td>
                                                                    <td><input type="checkbox" name="permission[]" value="role-upload" class='permission permisionCreate'></td>
                                                                    <td><input type="checkbox" name="permission[]" value="role-download" class='permission permisionCreate'></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>8</td>
                                                                    <td>User</td>
                                                                    <td><input type="checkbox" name="permission[]" value="user-view" class='permission permisionCreate'></td>
                                                                    <td><input type="checkbox" name="permission[]" value="user-create" class='permission permisionCreate'></td>
                                                                    <td><input type="checkbox" name="permission[]" value="user-edit" class='permission permisionCreate'></td>
                                                                    <td><input type="checkbox" name="permission[]" value="user-delete" class='permission permisionCreate'></td>
                                                                    <td><input type="checkbox" name="permission[]" value="user-upload" class='permission permisionCreate'></td>
                                                                    <td><input type="checkbox" name="permission[]" value="user-download" class='permission permisionCreate'></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                {{-- FORM --}}
                                                <div class="text-center pt-15">
                                                    <button type="reset" class="btn btn-light me-3" data-kt-users-modal-action="cancel">Reset</button>
                                                    <button type="submit" id="submitBtn" class="btn btn-primary" data-kt-users-modal-action="submit">
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
                        <table class="table align-middle table-row-dashed fs-6 gy-5" id="service_table">
                            <!--begin::Table head-->
                            <thead>
                                <!--begin::Table row-->
                                <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                    <th class="min-w-125px">S.no</th>
                                    <th class="min-w-125px">Name</th>
                                    <th class="text-end min-w-100px">Actions</th>
                                </tr>
                                <!--end::Table row-->
                            </thead>
                            <!--end::Table head-->
                            <!--begin::Table body-->
                            <tbody class="text-gray-600 fw-semibold">
                                <!--begin::Table row-->
                                @foreach($models as $key=>$d)
                                <tr>
                                    <!--begin::Checkbox-->

                                    <!--end::Checkbox-->
                                    <!--begin::User=-->
                                    <td class="d-flex align-items-center">
                                        {{$key+1}}
                                    </td>

                                    <td>{{$d['name']}}</td>
                                    <td class="text-end">
                                        <a href="#" class="btn btn-light btn-active-light-primary btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions

                                            <span class="svg-icon svg-icon-5 m-0">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="currentColor" />
                                                </svg>
                                            </span>
                                        </a>
                                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">

                                            @if(auth()->user()->is_super_admin ==1 ||auth()->user()->can('role-edit'))
                                            <div class="menu-item px-3">
                                                <a href="#" class="menu-link px-3" data-bs-toggle="modal" data-bs-target="#kt_modal_add_customer<?php echo $d['id']; ?>">Edit</a>
                                            </div>
                                            @endif

                                            @if(auth()->user()->is_super_admin ==1 ||auth()->user()->can('role-delete'))
                                            <div class="menu-item px-3">
                                                <a href="javascript:void(0);" class="menu-link px-3" onclick="delete_item(<?php echo $d['id']; ?>);">Delete</a>
                                            </div>
                                            @endif
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
@foreach($models as $key=>$d)
<div class="modal fade" id="kt_modal_add_customer<?php echo $d['id']; ?>" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-750px">
        <!--begin::Modal content-->
        <div class="modal-content">

            <!--begin::Modal header-->
            <div class="modal-header" id="kt_modal_add_user_header">
                <!--begin::Modal title-->
                <h2 class="fw-bold">Edit</h2>
                <!--end::Modal title-->
                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-icon-danger" data-bs-dismiss="modal" onclick=" document.location.reload();">
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

                <form id="department_form1" method="post" action="{{url('roles')}}">
                    @csrf
                    <input type="hidden" class="editid" name="id" value="{{$d['id']}}">
                    @php $rolem = Spatie\Permission\Models\Role::findorFail($d['id']);
                    $roleP =json_decode($rolem->permissions);
                    $allroles = [];

                    @endphp
                    @foreach($roleP as $roleP1)
                    @php
                    $s1=$roleP1->name;
                    array_push($allroles,$s1);
                    @endphp
                    @endforeach

                    <!--end::Input group-->

                    <div class="row g-9 mb-7">
                        <!--begin::Col-->
                        <div class="col-md-12 fv-row">
                            <!--begin::Label-->
                            <label class="required fs-6 fw-semibold mb-2">Name</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input class="form-control form-control-solid roleName" placeholder="Enter Privilage Name" name="name" value="{{$d['name']}}" fieldData="{{$d['id']}}" />
                            <!--end::Input-->
                            <p id="roleNameAlert" class="notifyAlert"></p>
                            <p id="roleNameaddAlert" class="notifyAlert"></p>
                        </div>
                        <!--end::Col-->
                    </div>
                    <div class="fv-row mb-15">
                        <!--begin::Wrapper-->
                        <div class="d-flex flex-stack">
                            <!--begin::Label-->
                            <div class="me-5">
                                <label class="required fs-6 fw-semibold">Authority</label>
                            </div>
                            <!--end::Label-->
                            <!--begin::Checkboxes-->
                            <div class="d-flex">
                                <!--begin::Checkbox-->
                                <label class="form-radio form-radio-custom form-radio-solid me-6">
                                    <!--begin::Input-->
                                    <input class="form-radio-input h-20px w-20px authority_type" type="radio" value="1" name="authority_type" <?php echo ($d['authority_type'] == 1) ? "checked" : "" ?> />
                                    <!--end::Input-->
                                    <!--begin::Label-->
                                    <span class="form-radio-label fw-semibold">Admin/HOD</span>
                                    <!--end::Label-->
                                </label>
                                <!--end::Checkbox-->
                                <!--begin::Checkbox-->
                                <label class="form-radio form-radio-custom form-radio-solid">
                                    <!--begin::Input-->
                                    <input class="form-radio-input h-20px w-20px authority_type" type="radio" value="2" name="authority_type" <?php echo ($d['authority_type'] == 2) ? "checked" : "" ?> />
                                    <!--end::Input-->
                                    <!--begin::Label-->
                                    <span class="form-radio-label fw-semibold">Employee</span>
                                    <!--end::Label-->
                                </label>
                                <!--end::Checkbox-->
                            </div>
                            <!--end::Checkboxes-->
                        </div>
                        <!--begin::Wrapper-->
                    </div>
                    <label for="permissions" class="form-label">Assign Permissions</label>
                    <div class="col-md-12 col-sm-12">
                        <button type="button" class="accordion">Permission</button>

                        <div class="panel">

                            <table class="table table-striped">
                                <thead>
                                    <th scope="col" width="1%">S.No</th>
                                    <th scope="col" width="30%">Screen Name</th>
                                    <th scope="col" width="10%">View</th>
                                    <th scope="col" width="10%">Create</th>
                                    <th scope="col" width="10%">Edit </th>
                                    <th scope="col" width="10%">Delete</th>
                                    <th scope="col" width="10%">Upload </th>
                                    <th scope="col" width="15%">Download</th>

                                </thead>

                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>Department</td>
                                        <td><input type="checkbox" name="permission[]" value="department-view" class='permission permissionEdit' <?php echo (in_array("department-view", $allroles) ? "checked" : ''); ?>></td>
                                        <td><input type="checkbox" name="permission[]" value="department-create" class='permission permissionEdit' <?php echo (in_array("department-create", $allroles) ? "checked" : ''); ?>></td>
                                        <td><input type="checkbox" name="permission[]" value="department-edit" class='permission permissionEdit' <?php echo (in_array("department-edit", $allroles) ? "checked" : ''); ?>></td>
                                        <td><input type="checkbox" name="permission[]" value="department-delete" class='permission permissionEdit' <?php echo (in_array("department-delete", $allroles) ? "checked" : ''); ?>></td>
                                        <td><input type="checkbox" name="permission[]" value="department-upload" class='permission permissionEdit' <?php echo (in_array("department-upload", $allroles) ? "checked" : ''); ?>></td>
                                        <td><input type="checkbox" name="permission[]" value="department-download" class='permission permissionEdit' <?php echo (in_array("department-download", $allroles) ? "checked" : ''); ?>></td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>Designation</td>
                                        <td><input type="checkbox" name="permission[]" value="designation-view" class='permission permissionEdit' <?php echo (in_array("designation-view", $allroles) ? "checked" : ''); ?>></td>
                                        <td><input type="checkbox" name="permission[]" value="designation-create" class='permission permissionEdit' <?php echo (in_array("designation-create", $allroles) ? "checked" : ''); ?>></td>
                                        <td><input type="checkbox" name="permission[]" value="designation-edit" class='permission permissionEdit' <?php echo (in_array("designation-edit", $allroles) ? "checked" : ''); ?>></td>
                                        <td><input type="checkbox" name="permission[]" value="designation-delete" class='permission permissionEdit' <?php echo (in_array("designation-delete", $allroles) ? "checked" : ''); ?>></td>
                                        <td><input type="checkbox" name="permission[]" value="designation-upload" class='permission permissionEdit' <?php echo (in_array("designation-upload", $allroles) ? "checked" : ''); ?>></td>
                                        <td><input type="checkbox" name="permission[]" value="designation-download" class='permission permissionEdit' <?php echo (in_array("designation-download", $allroles) ? "checked" : ''); ?>></td>

                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td>Document Type</td>
                                        <td><input type="checkbox" name="permission[]" value="document-type-view" class='permission permissionEdit' <?php echo (in_array("document-type-view", $allroles) ? "checked" : ''); ?>></td>
                                        <td><input type="checkbox" name="permission[]" value="document-type-create" class='permission permissionEdit' <?php echo (in_array("document-type-create", $allroles) ? "checked" : ''); ?>></td>
                                        <td><input type="checkbox" name="permission[]" value="document-type-edit" class='permission permissionEdit' <?php echo (in_array("document-type-edit", $allroles) ? "checked" : ''); ?>></td>
                                        <td><input type="checkbox" name="permission[]" value="document-type-delete" class='permission permissionEdit' <?php echo (in_array("document-type-delete", $allroles) ? "checked" : ''); ?>></td>
                                        <td><input type="checkbox" name="permission[]" value="document-type-upload" class='permission permissionEdit' <?php echo (in_array("document-type-upload", $allroles) ? "checked" : ''); ?>></td>
                                        <td><input type="checkbox" name="permission[]" value="document-type-download" class='permission permissionEdit' <?php echo (in_array("document-type-download", $allroles) ? "checked" : ''); ?>></td>

                                    </tr>
                                    <tr>
                                        <td>4</td>
                                        <td>Employee</td>
                                        <td><input type="checkbox" name="permission[]" value="employee-view" class='permission permissionEdit' <?php echo (in_array("employee-view", $allroles) ? "checked" : ''); ?>></td>
                                        <td><input type="checkbox" name="permission[]" value="employee-create" class='permission permissionEdit' <?php echo (in_array("employee-create", $allroles) ? "checked" : ''); ?>></td>
                                        <td><input type="checkbox" name="permission[]" value="employee-edit" class='permission permissionEdit' <?php echo (in_array("employee-edit", $allroles) ? "checked" : ''); ?>></td>
                                        <td><input type="checkbox" name="permission[]" value="employee-delete" class='permission permissionEdit' <?php echo (in_array("employee-delete", $allroles) ? "checked" : ''); ?>></td>
                                        <td><input type="checkbox" name="permission[]" value="employee-upload" class='permission permissionEdit' <?php echo (in_array("employee-upload", $allroles) ? "checked" : ''); ?>></td>
                                        <td><input type="checkbox" name="permission[]" value="employee-download" class='permission permissionEdit' <?php echo (in_array("employee-download", $allroles) ? "checked" : ''); ?>></td>

                                    </tr>
                                    <tr>
                                        <td>5</td>
                                        <td>Projects</td>
                                        <td><input type="checkbox" name="permission[]" value="project-view" class='permission permissionEdit' <?php echo (in_array("project-view", $allroles) ? "checked" : ''); ?>></td>
                                        <td><input type="checkbox" name="permission[]" value="project-create" class='permission permissionEdit' <?php echo (in_array("project-create", $allroles) ? "checked" : ''); ?>></td>
                                        <td><input type="checkbox" name="permission[]" value="project-edit" class='permission permissionEdit' <?php echo (in_array("project-edit", $allroles) ? "checked" : ''); ?>></td>
                                        <td><input type="checkbox" name="permission[]" value="project-delete" class='permission permissionEdit' <?php echo (in_array("project-delete", $allroles) ? "checked" : ''); ?>></td>
                                        <td><input type="checkbox" name="permission[]" value="project-upload" class='permission permissionEdit' <?php echo (in_array("project-upload", $allroles) ? "checked" : ''); ?>></td>
                                        <td><input type="checkbox" name="permission[]" value="project-download" class='permission permissionEdit' <?php echo (in_array("project-download", $allroles) ? "checked" : ''); ?>></td>

                                    </tr>
                                    <tr>
                                        <td>6</td>
                                        <td>WorkFlow</td>
                                        <td><input type="checkbox" name="permission[]" value="workflow-view" class='permission permissionEdit' <?php echo (in_array("workflow-view", $allroles) ? "checked" : ''); ?>></td>
                                        <td><input type="checkbox" name="permission[]" value="workflow-create" class='permission permissionEdit' <?php echo (in_array("workflow-create", $allroles) ? "checked" : ''); ?>></td>
                                        <td><input type="checkbox" name="permission[]" value="workflow-edit" class='permission permissionEdit' <?php echo (in_array("workflow-edit", $allroles) ? "checked" : ''); ?>></td>
                                        <td><input type="checkbox" name="permission[]" value="workflow-delete" class='permission permissionEdit' <?php echo (in_array("workflow-delete", $allroles) ? "checked" : ''); ?>></td>
                                        <td><input type="checkbox" name="permission[]" value="workflow-upload" class='permission permissionEdit' <?php echo (in_array("workflow-upload", $allroles) ? "checked" : ''); ?>></td>
                                        <td><input type="checkbox" name="permission[]" value="workflow-download" class='permission permissionEdit' <?php echo (in_array("workflow-download", $allroles) ? "checked" : ''); ?>></td>

                                    </tr>
                                    <tr>
                                        <td>7</td>
                                        <td>Role</td>
                                        <td><input type="checkbox" name="permission[]" value="role-view" class='permission permissionEdit' <?php echo (in_array("role-view", $allroles) ? "checked" : ''); ?>></td>
                                        <td><input type="checkbox" name="permission[]" value="role-create" class='permission permissionEdit' <?php echo (in_array("role-create", $allroles) ? "checked" : ''); ?>></td>
                                        <td><input type="checkbox" name="permission[]" value="role-edit" class='permission permissionEdit' <?php echo (in_array("role-edit", $allroles) ? "checked" : ''); ?>></td>
                                        <td><input type="checkbox" name="permission[]" value="role-delete" class='permission permissionEdit' <?php echo (in_array("role-delete", $allroles) ? "checked" : ''); ?>></td>
                                        <td><input type="checkbox" name="permission[]" value="role-upload" class='permission permissionEdit' <?php echo (in_array("role-upload", $allroles) ? "checked" : ''); ?>></td>
                                        <td><input type="checkbox" name="permission[]" value="role-download" class='permission permissionEdit' <?php echo (in_array("role-download", $allroles) ? "checked" : ''); ?>></td>

                                    </tr>
                                    <tr>
                                        <td>8</td>
                                        <td>User</td>
                                        <td><input type="checkbox" name="permission[]" value="user-view" class='permission permissionEdit' <?php echo (in_array("user-view", $allroles) ? "checked" : ''); ?>></td>
                                        <td><input type="checkbox" name="permission[]" value="user-create" class='permission permissionEdit' <?php echo (in_array("user-create", $allroles) ? "checked" : ''); ?>></td>
                                        <td><input type="checkbox" name="permission[]" value="user-edit" class='permission permissionEdit' <?php echo (in_array("user-edit", $allroles) ? "checked" : ''); ?>></td>
                                        <td><input type="checkbox" name="permission[]" value="user-delete" class='permission permissionEdit' <?php echo (in_array("user-delete", $allroles) ? "checked" : ''); ?>></td>
                                        <td><input type="checkbox" name="permission[]" value="user-upload" class='permission permissionEdit' <?php echo (in_array("user-upload", $allroles) ? "checked" : ''); ?>></td>
                                        <td><input type="checkbox" name="permission[]" value="user-download" class='permission permissionEdit' <?php echo (in_array("user-download", $allroles) ? "checked" : ''); ?>></td>

                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    {{-- FORM --}}
                    <div class="text-center pt-15">
                        <button type="reset" class="btn btn-light-danger me-3" data-bs-dismiss="modal" onclick=" document.location.reload();">Cancel</button>
                        <button type="submit" id="updateBtn" class="btn btn-primary" data-kt-users-modal-action="submit">
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
<script>
    $(document).ready(function() {
        var acc = document.getElementsByClassName("accordion");
        var i;

        for (i = 0; i < acc.length; i++) {
            acc[i].addEventListener("click", function() {
                this.classList.toggle("active");
                var panel = this.nextElementSibling;
                if (panel.style.maxHeight) {
                    panel.style.maxHeight = null;
                } else {
                    panel.style.maxHeight = panel.scrollHeight + "px";
                }
            });
        }

    });

    setTimeout(function() {
        $('.alert').fadeOut('fast');
    }, 5000);
    $(document).ready(function() {
        $('[name="all_permission"]').on('click', function() {

            if ($(this).is(':checked')) {
                $.each($('.permission'), function() {
                    $(this).prop('checked', true);
                });
            } else {
                $.each($('.permission'), function() {
                    $(this).prop('checked', false);
                });
            }

        });

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
                    url: "{{url('roles')}}" + "/" + id,
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
                        'Department has been deleted.',
                        'success'
                    );

                }
            }
        });
    }

    $(document).on('click', '.checkAll', function() {
        if ($(this).prop('checked') == true) {
            $('.permisionCreate').each(function() {
                this.checked = true;
            });
        } else {
            $('.permisionCreate').each(function() {
                this.checked = false;
            });
        }


    });
    $(document).on('click', '.permission', function() {
        $(this).attr('checked', false);
        var a = document.forms["department_form"];
        var x = a.querySelectorAll('input[name="permission[]"]:checked');       
        if (x.length == 48) {
            $('.checkAll').prop('checked', true);
        }else{
            $('.checkAll').prop('checked', false);
        }

    });
    $(document).on('click', '.permissionEdit', function() {

        var a = document.forms["department_form1"];
        var x = a.querySelectorAll('input[type="checkbox"]:checked');

    });
    $(document).on('blur', '.roleName', function() {
        console.log($(this).attr('fieldData'));
        

        $.ajax({
            url: "{{ route('roleNameValidation') }}",
            type: 'ajax',
            method: 'post',
            data: {
                "_token": "{{ csrf_token() }}",
                name: $(this).val(),
                id: $(this).attr('fieldData'),
            },
            success: function(data) {
                var alertName = 'roleNameAlert';
                console.log(data.response);
                console.log(alertName);

                if (data.response == false) {
                    $('#submitBtn').attr('disabled', true);
                    $('#updateBtn').attr('disabled', true);

                    document.getElementById(alertName).style.display = "block";
                    document.getElementById(alertName).style.color = "red";
                    document.getElementById(alertName).innerHTML = 'Role Is Exists*';
                    
                    document.getElementById('roleNameAddAlert').style.display = "block";
                    document.getElementById('roleNameAddAlert').style.color = "red";
                    document.getElementById('roleNameAddAlert').innerHTML = 'Role Is Exists*';
                    return false;
                }
                document.getElementById(alertName).style.display = "none";
                $('#submitBtn').attr('disabled', false);
                return true;


            },
            error: function() {
                $("#otp_error").text("Update Error");
            }

        });

    });
</script>
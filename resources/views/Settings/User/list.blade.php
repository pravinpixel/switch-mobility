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
                    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">User</h1>
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
                        <li class="breadcrumb-item text-muted">Users</li>
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
                                @if(auth()->user()->is_super_admin ==1 ||auth()->user()->can('user-create'))
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_add_user">
                                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr075.svg-->
                                    <span class="svg-icon svg-icon-2">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1" transform="rotate(-90 11.364 20.364)" fill="currentColor" />
                                            <rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="currentColor" />
                                        </svg>
                                    </span>
                                    <!--end::Svg Icon-->Add</button>
                                @endif
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
                                <div class="modal-dialog modal-dialog-centered mw-650px">
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

                                            <form id="department_form" class="form" method="post" action="{{url('users')}}">
                                                @csrf

                                                <div class="row g-9 mb-7">
                                                    <!--begin::Label-->
                                                    <label class="required fs-6 fw-semibold mb-2">Enter SAP-ID Or Name</label>
                                                    <!--end::Label-->
                                                    <!--begin::Input-->
                                                    <select class="form-control form-control initiator_id" name="initiator_id" required>
                                                        <option value="">Select</option>
                                                        @foreach ($employees as $emp)
                                                        <option value="<?php echo $emp['id']; ?>"><?php echo $emp['first_name'] . ' ' . $emp['last_name'] . '(' . $emp['sap_id'] . ')'; ?></option>
                                                        @endforeach
                                                    </select>
                                                    <!--end::Input-->
                                                </div>

                                                <div class="row g-9 mb-7">
                                                    <!--begin::Col-->
                                                    <div class="col-md-12 fv-row">
                                                        <!--begin::Label-->
                                                        <label class="required fs-6 fw-semibold mb-2">Mobile No</label>
                                                        <!--end::Label-->
                                                        <!--begin::Input-->
                                                        <input class="form-control form-control-solid mobile" name="mobile" disabled required />
                                                        <!--end::Input-->
                                                    </div>
                                                    <!--end::Col-->

                                                </div>
                                                <div class="row g-9 mb-7">
                                                    <!--begin::Col-->
                                                    <div class="col-md-12 fv-row">
                                                        <!--begin::Label-->
                                                        <label class="required fs-6 fw-semibold mb-2">Email</label>
                                                        <!--end::Label-->
                                                        <!--begin::Input-->
                                                        <input class="form-control form-control-solid email" name="email" disabled required />
                                                        <!--end::Input-->
                                                    </div>
                                                    <!--end::Col-->

                                                </div>
                                                <div class="row g-9 mb-7">
                                                    <!--begin::Col-->
                                                    <div class="col-md-12 fv-row">
                                                        <!--begin::Label-->
                                                        <label class="required fs-6 fw-semibold mb-2">Privillage</label>
                                                        <!--end::Label-->
                                                        <!--begin::Input-->
                                                        <select class="form-control form-control roles" name="roles" required>
                                                            <option value="">Select</option>
                                                            @foreach ($roles as $role)
                                                            <option value="<?php echo $role['id']; ?>"><?php echo $role['name']; ?></option>
                                                            @endforeach
                                                        </select>
                                                        <!--end::Input-->
                                                    </div>
                                                </div>

                                                <div class="row g-9 mb-7">
                                                    <!--begin::Col-->
                                                    <div class="col-md-12 fv-row">
                                                        <!--begin::Label-->
                                                        <label class="required fs-6 fw-semibold mb-2">Password</label>
                                                        <!--end::Label-->
                                                        <!--begin::Input-->
                                                        <input class="form-control form-control" placeholder="Enter Password" name="password" required />
                                                        <!--end::Input-->
                                                    </div>
                                                    <!--end::Col-->

                                                </div>
                                                <div class="row g-9 mb-7">
                                                    <!--begin::Col-->
                                                    <div class="col-md-12 fv-row">
                                                        <!--begin::Label-->
                                                        <label class="required fs-6 fw-semibold mb-2">Confirm Password</label>
                                                        <!--end::Label-->
                                                        <!--begin::Input-->
                                                        <input class="form-control form-control" placeholder="Enter confirm password" name="cpassword" required />
                                                        <!--end::Input-->
                                                    </div>
                                                    <!--end::Col-->

                                                </div>

                                                {{-- FORM --}}
                                                <div class="text-center pt-15">
                                                    <button type="reset" class="btn btn-light me-3" data-kt-users-modal-action="cancel">Reset</button>
                                                    <button type="submit" class="btn btn-primary submit" data-kt-users-modal-action="submit">
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

                                            @if(auth()->user()->is_super_admin ==1 ||auth()->user()->can('user-edit'))
                                            <div class="menu-item px-3">
                                                <a href="#" class="menu-link px-3" data-bs-toggle="modal" data-bs-target="#kt_modal_add_customer<?php echo $d['id']; ?>">Edit</a>
                                            </div>
                                            @endif
                                            @if(auth()->user()->is_super_admin ==1 ||auth()->user()->can('user-delete'))
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
<div class="modal fade crudForm" id="kt_modal_add_customer<?php echo $d['id']; ?>" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-650px">
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

                <form id="department_form1" method="post" action="{{url('users')}}">
                    @csrf
                    <?php

                    $userModel = \App\Models\User::select('users.id', 'employees.id as empId', 'employees.mobile', 'sap_id', 'first_name')->with('roles')->leftjoin('employees', 'employees.id', '=', 'users.emp_id')->findOrFail($d['id']);
                    $userRole = $userModel['roles'];

                    $roleId = $userModel->roles->pluck("id")->first();

                    ?>

                    <input type="hidden" name="id" value="{{$d['id']}}">
                    <!--end::Input group-->
                    <div class="row g-9 mb-7">
                        <!--begin::Col-->
                        <div class="col-md-12 fv-row">
                            <!--begin::Label-->
                            <label class="required fs-6 fw-semibold mb-2">Name</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input class="form-control form-control-solid" placeholder="Enter Privillage Name" name="name" value="{{$d['name']}}" disabled />
                            <!--end::Input-->
                        </div>
                        <!--end::Col-->
                    </div>
                    <div class="row g-9 mb-7">
                        <!--begin::Col-->
                        <div class="col-md-12 fv-row">
                            <!--begin::Label-->
                            <label class="required fs-6 fw-semibold mb-2">SAP-ID</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input class="form-control form-control-solid sapId" placeholder="Enter Sap-Id 1" name="sapId" id="sapId" value="{{$userModel['sap_id']}}" disabled />
                            <input type="hidden" name="empId" value="{{$userModel['empId']}}">
                            <!--end::Input-->
                        </div>
                        <!--end::Col-->

                    </div>
                   

                    <div class="row g-9 mb-7">
                        <!--begin::Col-->
                        <div class="col-md-12 fv-row">
                            <!--begin::Label-->
                            <label class="required fs-6 fw-semibold mb-2">Privillage</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <select class="form-control form-control" name="roles" required>
                                <option value="">Select</option>
                                @foreach ($roles as $role)
                                <option value="<?php echo $role['id']; ?>" <?php echo ($role['id'] == $roleId) ? "selected" : ""; ?>><?php echo $role['name']; ?></option>
                                @endforeach
                            </select>
                            <!--end::Input-->
                        </div>
                    </div>

                    <div class="row g-9 mb-7">
                        <!--begin::Col-->
                        <div class="col-md-12 fv-row">
                            <!--begin::Label-->
                            <label class="required fs-6 fw-semibold mb-2">Password</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input class="form-control form-control" placeholder="Enter Password" name="password" />
                            <!--end::Input-->
                        </div>
                        <!--end::Col-->

                    </div>

                    {{-- FORM --}}
                    <div class="text-center pt-15">
                        <button type="reset" class="btn btn-light-danger me-3" data-bs-dismiss="modal" onclick=" document.location.reload();">Cancel</button>
                        <button type="submit" class="btn btn-primary submit" data-kt-users-modal-action="submit">
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
        // on form submit
        $(".initiator_id").select2({
            dropdownParent: $("#kt_modal_add_user")
        });

       
       
        $("#department_form1").on('submit', function() {
            // to each unchecked checkbox
            $(this).find('input[type=checkbox]:not(:checked)').prop('checked', true).val(0);
        })
        $(".initiator_id").on('change', function() {
            var employeeId = $(this).val();

            $('.submit').prop('disabled', true);

            if (employeeId) {
                $.ajax({
                    url: "{{ route('getEmployeeDetailByParams') }}",
                    type: 'ajax',
                    method: 'post',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        fieldname: 'EmpId',
                        fieldData: employeeId,
                    },
                    success: function(result) {
                        var data = JSON.parse(result);

                        console.log(data);
                        $(".name,.mobile,.email").val("");
                        if (data) {
                            if (data.user) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'This Sap-Id AllReady In Users!',
                                    footer: ''
                                });
                                $('.submit').prop('disabled', true);
                                $(".sapId,.name,.mobile,.email").val("");
                            } else {
                                $('.submit').prop('disabled', false);
                                var name = data.first_name + " " + data.last_name;
                                $(".name").val(name);

                                $(".mobile").val(data.mobile);
                                $(".email").val(data.email);
                            }
                        } // $(".designation").val(data[0].designation_name);
                    }
                });
            }
        });
    });

    $("#other").click(function() {
        $("#target").submit();
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
                    url: "{{url('users')}}" + "/" + id,
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
</script>
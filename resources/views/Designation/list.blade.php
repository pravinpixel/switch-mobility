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
                    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Designation</h1>
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
                        <li class="breadcrumb-item text-muted">Designation</li>
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
                    <div class="card-header border-0 pt-6 add-button-datatable">

                        <div class="card-title">

                        </div>

                        <div class="card-toolbar">
                            <!--begin::Toolbar-->
                            <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                                <!--begin::Filter-->
                                @if(auth()->user()->is_super_admin ==1 ||auth()->user()->can('designation-create'))
                                <!--begin::Add user-->
                                <a href="{{url('designation/create')}}">
                                    <button type="button" class="btn switchPrimaryBtn" data-bs-toggle="modal" data-bs-target="#kt_modal_add_user">
                                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr075.svg-->
                                        {{-- <span class="svg-icon svg-icon-2">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1" transform="rotate(-90 11.364 20.364)" fill="currentColor" />
                                                <rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="currentColor" />
                                            </svg>
                                        </span> --}}
                                        <!--end::Svg Icon-->+ Add</button>
                                </a>
                                @endif
                                <!--end::Add user-->
                            </div>



                        </div>

                    </div>
                    <!--end::Card header-->
                    <!--begin::Card body-->
                    <div class="card-body p-3">
                        <div class="card-title" style="display:none">
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
                                <input type="text" class="form-control form-control-solid w-250px ps-14 search" placeholder="Search" />
                            </div>
                            <!--end::Search-->
                        </div>
                        <!--begin::Table-->
                        <table class="table align-middle table-row-bordered fs-6 gy-5" id="service_table">
                            <!--begin::Table head-->
                            <thead>
                                <!--begin::Table row-->
                                <tr class="text-start align-middle text-muted fw-bold fs-7 text-uppercase gs-0">

                                    <th class="min-w-125px">Designation</th>
                                    <th class="min-w-125px">Description</th>
                                    <th class="min-w-50px">Status</th>
                                    <th class="min-w-50px">Actions</th>

                                </tr>
                                <!--end::Table row-->
                            </thead>
                            <!--end::Table head-->
                            <!--begin::Table body-->
                            <tbody class="text-gray-600 fw-semibold">
                                <!--begin::Table row-->
                                @foreach($designation as $key=>$d)
                                <tr>
                                    <!--begin::Checkbox-->

                                    <!--end::Checkbox-->
                                    <!--begin::User=-->


                                    <td>{{$d['name']}}</td>
                                    <td>{{$d['description']}}</td>
                                    <td>
                                        <label class="switch">
                                            <input type="checkbox" data-id="{{ $d['id'] }}" value="" class="status" <?php echo $d['is_active'] == 1 ? 'checked' : ''; ?>>
                                            <span class="slider round"></span>
                                        </label>
                                    </td>
                                    <td>
                                        <div class="d-flex my-3 ms-9">
                                            <!--begin::Edit-->
                                            @if (auth()->user()->is_super_admin == 1 ||
                                            auth()->user()->can('designation-edit'))
                                            <a class="editPage" style="display:inline;cursor: pointer;" id="{{ $d['id'] }}" title="Edit Designation"><i class="fa-solid fa-pen" style="color:orange"></i></a>

                                            @endif
                                            @if (auth()->user()->is_super_admin == 1 ||
                                            auth()->user()->can('designation-delete'))
                                            <div onclick="delete_item(<?php echo $d['id']; ?>);" style="display:inline;cursor: pointer; margin-left: 10px;" id="{{ $d['id'] }}" class="" title="Delete Designation"><i class="fa-solid fa-trash" style="color:red"></i></div>
                                            @endif

                                            <!--end::More-->
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



@endsection
<script data-require="jquery@*" data-semver="3.0.0" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.js"></script>
<script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.js"></script>
<script>
    $(document).on('click', '.editPage', function() {
        var id = $(this).attr('id');
        var url = "{{route('designationEdit')}}";
        var form = $('<form action="' + url + '" method="post">' +
            ' {{ csrf_field() }} <input type="hidden" name="id" value="' + id + '" />' +
            '</form>');
        $('body').append(form);
        form.submit();
 
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
                    url: "{{url('designation')}}" + "/" + id,
                    type: 'ajax',
                    method: 'delete',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        id: id,
                    },
                    success: function(result) {
                        if (result.message == "Failed") {
                            Swal.fire(
                                'Deleted!',
                                'Reference Datas Are Found,deleted Failed.',
                                'error'
                            );
                        } else {
                            Swal.fire(
                                'Deleted!',
                                'Designation has been deleted.',
                                'success'
                            );
                            getListData();
                        }
                    }
                });

            }
        });
    }
    $(document).on('change', '.status', function() {

        var isSuperAdmin = "{{ auth()->user()->is_super_admin }}";
        var isAuthorityEdit = "{{ auth()->user()->can('designation-edit') }}";
        var isAuthorityDelete = "{{ auth()->user()->can('designation-delete') }}";
        var table = $('#service_table').DataTable();

        var chk = $(this);
        var id = $(this).attr('data-id');
        var status = $(this).prop('checked') == true ? 1 : 0;
        var activeStatus = "";
        if (status) {
            activeStatus = "Active";
        } else {
            activeStatus = "InActive";
        }
        console.log(status);

        Swal.fire({
            title: 'Change Status',
            text: "Are You Sure To " + activeStatus + " This Designation!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3565ed',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Change it!'
        }).then(isConfirmed => {
            if (isConfirmed.value) {
                $.ajax({
                    url: "{{ url('changedesignationActiveStatus') }}",
                    type: 'ajax',
                    method: 'post',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        id: id,
                        status: status,
                    },
                    success: function(result) {
                        var resData = result.data;
                        console.log(resData);
                        if (resData.message == "Success") {
                            Swal.fire(
                                'Status!',
                                resData.data,
                                'success'
                            );
                            getListData();
                        } else {
                            if (status == 1) {
                                chk.prop('checked', false);

                            } else {

                                chk.prop('checked', true).attr('checked', 'checked');
                            }
                            Swal.fire(
                                'Status!',
                                resData.data,
                                'error'
                            );
                        }
                    }
                });

            } else {
                if (status == 1) {
                    chk.prop('checked', false);

                } else {

                    chk.prop('checked', true).attr('checked', 'checked');
                }
            }
        });
    });

    function getListData() {
        var isSuperAdmin = "{{ auth()->user()->is_super_admin }}";
        var isAuthorityEdit = "{{ auth()->user()->can('designation-edit') }}";
        var isAuthorityDelete = "{{ auth()->user()->can('designation-delete') }}";

        var table = $('#service_table').DataTable();

        $.ajax({
            url: "{{ url('getDesignationListData') }}",
            type: 'ajax',
            method: 'get',
            data: {
                "_token": "{{ csrf_token() }}"
            },
            success: function(result) {
                table.clear().draw();
                $.each(result.data, function(key, val) {


                    var name = val.name;
                    var description = val.description;
                    var id = val.id;
                    var statusRes = (val.is_active == 1) ? "checked" : "";
                    var statusBtn = '<label class="switch">';
                    statusBtn += '<input type="checkbox" data-id="' + id + '" value="" class="status" ' + statusRes + '>';
                    statusBtn += '<span class="slider round"></span></label>';
                    var editBtn = "";
                    var deleteBtn = "";
                    var editurl = '{{ route("designation.edit", ":id") }}';
                    editurl = editurl.replace(':id', id);
                    if (isSuperAdmin || isAuthorityEdit) {
                        var editBtn = (
                            '<a href="' + editurl + '" class="btn btn-icon btn-active-light-primary w-30px h-30px me-3"><i class="fa-solid fa-pen" style="color:orange"></i></a>'
                        );
                    }

                    if (isSuperAdmin || isAuthorityDelete) {
                        var deleteBtn = '<div onclick="delete_item(' + id + ');" style="display:inline;cursor: pointer; margin-left: 10px;" id="' + id + '" class="" title="Delete Department"><i class="fa-solid fa-trash" style="color:red"></i></div>';

                    }
                    var actionBtn = editBtn + deleteBtn;
                    table.row.add([name, description, statusBtn, actionBtn]).draw();
                });
            }
        });
    }
</script>
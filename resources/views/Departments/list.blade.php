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
                    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Department</h1>
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
                        <li class="breadcrumb-item text-muted">Departments</li>
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
                                @if(auth()->user()->is_super_admin ==1 ||auth()->user()->can('department-create'))
                                <!--begin::Add user-->
                                <a href="{{url('department/create')}}">
                                    <button type="button" class="btn switchPrimaryBtn">+ Add</button></a>
                                @endif
                                <!--end::Add user-->
                            </div>
                            <!--end::Toolbar-->
                            <!--begin::Group actions-->

                            <!--end::Group actions-->


                        </div>

                    </div>
                    <!--end::Card header-->
                    <!--begin::Card body-->
                    <div class="card-body py-4">
                        <!--begin::Card title-->
                        <div class="card-title">
                            <!--begin::Search-->
                            <div class="d-flex align-items-center position-relative my-1">
                                <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg
                                <span class="svg-icon svg-icon-1 position-absolute ms-6">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor" />
                                        <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="currentColor" />
                                    </svg>
                                </span>-->
                                <!--end::Svg Icon
                                <input type="text" class="form-control form-control-solid w-250px ps-14 deptSearch" placeholder="Search" />
                          -->
                            </div>
                            <!--end::Search-->
                        </div>
                        <!--begin::Card title-->
                        <!--begin::Table-->
                        <table class="table" id="service_table">
                            <!--begin::Table head-->
                            <thead>
                                <!--begin::Table row-->
                                <tr class="fw-bold fs-7 text-uppercase gs-0">


                                    <th class="text-left ">Department Name</th>
                                    <th class="text-center" >Description</th>
                                    <th class="text-center" index="1">Status</th>

                                    <th class="text-center">Actions</th>
                                </tr>
                                <!--end::Table row-->
                            </thead>
                            <!--end::Table head-->
                            <!--begin::Table body-->
                            <tbody class="text-gray-600 fw-semibold" id="tableContent">
                                <!--begin::Table row-->
                                @foreach($departments as $key=>$d)
                                <tr height="100px">
                                    <!--begin::Checkbox-->

                                    <!--end::Checkbox-->
                                    <!--begin::User=-->


                                    <td style="text-align: left!important">{{$d['name']}}</td>
                                    <td class="text-left" style="max-width:300px !important;">{{$d['description']}}</td>
                                    <td class="text-center">

                                        <label class="switch">
                                            <input type="checkbox" data-id="{{ $d['id'] }}" value="" class="status" <?php echo $d['is_active'] == 1 ? 'checked' : ''; ?>>
                                            <span class="slider round"></span>
                                        </label>
                                    </td>
                                    <td class="text-center">
                                        <div class="">
                                            <!--begin::Edit-->
                                            @if (auth()->user()->is_super_admin == 1 ||
                                            auth()->user()->can('department-edit'))
                                            <div style="display:inline;cursor: pointer;" id="{{ $d['id'] }}" class="editDept" title="Edit Department"><i class="fa-solid fa-pen" style="color:orange"></i></div>
                                            @endif
                                            @if (auth()->user()->is_super_admin == 1 ||
                                            auth()->user()->can('department-delete'))
                                            <div onclick="delete_item(<?php echo $d['id']; ?>);" style="display:inline;cursor: pointer; margin-left: 10px;" id="{{ $d['id'] }}" class="" title="Delete Department"><i class="fa-solid fa-trash" style="color:red"></i></div>
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

<script>
    $(document).ready(function() {
        var isSuperAdmin = "{{ auth()->user()->is_super_admin }}";
        var isAuthorityEdit = "{{ auth()->user()->can('department-edit') }}";
        var isAuthorityDelete = "{{ auth()->user()->can('department-delete') }}";
        // $('.deptSearch').on('input', function() {
        //     var searchData = $('.deptSearch').val();
        //     $.ajax({
        //         url: "{{ route('deptSearch') }}",
        //         type: 'ajax',
        //         method: 'post',
        //         data: {
        //             "_token": "{{ csrf_token() }}",
        //             searchData: searchData,
        //         },
        //         success: function(data) {
        //             table.clear().draw();
        //             $.each(data, function(key, val) {
        //                 var sNo = key + 1;
        //                 var id = val.id;
        //                 var dept = val.name;
        //                 var despt = val.description;
        //                 var activeStatus = (val.is_active == 1) ? "checked" : "";
        //                 var editurl = '{{ route("department.edit", ":id") }}';
        //                 editurl = editurl.replace(':id', id);
        //                 var result = (
        //                     '<label class="switch"><input type="checkbox" data-id="' +
        //                     id + '" class="status" ' + activeStatus +
        //                     '>  <span class="slider round"></span></label>');

        //                 var editBtn = '<div class="btn btn-icon btn-active-light-primary w-30px h-30px me-3 editDept" id="' + id + '">';
        //                 editBtn += '<span data-bs-toggle="tooltip" data-bs-trigger="hover" title="Edit">';

        //                 editBtn += '<span class="svg-icon svg-icon-3">';
        //                 editBtn += '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">';
        //                 editBtn += '<path opacity="0.3" d="M21.4 8.35303L19.241 10.511L13.485 4.755L15.643 2.59595C16.0248 2.21423 16.5426 1.99988 17.0825 1.99988C17.6224 1.99988 18.1402 2.21423 18.522 2.59595L21.4 5.474C21.7817 5.85581 21.9962 6.37355 21.9962 6.91345C21.9962 7.45335 21.7817 7.97122 21.4 8.35303ZM3.68699 21.932L9.88699 19.865L4.13099 14.109L2.06399 20.309C1.98815 20.5354 1.97703 20.7787 2.03189 21.0111C2.08674 21.2436 2.2054 21.4561 2.37449 21.6248C2.54359 21.7934 2.75641 21.9115 2.989 21.9658C3.22158 22.0201 3.4647 22.0084 3.69099 21.932H3.68699Z" fill="currentColor" />';
        //                 editBtn += '<path d="M5.574 21.3L3.692 21.928C3.46591 22.0032 3.22334 22.0141 2.99144 21.9594C2.75954 21.9046 2.54744 21.7864 2.3789 21.6179C2.21036 21.4495 2.09202 21.2375 2.03711 21.0056C1.9822 20.7737 1.99289 20.5312 2.06799 20.3051L2.696 18.422L5.574 21.3ZM4.13499 14.105L9.891 19.861L19.245 10.507L13.489 4.75098L4.13499 14.105Z" fill="currentColor" />';
        //                 editBtn += '</svg>';
        //                 editBtn += '</span></span></div>';

        //                 var Action = (editBtn +
        //                     '<a class="btn btn-icon btn-active-light-primary w-30px h-30px me-3" href="javascript:void(0);" class="menu-link px-3" onclick="delete_item(' +
        //                     id +
        //                     ')"><span class="svg-icon svg-icon-3"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z" fill="currentColor" /><path opacity="0.5" d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z" fill="currentColor" /><path opacity="0.5" d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z" fill="currentColor" /></svg></span></a>'
        //                 );
        //                 table.row.add([sNo, dept, despt, result, Action]).draw();
        //             });
        //         },
        //         error: function() {
        //             $("#otp_error").text("Update Error");
        //         }

        //     });


        // });
    });



    function reloaded() {
        window.location.reload();
    }
    $(document).on('click', '.editDept', function() {
        var id = $(this).attr('id');
        var url = "{{route('departmentEdit')}}";
        var form = $('<form action="' + url + '" method="post">' +
            ' {{ csrf_field() }} <input type="hidden" name="id" value="' + id + '" />' +
            '</form>');
        $('body').append(form);
        form.submit();

    })
    $(document).on('click', '.toggleBtn', function() {
        var toggleBtn = $('.toggleBtn');
        var columnIndex = 4;
        var data = $(this).attr('index');

        console.log(data);


        var table = $('#service_table').DataTable();

        if (data === 1) {
            table.column(2).order('desc').draw();

        } else {
            table.column(2).order('asc').draw();
        }
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
                    url: "{{url('department')}}" + "/" + id,
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
                                'Department has been deleted.',
                                'success'
                            );
                            getListData();
                        }

                    }
                });
                // if (isConfirmed.value) {
                //     Swal.fire(
                //         'Deleted!',
                //         'Department has been deleted.',
                //         'success'
                //     );

                // }
            }
        });
    }
    $(document).on('change', '.status', function() {
        var isSuperAdmin = "{{ auth()->user()->is_super_admin }}";
        var isAuthorityEdit = "{{ auth()->user()->can('department-edit') }}";
        var isAuthorityDelete = "{{ auth()->user()->can('department-delete') }}";
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
            text: "Are You Sure To " + activeStatus + " This Department!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3565ed',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Change it!'
        }).then(isConfirmed => {
            if (isConfirmed.value) {
                $.ajax({
                    url: "{{ url('changedepartmentActiveStatus') }}",
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
                                'Department Status has been Changed.',
                                'success'
                            );
                            getListData();
                            // table.clear().draw();
                            // $.each(result.data, function(key, val) {
                            //     console.log(val);
                            //     var name = val.name;
                            //     var description = val.description;
                            //     var id = val.id;
                            //     var statusRes = (val.is_active == 1) ? "checked" : "";
                            //     var statusBtn = '<label class="switch">';
                            //     statusBtn += '<input type="checkbox" data-id="' + id + '" value="" class="status" ' + statusRes + '>';
                            //     statusBtn += '<span class="slider round"></span></label>';
                            //     if (isSuperAdmin || isAuthorityEdit) {
                            //         var EditBtn = '<div style="display:inline;cursor: pointer;" id="' + id + '" class="editDept" title="Edit Department"><i class="fa-solid fa-pen" style="color:orange"></i></div>';

                            //     }

                            //     if (isSuperAdmin || isAuthorityDelete) {
                            //         var deleteBtn = '<div onclick="delete_item(' + id + ');" style="display:inline;cursor: pointer; margin-left: 10px;" id="' + id + '" class="" title="Delete Department"><i class="fa-solid fa-trash" style="color:red"></i></div>';

                            //     }
                            //     var actionBtn = EditBtn + deleteBtn;
                            //     table.row.add([name, description, statusBtn, actionBtn]).draw();
                            // });
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
        var isAuthorityEdit = "{{ auth()->user()->can('department-edit') }}";
        var isAuthorityDelete = "{{ auth()->user()->can('department-delete') }}";
        var table = $('#service_table').DataTable();

        $.ajax({
            url: "{{ url('getDepartmentListData') }}",
            type: 'ajax',
            method: 'get',
            data: {
                "_token": "{{ csrf_token() }}"
            },
            success: function(result) {
                table.clear().draw();
                $.each(result.data, function(key, val) {
                    console.log(val);
                    var name = val.name;
                    var description = val.description;
                    var id = val.id;
                    var statusRes = (val.is_active == 1) ? "checked" : "";
                    var statusBtn = '<label class="switch">';
                    statusBtn += '<input type="checkbox" data-id="' + id + '" value="" class="status" ' + statusRes + '>';
                    statusBtn += '<span class="slider round"></span></label>';
                    if (isSuperAdmin || isAuthorityEdit) {
                        var EditBtn = '<div style="display:inline;cursor: pointer;" id="' + id + '" class="editDept" title="Edit Department"><i class="fa-solid fa-pen" style="color:orange"></i></div>';

                    }

                    if (isSuperAdmin || isAuthorityDelete) {
                        var deleteBtn = '<div onclick="delete_item(' + id + ');" style="display:inline;cursor: pointer; margin-left: 10px;" id="' + id + '" class="" title="Delete Department"><i class="fa-solid fa-trash" style="color:red"></i></div>';

                    }
                    var actionBtn = EditBtn + deleteBtn;
                    table.row.add([name, description, statusBtn, actionBtn]).draw();
                });
            }
        });
    }
</script>
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
                    <div class="card-header border-0 pt-6 add-button-datatable">

                        <div class="card-title">

                        </div>

                        <div class="card-toolbar">
                            <!--begin::Toolbar-->
                            <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                                <!--begin::Filter-->

                                <!--begin::Add user-->

                                <a href="{{ route('workflow.create') }}"><button type="button" class="btn switchPrimaryBtn  ">
                                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr075.svg-->
                                        <span class="svg-icon svg-icon-2">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1" transform="rotate(-90 11.364 20.364)" fill="currentColor" />
                                                <rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="currentColor" />
                                            </svg>
                                        </span>
                                        <!--end::Svg Icon-->Add</button></a>
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


                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!--end::Card header-->
                    <!--begin::Card body-->
                    <div class="card-body  p-3">
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
                                <input type="text"  class="form-control form-control-solid w-250px ps-14 search" placeholder="Search" />
                           -->
                            </div>
                            <!--end::Search-->
                        </div>
                        <!--begin::Table-->
                        <table class="table align-middle table-row-bordered fs-6 gy-5" id="service_table">
                            <!--begin::Table head-->
                            <thead>
                                <!--begin::Table row-->
                                <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">

                                    <th class="min-w-125px">Work Flow Name </th>
                                    <th class="min-w-125px">Work Flow Code </th>
                                    <th class="min-w-125px">Levels</th>
                                    <th class="min-w-125px">Approval Type</th>
                                    <th>Status</th>
                                    <th class="min-w-100px">Actions</th>

                                </tr>
                                <!--end::Table row-->
                            </thead>
                            <!--end::Table head-->
                            <!--begin::Table body-->
                            <tbody class="text-gray-600 fw-semibold">
                                <!--begin::Table row-->
                                @foreach($models as $key=>$d)
                                <tr>

                                    <td>{{$d['wfName']}}</td>
                                    <td>{{$d['wfCode']}}</td>
                                    <td>{{$d['total_levels']}}</td>
                                    <td>{{$d['wfType'] }}</td>
                                    <td>
                                        <label class="switch">
                                            <input type="checkbox" data-id="{{ $d['id'] }}" value="" class="status" <?php echo $d['is_active'] == 1 ? 'checked' : ''; ?>>
                                            <span class="slider round"></span>
                                        </label>

                                    </td>
                                    <td class="text-end">
                                        @if($d['runningStatus'])
                                        <span class="badge badge-success">Running Workflow</span>
                                        @else
                                     
                                        <div class="d-flex my-3 ms-9">
                                            <!--begin::Edit-->
                                            @if (auth()->user()->is_super_admin == 1 ||
                                            auth()->user()->can('workflow-edit'))
                                            <a class = "editWf" style="display:inline;cursor: pointer;" id="{{ $d['id'] }}" title="Edit workflow"><i class="fa-solid fa-pen" style="color:orange"></i></a>

                                      
                                            @endif
                                            @if (auth()->user()->is_super_admin == 1 ||
                                            auth()->user()->can('workflow-delete'))
                                            <div onclick="delete_item(<?php echo $d['id']; ?>);" style="display:inline;cursor: pointer; margin-left: 10px;" id="{{ $d['id'] }}" class="" title="Delete workflow"><i class="fa-solid fa-trash" style="color:red"></i></div>

                                            @endif

                                            <!--end::More-->
                                        </div>
                                        @endif
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
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script type="text/javascript">
   
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




    // Edit


  

    $(document).on('click', '.editWf', function() {
        var id = $(this).attr('id');
        var url = "{{route('workflowEdit')}}";
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
                        if (result.message == "Failed") {
                            Swal.fire(
                                'Deleted!',
                                'Reference Datas Are Found,deleted Failed.',
                                'error'
                            );
                        } else {
                            Swal.fire(
                        'Deleted!',
                        'Workflow has been deleted.',
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
        var isAuthorityEdit = "{{ auth()->user()->can('workflow-edit') }}";
        var isAuthorityDelete = "{{ auth()->user()->can('workflow-delete') }}";
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


        Swal.fire({
            title: 'Change Status',
            text: "Are You Sure To " + activeStatus + " This Workflow!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Change it!'
        }).then(isConfirmed => {
            if (isConfirmed.value) {
                $.ajax({
                    url: "{{ url('changeWorkflowActiveStatus') }}",
                    type: 'ajax',
                    method: 'post',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        id: id,
                        status: status,
                    },
                    success: function(result) {
                        var resDatas = result;
                        console.log(resDatas);

                        if (resDatas.message == "Failed") {
                            if (status == 1) {
                                chk.prop('checked', false);

                            } else {

                                chk.prop('checked', true).attr('checked', 'checked');
                            }
                            Swal.fire(
                                'Status!',
                                resDatas.data,
                                'error'
                            );
                        } else {
                            Swal.fire(
                        'Status!',
                        'Workflow Status has been Changed.',
                        'success'
                    );
                            getListData();
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
        var isAuthorityEdit = "{{ auth()->user()->can('workflow-edit') }}";
        var isAuthorityDelete = "{{ auth()->user()->can('workflow-delete') }}";

        var table = $('#service_table').DataTable();

        $.ajax({
            url: "{{ url('getWorkflowListData') }}",
            type: 'ajax',
            method: 'get',
            data: {
                "_token": "{{ csrf_token() }}"
            },
            success: function(result) {
                console.log(result); 
                table.clear().draw();

            $.each(result, function(key, val) {
                console.log(val);
            
                var id = val.id;
                var wfname = val.workflow_name;
                var wfcode = val.workflow_code;
                var wfLevel = val.total_levels;
                var wfType = (val.workflow_type == 1) ? "FULL" : "Partial";
                var statusRes = (val.is_active == 1) ? "checked" : "";

                var statusBtn = '<label class="switch">';
                statusBtn += '<input type="checkbox" data-id="' + id + '" value="" class="status" ' + statusRes + '>';
                statusBtn += '<span class="slider round"></span></label>';
                var editBtn = "";
                var deleteBtn = "";
                var editurl = '{{ route("workflow.edit", ":id") }}';
                editurl = editurl.replace(':id', id);
                if (isSuperAdmin || isAuthorityEdit) {
                    var editBtn = '<a href="' + editurl + '" style="display:inline;cursor: pointer;" id="' + id + '" class="editDept" title="Edit Department"><i class="fa-solid fa-pen" style="color:orange"></i></a>';
                }

                if (isSuperAdmin || isAuthorityDelete) {
                    var deleteBtn = '<div onclick="delete_item(' + id + ');" style="display:inline;cursor: pointer; margin-left: 10px;" id="' + id + '" class="" title="Delete Department"><i class="fa-solid fa-trash" style="color:red"></i></div>';

                }

                var actionBtn = (editBtn + deleteBtn);

                table.row.add([wfname, wfcode, wfLevel,wfType,statusBtn, actionBtn]).draw();
            });
                        }
        });
    }

</script>
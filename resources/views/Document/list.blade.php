@extends('layouts.app')

@section('content')
<style>
    th.tdStyle {
        min-width: 150px;
        display: inline-block;
        border-radius: 18px;
        background-color: #fce6cc;
        color: black;
        border: 2px solid #fce6cc;
        margin: 5px !important;
        text-align: center !important;

    }

    td.tdStyle {
        min-width: 150px;
        display: inline-block;
        border-radius: 18px;
        background-color: #fce6cc;
        color: black;
        border: 2px solid #fce6cc;
        margin-left: 5px;
        margin-right: 5px;
        margin-top: 5px;
        text-align: center;
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
                    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Document Type</h1>
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
                        <li class="breadcrumb-item text-muted">Document Type</li>
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
                                <a href="{{url('documentType/create')}}" class="btn btn-primary">
                                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr075.svg-->
                                    <span class="svg-icon svg-icon-2">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1" transform="rotate(-90 11.364 20.364)" fill="currentColor" />
                                            <rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="currentColor" />
                                        </svg>
                                    </span>
                                    <!--end::Svg Icon-->Add</a>

                                <!--end::Add user-->
                            </div>
                            <!--end::Toolbar-->
                            <!--begin::Group actions-->

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
                                <input type="text" class="form-control form-control-solid w-250px ps-14 search" placeholder="Search" />
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
                                    <th class="min-w-125px">Document Type</th>
                                    <th class="min-w-125px">Work Flow code ,Name</th>
                                    <th class="min-w-125px">Levels</th>
                                    <th class="min-w-125px">Satuts</th>
                                    <th class="min-w-125px">Actions</th>

                                </tr>
                                <!--end::Table row-->
                            </thead>
                            <!--end::Table head-->
                            <!--begin::Table body-->
                            <tbody class="text-gray-600 fw-semibold">
                                <!--begin::Table row-->
                                @foreach($document as $key=>$d)
                                <tr>
                                    <!--begin::Checkbox-->

                                    <!--end::Checkbox-->
                                    <!--begin::User=-->
                                    <td class="d-flex align-items-center">
                                        {{$key+1}}
                                    </td>

                                    <td>{{$d->name}}</td>
                                    <td>{{$d->workflow_code}},{{$d->workflow_name}}</td>

                                    <td>{{$d->total_levels}}</td>
                                    <td>

                                        <label class="switch">
                                            <input type="checkbox" data-id="{{ $d-> id }}" value="" class="status" <?php echo $d->is_active == 1 ? 'checked' : ''; ?>>
                                            <span class="slider round"></span>
                                        </label>
                                    </td>
                                    <td>
                                        <div class="d-flex my-2 ms-6">
                                            <!--begin::Edit-->
                                            @if (auth()->user()->is_super_admin == 1 ||
                                            auth()->user()->can('designation-edit'))
                                            <a href="{{route('documentType.edit',$d['id'])}}" class="btn btn-icon btn-active-light-primary w-30px h-30px me-3">
                                                <span data-bs-toggle="tooltip" data-bs-trigger="hover" title="Edit">
                                                    <!--begin::Svg Icon | path: icons/duotune/art/art005.svg-->
                                                    <span class="svg-icon svg-icon-3">
                                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path opacity="0.3" d="M21.4 8.35303L19.241 10.511L13.485 4.755L15.643 2.59595C16.0248 2.21423 16.5426 1.99988 17.0825 1.99988C17.6224 1.99988 18.1402 2.21423 18.522 2.59595L21.4 5.474C21.7817 5.85581 21.9962 6.37355 21.9962 6.91345C21.9962 7.45335 21.7817 7.97122 21.4 8.35303ZM3.68699 21.932L9.88699 19.865L4.13099 14.109L2.06399 20.309C1.98815 20.5354 1.97703 20.7787 2.03189 21.0111C2.08674 21.2436 2.2054 21.4561 2.37449 21.6248C2.54359 21.7934 2.75641 21.9115 2.989 21.9658C3.22158 22.0201 3.4647 22.0084 3.69099 21.932H3.68699Z" fill="currentColor" />
                                                            <path d="M5.574 21.3L3.692 21.928C3.46591 22.0032 3.22334 22.0141 2.99144 21.9594C2.75954 21.9046 2.54744 21.7864 2.3789 21.6179C2.21036 21.4495 2.09202 21.2375 2.03711 21.0056C1.9822 20.7737 1.99289 20.5312 2.06799 20.3051L2.696 18.422L5.574 21.3ZM4.13499 14.105L9.891 19.861L19.245 10.507L13.489 4.75098L4.13499 14.105Z" fill="currentColor" />
                                                        </svg>
                                                    </span>
                                                    <!--end::Svg Icon-->
                                                </span>
                                            </a>
                                            @endif
                                            @if (auth()->user()->is_super_admin == 1 ||
                                            auth()->user()->can('designation-delete'))
                                            <!--end::Edit-->
                                            <!--begin::Delete-->
                                            <a class="btn btn-icon btn-active-light-primary w-30px h-30px me-3" href="javascript:void(0);" class="menu-link px-3" onclick="delete_item(<?php echo $d->id; ?>);">
                                                <!--begin::Svg Icon | path: icons/duotune/general/gen027.svg-->
                                                <span class="svg-icon svg-icon-3">
                                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z" fill="currentColor" />
                                                        <path opacity="0.5" d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z" fill="currentColor" />
                                                        <path opacity="0.5" d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z" fill="currentColor" />
                                                    </svg>
                                                </span>
                                                <!--end::Svg Icon-->
                                            </a>
                                            <!--end::Delete-->
                                            <!--begin::More-->
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

<!-- Edit Model -->
@foreach($document as $key=>$d)
<div class="modal fade" id="kt_modal_add_customer<?php echo $d->id; ?>" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
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

                <form id="designation_form1" method="post" action="{{url('documentType')}}">
                    @csrf


                    <div class="row g-9 mb-7">


                        <div class="col-md-12 fv-row">
                            <!--begin::Label-->
                            <label class="required fs-6 fw-semibold mb-2">Document Type</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input class="form-control form-control-solid" placeholder="Enter Document type" name="name" value="<?php echo $d->name; ?>" />
                            <!--end::Input-->
                        </div>
                        <!--end::Col-->
                        <!--begin::Col-->
                        <div class="col-md-12 fv-row">
                            <!--begin::Label-->
                            <label class="required fs-6 fw-semibold mb-2">Workflow</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <select class="form-control default_work_flow" name="workflow_id" onchange="get_work_flow_levels(this.value);" required>
                                <option value="">Select</option>
                                @foreach($workflow as $wf)
                                <option <?php if ($d->workflow_id == $wf['id']) {
                                            echo "selected";
                                        } ?> value="{{$wf['id']}}">{{$wf['workflow_name']}}</option>
                                @endforeach

                            </select>

                            <!--end::Input-->
                        </div>
                        <!--end::Col-->
                        <div class="col-md-12 fv-row work_levels">
                            <table class="table no-border custom_table dataTable no-footer dtr-inline edittable">
                                <thead>
                                    <tr>
                                        <th class="tdStyle">
                                            Level
                                        </th>
                                        <th class="tdStyle">
                                            Designation
                                        </th>
                                    </tr>
                                </thead>

                                <tbody class="append_div_partial">

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <input type="hidden" name="id" value="<?php echo $d->id; ?>">
                    {{-- FORM --}}
                    <div class="text-center pt-15">
                        <button type="reset" class="btn btn-light-danger me-3" data-bs-dismiss="modal" onclick=" document.location.reload();">Cancel</button>
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
<script>
    $(document).ready(function() {
        var table = $('#service_table').DataTable({
            filter: true,
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            "searching": true,
        });
        $(".work_levels").hide();
        // on form submit
        $("#designation_form1").on('submit', function() {
            // to each unchecked checkbox
            $(this).find('input[type=checkbox]:not(:checked)').prop('checked', true).val(0);
        })
        $('.search').on('input', function() {
            var searchData = $('.search').val();
            $.ajax({
                url: "{{ route('doctypeSearch') }}",
                type: 'ajax',
                method: 'post',
                data: {
                    "_token": "{{ csrf_token() }}",
                    searchData: searchData,
                },
                success: function(data) {
                    table.clear().draw();
                    $.each(data, function(key, val) {
                        var sNo = key + 1;
                        var id = val.id;
                        var name = val.name;
                        var wfData = val.workflow_name + '&' + val.workflow_code;
                        var wfLevel = val.total_levels;

                        var activeStatus = (val.is_active == 1) ? "checked" : "";

                        var editurl = '{{ route("documentType.edit", ":id") }}';
                        editurl = editurl.replace(':id', id);
                        var result = (
                            '<label class="switch"><input type="checkbox" data-id="' +
                            id + '" class="status" ' + activeStatus +
                            '>  <span class="slider round"></span></label>');
                        var editBtn = (
                            '<a href="' + editurl + '" class="btn btn-icon btn-active-light-primary w-30px h-30px me-3" <span data-bs-toggle="tooltip" data-bs-trigger="hover" title="Edit"><span class="svg-icon svg-icon-3"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"> <path opacity="0.3" d="M21.4 8.35303L19.241 10.511L13.485 4.755L15.643 2.59595C16.0248 2.21423 16.5426 1.99988 17.0825 1.99988C17.6224 1.99988 18.1402 2.21423 18.522 2.59595L21.4 5.474C21.7817 5.85581 21.9962 6.37355 21.9962 6.91345C21.9962 7.45335 21.7817 7.97122 21.4 8.35303ZM3.68699 21.932L9.88699 19.865L4.13099 14.109L2.06399 20.309C1.98815 20.5354 1.97703 20.7787 2.03189 21.0111C2.08674 21.2436 2.2054 21.4561 2.37449 21.6248C2.54359 21.7934 2.75641 21.9115 2.989 21.9658C3.22158 22.0201 3.4647 22.0084 3.69099 21.932H3.68699Z" fill="currentColor" /><path d="M5.574 21.3L3.692 21.928C3.46591 22.0032 3.22334 22.0141 2.99144 21.9594C2.75954 21.9046 2.54744 21.7864 2.3789 21.6179C2.21036 21.4495 2.09202 21.2375 2.03711 21.0056C1.9822 20.7737 1.99289 20.5312 2.06799 20.3051L2.696 18.422L5.574 21.3ZM4.13499 14.105L9.891 19.861L19.245 10.507L13.489 4.75098L4.13499 14.105Z" fill="currentColor" /></svg> </span></span></a>'
                        );
                        var Action = (editBtn +
                            '<a class="btn btn-icon btn-active-light-primary w-30px h-30px me-3" href="javascript:void(0);" class="menu-link px-3" onclick="delete_item(' +
                            id +
                            ')"><span class="svg-icon svg-icon-3"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z" fill="currentColor" /><path opacity="0.5" d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z" fill="currentColor" /><path opacity="0.5" d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z" fill="currentColor" /></svg></span></a>'
                        );
                        table.row.add([sNo, name, wfData, wfLevel, result, Action]).draw();
                    });
                },
                error: function() {
                    $("#otp_error").text("Update Error");
                }

            });


        });
    })
    setTimeout(function() {
        $('.alert').fadeOut('fast');
    }, 5000);
    $(document).ready(
        function() {


        });



    function get_work_flow_levels(workflow_id) {
        $.ajax({
            url: "{{url('getWorkflowLevels')}}",
            type: 'ajax',
            method: 'post',
            data: {
                "_token": "{{ csrf_token() }}",
                workflow_id: workflow_id,
            },
            success: function(data) {
                document.getElementById('custom_table').style.display = 'block'
                if (data) {
                    var allData = data;
                    console.log(allData);
                    var levels = allData.entities;
                    $(".work_levels").show();
                    $(".append_div_partial").empty();
                    $.each(levels, function(key, val) {
                        var designationData = val.designationId;

                        $(".append_div_partial").append('<tr><td class="tdStyle"><label>Level-<span class="level_name1">' + val.levelId + '</span></label></td><td class="tdStyle">' + designationData + '</td></tr>');
                    });
                }
            }
        });
    }


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
                    url: "{{url('documentType')}}" + "/" + id,
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
                                'Data has been deleted.',
                                'success'
                            );
                            window.location.reload();
                        }
                    }
                });

            }
        });
    }
    $(document).on('change', '.status', function() {
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
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Change it!'
        }).then(isConfirmed => {
            if (isConfirmed.value) {
                $.ajax({
                    url: "{{ url('changedDocumentTypeActiveStatus') }}",
                    type: 'ajax',
                    method: 'post',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        id: id,
                        status: status,
                    },
                    success: function(result) {
                        if (result) {
                            window.location.reload();
                        }
                    }
                });
                if (isConfirmed.value) {
                    Swal.fire(
                        'Status!',
                        'Department Status has been Changed.',
                        'success'
                    );

                }
            }else {             
                if (chk.checked) {
                    chk.prop("checked", false);
                } else {
                    chk.prop("checked", true);
                }
            }
        });
    });
</script>
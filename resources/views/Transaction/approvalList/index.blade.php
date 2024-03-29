@extends('layouts.app')

@section('content')
<style>
    * {
        box-sizing: border-box
    }

    /* Style the tab */
    .tab {
        float: left;
        border: 1px solid #ccc;
        background-color: #f1f1f1;
        height: 745px;
        width: 30%;
    }

    /* Style the buttons inside the tab */
    .tab button {
        display: block;
        background-color: inherit;
        color: black;
        padding: 22px 16px;
        width: 100%;
        border: none;
        outline: none;
        text-align: left;
        cursor: pointer;
        transition: 0.3s;
        font-size: 17px;
    }

    /* Change background color of buttons on hover */
    .tab button:hover {
        background-color: #ddd;
    }

    /* Create an active/current "tab button" class */
    .tab button.active {
        background-color: #ccc;
    }

    /* Style the tab content */
    .tabcontent {
        float: left;
        padding: 0px 12px;
        border: 1px solid #ccc;
        width: 70%;
        border-left: none;
        height: 770px;
    }

    #critical {
        border: 2px solid white;
        box-shadow: 0 0 0 1px red;
        appearance: none;
        border-radius: 50%;
        width: 12px;
        height: 12px;
        background-color: #fff;
        transition: all ease-in 0.2s;

    }

    #critical:checked {
        background-color: red;
    }

    #low {
        border: 2px solid white;
        box-shadow: 0 0 0 1px yellow;
        appearance: none;
        border-radius: 50%;
        width: 12px;
        height: 12px;
        background-color: #fff;
        transition: all ease-in 0.2s;

    }

    #low:checked {
        background-color: yellow;
    }

    #medium {
        border: 2px solid white;
        box-shadow: 0 0 0 1px blue;
        appearance: none;
        border-radius: 50%;
        width: 12px;
        height: 12px;
        background-color: #fff;
        transition: all ease-in 0.2s;

    }

    #medium:checked {
        background-color: blue;
    }

    #high {
        border: 2px solid white;
        box-shadow: 0 0 0 1px green;
        appearance: none;
        border-radius: 50%;
        width: 12px;
        height: 12px;
        background-color: #fff;
        transition: all ease-in 0.2s;

    }

    #high:checked {
        background-color: green;
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
                    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                        Approval Listing</h1>
                    <!--end::Title-->
                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">
                            <a href="#" class="text-muted text-hover-primary">Approval Listing</a>
                        </li>
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
                    @if ($errors->any())
                    <div class="alert alert-danger" role="alert">
                        {{ implode('', $errors->all(':message')) }}
                    </div>
                    @endif

                    <!--end::Card header-->
                    <div class="card-body  p-3">
                        <div class="row g-8">

                            <div class="col-md-4">
                                <label class="fs-6 form-label fw-bold text-dark "> WorkFlow Name / Code</label>
                                <!--begin::Select-->
                                <select class="form-select workflowFilter" name="workflow_code_name" data-kt-select2="true" data-placeholder="WorkFlow Name (Code)" data-allow-clear="false" id="workflow">
                                    <option></option>
                                    @foreach ($workflow as $wf)
                                    <option value="{{ $wf['id'] }}">
                                        {{ $wf['workflow_name'] }} ({{ $wf['workflow_code'] }})
                                    </option>
                                    @endforeach
                                </select>
                                <!--end::Select-->
                            </div>
                            <!--begin::Col-->
                            <div class="col-md-3">
                                <label class="fs-6 form-label fw-bold text-dark ">Project Name / Code </label>
                                <select class="form-select projectFilter" name="project_code_name" data-kt-select2="true" data-placeholder="Project Name (Code)" data-allow-clear="false" id="projectCode">
                                    <option></option>
                                    @foreach ($projects as $project)
                                    <option value="{{ $project['id'] }}">
                                        {{ $project['project_name'] }} ({{ $project['project_code'] }})
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <!--begin::Col-->
                            <div class="col-md-3">
                                <label class="fs-6 form-label fw-bold text-dark "> Ticket No. </label>
                                <select class="form-select filterDeptAndDes doclistFilter" name="ticket_no" data-kt-select2="true" data-placeholder="Ticket No" data-allow-clear="false" id="ticketno">
                                    <option></option>
                                    @foreach ($projects as $project)
                                    <option name="ticket_no" value="{{ $project['id'] }}">
                                        {{ $project['ticket_no'] }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <!--end::Col-->
                            <div class="col-lg-2">
                                <label class="fs-6 form-label fw-bold text-dark"> Department </label>
                                <!--begin::Select-->
                                <select class="form-select filterDeptAndDes doclistFilter" name="department" data-kt-select2="true" data-placeholder="Department" data-allow-clear="false" id="deptId">
                                    <option></option>
                                    @foreach ($departments as $dept)
                                    <option name="department" value="{{ $dept['id'] }}">{{ $dept['name'] }}
                                    </option>
                                    @endforeach
                                </select>
                                <!--end::Select-->
                            </div>
                            <div class="col-lg-2">
                                <label class="fs-6 form-label fw-bold text-dark"> Designation </label>
                                <!--begin::Select-->
                                <select class="form-select filterDeptAndDes doclistFilter" name="designation" data-kt-select2="true" data-placeholder="Designation" name="designation" data-allow-clear="false" id="desgId">
                                    <option></option>
                                    @foreach ($designation as $des)
                                    <option value="{{ $des['id'] }}">{{ $des['name'] }}
                                    </option>
                                    @endforeach
                                </select>
                                <!--end::Select-->
                            </div>

                            <div class="col-lg-2">
                                <label class="fs-6 form-label fw-bold text-dark"> Users </label>
                                <!--begin::Select-->
                                <select class="form-select filterDeptAndDes doclistFilter" name="users" data-kt-select2="true" data-placeholder="Users" data-allow-clear="false" id="users">
                                    <option></option>
                                    @foreach ($employees as $emp)
                                    <option value="<?php echo $emp['id']; ?>"><?php echo $emp['fullName']; ?></option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <label class="fs-6 form-label fw-bold text-dark">Start Date</label>
                                <input type="date" class="form-control dateWiseFilter start_date" id="startDate" name="start_date" placeholder="Enter Start Date">
                            </div>
                            <div class="col-sm-2">
                                <label class="fs-6 form-label fw-bold text-dark">End Date</label>
                                <input type="date" class="form-control dateWiseFilter to_date" id="endDate" name="end_date" placeholder="Enter End Date">
                            </div>
                            <div class="w-auto SearchFilter">
                                <label class="fs-6 fw-semibold mb-2 d-block">&nbsp;</label>
                                <span class="btn btn-success ">Search</span>
                            </div>
                            <div class="w-auto">
                                <label class="fs-6 fw-semibold mb-2 d-block">&nbsp;</label>
                                <span class="btn btn-warning reset" >Reset</span>
                            </div>
                        </div>


                        <hr>
                        <table class="table align-middle table-row-bordered fs-6 gy-5" id="service_table">
                            <!--begin::Table head-->
                            <thead>
                                <!--begin::Table row-->
                                <tr class="text-start align-middle text-muted fw-bold fs-7 text-uppercase gs-0">

                                    <th class="min-w-125px">Ticket No</th>
                                    <th class="min-w-125px">Work Flow Code & Name</th>
                                    <th class="min-w-125px">Project Code & Name</th>
                                    <th class="min-w-75px">start Date </th>
                                    <th class="min-w-75px">End Date </th>

                                    <th class="min-w-125px">Initiator</th>
                                    <th class="min-w-125px">Department</th>
                                    <th class="">Action</th>
                                </tr>
                                <!--end::Table row-->
                            </thead>
                            <!--end::Table head-->
                            <!--begin::Table body-->
                            <tbody class="text-gray-600 fw-semibold" id="service_table_tbody">
                                <!--begin::Table row-->
                                @foreach ($projects as $project)
                                <?php
                                $WorkFlow = $project->workflow;
                                $initiator = $project->employee;
                                $department = $initiator->department;
                                ?>
                                <tr>
                                    <td>{{ $project['ticket_no'] }}</td>
                                    <td>{{ $WorkFlow['workflow_name'] . ' & ' . $WorkFlow['workflow_code'] }}</td>
                                    <td>{{ $project['project_name'] . ' & '. $project['project_code'] }}</td>
                                    <td>{{ date('d-m-Y', strtotime($project['start_date'])) }}</td>
                                    <td>{{ date('d-m-Y', strtotime($project['end_date'])) }}</td>

                                    <td>{{ $initiator['first_name'] . ' ' . $initiator['middle_name'] . ' ' .$initiator['last_name'] }}</td>
                                    <td>{{ $department['name'] }}</td>
                                    <td>
                                        <a id="{{ $project['id'] }}" screen="view" class="actionDocs badge switchPrimaryBtn" style=";cursor: pointer;">View Approved Docs</a>
                                        <!-- <a id="{{ $project['id'] }}" screen="approving" class="actionDocs badge badge-info">Approved</a> -->
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
<script data-require="jquery@*" data-semver="3.0.0" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.js">
</script>
{{-- <script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.js"></script> --}}


<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>

{{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script> --}}

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>

<script>
    $(document).ready(function() {
        var isSuperAdmin = "{{ auth()->user()->is_super_admin }}";
        var isAuthorityEdit = "{{ auth()->user()->can('document-listing-edit') }}";
        var isHigherAuthorityPerson = "{{ Session('authorityType') }}";

        $('.workflowFilter').on('change', function() {
            console.log("well");
            $('.start_date').val('');
            $('.to_date').val('');
            var table = $('#service_table').DataTable();
            $('.filterDeptAndDes').val('').trigger('change');
            if ($('.projectFilter').val()) {
                $('.projectFilter').val('').trigger('change');
            }
            $.ajax({
                url: "{{ route('getProjectByWorkflow') }}",
                type: 'ajax',
                method: 'post',
                data: {
                    "_token": "{{ csrf_token() }}",
                    workflow: $('#workflow').val(),
                },
                success: function(data) {
                    table.clear().draw();
                    var projectFilter = $('.projectFilter');
                    projectFilter.empty();
                    projectFilter.append('<option value="">Project/No</option>');
                    $.each(data.datas, function(key, val) {


                        var ticketNo = val.ticketNo;
                        var deptName = val.department;
                        var initiator = val.initiaterName;
                        var projectCodeandName = val.projectName;
                        var wfCodeandwfName = val.workflowName;

                        var projectId = val.projectId;
                        var startDate = val.startDate;
                        var endDate = val.endDate;
                        console.log(startDate,endDate);
                        var act = '<a id="' + projectId + '" screen="view" class="actionDocs badge switchPrimaryBtn" style=";cursor: pointer;">View Approved Docs</a>';

                        table.row.add([ticketNo, wfCodeandwfName, projectCodeandName, startDate, endDate, initiator, deptName, act]).draw();


                        projectFilter.append('<option value="' + projectId + '">' + projectCodeandName + '</option>');
                    });
                    projectFilter.select2();
                    //$('.doclistFilter option:selected').prop("selected", false);
                },
                error: function() {
                    $("#otp_error").text("Update Error");
                }
            });

        });
        $('.projectFilter').on('change', function() {
            $('.start_date').val('');
            $('.to_date').val('');
            var table = $('#service_table').DataTable();
            $('.filterDeptAndDes').val('').trigger('change');
            console.log("well one");
            $.ajax({
                url: "{{ route('getProjectById') }}",
                type: 'ajax',
                method: 'post',
                data: {
                    "_token": "{{ csrf_token() }}",
                    projectId: $('.projectFilter').val(),
                },
                success: function(data) {
                    table.clear().draw();

                    $.each(data.datas, function(key, val) {


                        var ticketNo = val.ticketNo;
                        var deptName = val.department;
                        var initiator = val.initiaterName;
                        var projectCodeandName = val.projectName;
                        var wfCodeandwfName = val.workflowName;

                        var projectId = val.projectId;

                        var startDate = val.startDate;
                        var endDate = val.endDate;
                        console.log(startDate,endDate);
                        var act = '<a id="' + projectId + '" screen="view" class="actionDocs badge switchPrimaryBtn" style=";cursor: pointer;">View Approved Docs</a>';

                        act += '</span>';
                        table.row.add([ticketNo, wfCodeandwfName, projectCodeandName,startDate, endDate, initiator, deptName, act]).draw();



                    });

                    //$('.doclistFilter option:selected').prop("selected", false);
                },
                error: function() {
                    $("#otp_error").text("Update Error");
                }
            });
        });
        $(document).on('change click', '.dateWiseFilter', function() {
            $('.filterDeptAndDes').val('').trigger('change');

            if ($('.workflowFilter').val()) {
                $('.workflowFilter').val('').trigger('change');
            }
            if ($('.projectFilter').val()) {
                $('.projectFilter').val('').trigger('change');
            }


        });
        $(document).on('click', '.SearchFilter', function() {
            var ticketNo = $('#ticketno').val();
            var deptValue = $('#deptId').val();
            var desgValue = $('#desgId').val();
            var UserValue = $('#users').val();

            var startdate = $('#startDate').val();
            var enddate = $('#endDate').val();
            console.log("well and good");
            if (startdate && enddate) {
                console.log("well and good");
                $('.doclistFilter').val("").trigger('change');
                documnetFilter();
            }
            if (ticketNo|| deptValue || desgValue || UserValue) {
                $("input[type=date]").val("");
                documnetFilter();
            }

        });
        $(document).on('change click', '.to_date', function() {
            console.log("To Date");
            $('.start_date').attr("max",$(this).val());
            var startDate = $('.start_date').val().trim();
            var endDate = $('.endDate').val().trim();

            console.log(startDate);
            console.log(endDate);
            if (startDate && endDate) {
                if (startDate > endDate) {
                    console.log("If part 1 start Date");
                    Swal.fire(
                        'Warning!',
                        'End date should not be lesser than Start date',
                        'error'
                    );

                    $('.to_date').val('');
                }
            }
        });
        $(document).on('change click', '.start_date', function() {
            console.log("Start Date");
            $('.to_date').attr("min",$(this).val());
            var startDate = $('.start_date').val().trim();
            var endDate = $('.to_date').val().trim();

            console.log(startDate);
            console.log(endDate);

            if (startDate && endDate) {
                console.log("If part 1 start Date");
                if (startDate > endDate) {
                    console.log("If part 2 start Date");
                    Swal.fire(
                        'Warning!',
                        'End date should not be lesser than Start date',
                        'error'
                    );

                    $('.start_date').val('');
                    $('.to_date').val('');

                }
            }
        });

        function documnetFilter() {
            var table = $('#service_table').DataTable();
            var ticketNo = $('#ticketno').val();
            var projectCode = "";
            var workflow = "";
            var user = $('#users').val();
            var deptId = $('#deptId').val();
            var desgId = $('#desgId').val();
            var startdate = $('#startDate').val();
            var enddate = $('#endDate').val();
            $.ajax({
                url: "{{ route('docListingSearch') }}",
                type: 'ajax',
                method: 'post',
                data: {
                    "_token": "{{ csrf_token() }}",
                    ticket_no: ticketNo,
                    project_code_name: projectCode,
                    workflow_code_name: workflow,
                    users: user,
                    start_date: startdate,
                    end_date: enddate,
                    department: deptId,
                    designation: desgId,
                },
                success: function(data) {
                    table.clear().draw();

                    $.each(data, function(key, val) {
                        var ticketNo = val.ticket_no;
                        var deptName = val.deptName;
                        var initiator = val.first_name + " " + val.middle_name + " "+ val.last_name;
                        var projectCode = val.project_code;
                        var projectName = val.project_name;
                        var wfCode = val.workflow_code;
                        var wfName = val.workflow_name;
                        var projectId = val.projectId;
                        var isInitiator = (val.initiatorStatus == "yes") ? 1 : 0;
                        var isApprover = (val.approverStatus == "yes") ? 1 : 0;
                        var pStartDate = formatedDate(val.start_date);
                        var pEndDate = formatedDate(val.end_date);


                        var act = '<a id="' + projectId + '" screen="view" class="actionDocs badge switchPrimaryBtn" style=";cursor: pointer;">View Approved Docs</a>';

                        table.row.add([ticketNo, wfName + ' & ' + wfCode, projectName + ' & ' + projectCode,pStartDate, pEndDate,
                            initiator, deptName, act
                        ]).draw();
                    });
                    $('.doclistFilter option:selected').prop("selected", false);
                },
                error: function() {
                    $("#otp_error").text("Update Error");
                }
            });
        }

        $(document).on('click', '.reset', function() {
            // location.reload();
            // $('.doclistFilter').val("").trigger('change');
            // $("input[type=date]").val("");
            $('#deptId').val(null).trigger('change');
            $('#desgId').val(null).trigger('change');
            $('#users').val(null).trigger('change');
            $('.ticket_no').val(null).trigger('change');
            $('.workflowFilter').val(null).trigger('change');
            $('.projectFilter').val(null).trigger('change');
            $('.start_date').val(null);
            $('.to_date').val('');
            $('#service_table').DataTable().destroy();
            var table = $("#service_table").DataTable({
                "aaSorting": [],
                "language": {
                    "lengthMenu": "Show _MENU_",
                },
                "dom": "<'row header-row'" +
                    "<'col-sm-6 d-flex align-items-center justify-conten-start'l>" +
                    "<'col-sm-6 d-flex align-items-center justify-content-end'f>" +
                    ">" +

                    "<'table-responsive'tr>" +

                    "<'row'" +
                    "<'col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start'i>" +
                    "<'col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end'p>" +
                    ">"
            });
            $.ajax({
                url: "{{ route('getDocumentListData') }}",
                type: 'ajax',
                method: 'get',
                data: {
                    "_token": "{{ csrf_token() }}",

                },
                success: function(resData) {
                    var data = resData.data;

                    table.clear().draw();
                    $.each(data, function(key, val) {
                        console.log(val);
                        var ticketNo = val.ticket_no;
                        var employee = val.employee;
                        var department = employee.department;
                        var deptName = department.name;

                        var initiator = employee.first_name + " " + employee.middle_name + " " + employee.last_name;
                        var projectCode = val.project_code;
                        var projectName = val.project_name;
                        var workflow = val.workflow;
                        var wfNameAndCode = workflow.workflow_name + " & " + workflow.workflow_code;
                        var projectId = val.id;
                        console.log(projectId);
                        var isInitiator = (val.initiatorStatus == "yes") ? 1 : 0;
                        var isApprover = (val.approverStatus == "yes") ? 1 : 0;
                        console.log("isInitiator" + isInitiator);
                        console.log("isApprover" + isApprover);

                        var pStartDate = formatedDate(val.start_date);
                        var pEndDate = formatedDate(val.end_date);


                        var act = '<a id="' + projectId + '" screen="view" class="actionDocs badge switchPrimaryBtn" style=";cursor: pointer;">View Approved Docs</a>';
                        table.row.add([ticketNo, wfNameAndCode, projectName + " & " + projectCode, pStartDate, pEndDate,
                            initiator, deptName, act
                        ]).draw();
                    });
                    //$('.doclistFilter option:selected').prop("selected", false);
                },
                error: function() {
                    $("#otp_error").text("Update Error");
                }
            });
        });


    });

    function formatedDate(date) {
            const inputDate = date;
            const parts = inputDate.split("-");
            const formattedDate = `${parts[2]}-${parts[1]}-${parts[0]}`;

            return formattedDate;
            // Output: "1-8-23"

        }
    $(document).on('change click', '.filterDeptAndDes', function() {
        console.log("well");
        $('.filterDeptAndDes').not($(this)).val('').trigger('change');

        if ($('.workflowFilter').val()) {
            $('.workflowFilter').val('').trigger('change');
        }
        if ($('.projectFilter').val()) {
            $('.projectFilter').val('').trigger('change');
        }
        $('.start_date').val('');
        $('.to_date').val('');
    });
    $(document).on('click', '.actionDocs', function() {

        var id = $(this).attr('id');
        var screen = $(this).attr('screen');
        if (screen == "view") {
            var url = "{{ route('approvedDocsView') }}";
        } else {
            var url = "{{ route('approvedDocsDownload') }}";
        }

        var form = $('<form action="' + url + '" method="post">' +
            ' {{ csrf_field() }} <input type="hidden" name="id" value="' + id + '" />' +
            '</form>');
        $('body').append(form);
        form.submit();
    });


    function reset() {
        location.reload();
        $('.doclistFilter').val("").trigger('change');
        $("input[type=date]").val("");
    }
</script>

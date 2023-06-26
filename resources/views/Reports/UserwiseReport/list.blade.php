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
                        <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                            Userwise Report</h1>
                        <!--end::Title-->
                        <!--begin::Breadcrumb-->
                        <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                            <!--begin::Item-->
                            <li class="breadcrumb-item text-muted">
                                <a href="#" class="text-muted text-hover-primary">Reports</a>
                            </li>
                            <!--end::Item-->
                            <!--begin::Item-->
                            <li class="breadcrumb-item">
                                <span class="bullet bg-gray-400 w-5px h-2px"></span>
                            </li>
                            <!--end::Item-->
                            <!--begin::Item-->
                            <li class="breadcrumb-item text-muted">Userwise Report</li>
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
                                <div class="row">
                                    <div class="col-md-4" id="workflowCodeField">
                                        <label class=" fs-6 fw-semibold mb-2">workflow Name & Code</label>
                                        <select name="workflowCode" id="workflowCode" class="form-select">
                                            <option value="">Select workflow </option>
                                            @foreach ($workflowDatas as $workflowData)
                                                <option value="{{ $workflowData->id }}">
                                                    {{ $workflowData->workflow_name }}-{{ $workflowData->workflow_code }}
                                                </option>
                                            @endforeach

                                        </select>


                                    </div>
                                    <div class="col-md-4" id="initiatorNameField">
                                        <!--begin::Label-->
                                        <label class=" fs-6 fw-semibold mb-2">Initiator Name & SAP ID</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <select name="initiatorName" id="initiatorName" class="form-select">
                                            <option value="">Select Initiator </option>
                                            @foreach ($initiatorDatas as $initiatorData)
                                                <option value="{{ $initiatorData->id }}">
                                                    {{ $initiatorData->first_name }}{{ $initiatorData->middle_name }}{{ $initiatorData->last_name }}-{{ $initiatorData->sap_id }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-1">
                                        <label class="fs-6 fw-semibold mb-2">&nbsp;</label>
                                        <button class="btn btn-warning resetBtn badge badge-secondary">Reset</button>
                                    </div>&nbsp;&nbsp;&nbsp;&nbsp;
                                    <div class="col-md-1">
                                        <label class="fs-6 fw-semibold mb-2">&nbsp;</label>
                                        <button class="btn btn-success badge badge-secondary" onclick="exportData()">Export to Excel</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                            <!--end::Card header-->
                            <!--begin::Card body-->
                            <div class="card-body py-4">
                                <!--begin::Card title-->
                                <div class="card-title">
                                    <!--begin::Search-->
                                    <div class="d-flex align-items-center position-relative my-1">
                                        <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                                        <!-- <span class="svg-icon svg-icon-1 position-absolute ms-6">
                                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                                xmlns="http://www.w3.org/2000/svg">
                                                                <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546"
                                                                    height="2" rx="1" transform="rotate(45 17.0365 15.1223)"
                                                                    fill="currentColor" />
                                                                <path
                                                                    d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
                                                                    fill="currentColor" />
                                                            </svg>
                                                        </span> -->
                                        <!--end::Svg Icon-->
                                        <!-- <input type="text" class="form-control form-control-solid w-250px ps-14 deptSearch"
                                                            placeholder="Search" /> -->
                                    </div>
                                    <!--end::Search-->
                                </div>
                                <!--begin::Card title-->
                                <!--begin::Table-->
                                <table class="table align-middle table-row-bordered fs-6 gy-5" id="service_table">
                                    <!--begin::Table head-->
                                    <thead>
                                        <!--begin::Table row-->
                                        <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">

                                         
                                            <th class="min-w-100px text-nowrap">Project Code</th>
                                            <th class="min-w-100px text-nowrap">Project Name</th>
                                            <th class="min-w-100px text-nowrap">Workflow Code</th>
                                            <th class="min-w-100px text-nowrap">Workflow Name</th>
                                            <th class="min-w-100px text-nowrap">Initiator</th>
                                            <th class="min-w-100px text-nowrap">Department</th>
                                            <th class="min-w-100px text-nowrap">Level</th>
                                            <th class="min-w-100px text-nowrap">Due Date</th>
                                            <th class="min-w-100px text-nowrap">No of Days</th>
                                            <th class="min-w-100px text-nowrap"> status</th>
                                            <th class="min-w-100px text-nowrap">Actions</th>
                                        </tr>
                                        <!--end::Table row-->
                                    </thead>
                                    <!--end::Table head-->
                                    <!--begin::Table body-->
                                    <tbody class="text-gray-600 fw-semibold" id="tableContent">
                                        @foreach ($entities as $entity)
                                            <tr>
                                            
                                                <td>{{ $entity['projectCode'] }}</td>
                                                <td>{{ $entity['projectName'] }}</td>
                                                <td>{{ $entity['workflowCode'] }}</td>
                                                <td>{{ $entity['workflowName'] }}</td>

                                                <td>{{ $entity['initiater'] }}</td>
                                                <td>{{ $entity['department'] }}</td>
                                                <td>{{ $entity['workflowLevel'] }}</td>
                                                <td>{{ $entity['dueDate'] }}</td>
                                                <td>{{ $entity['noOfDays'] }}</td>
                                                <td></td>
                                                <td><div id="{{$entity['projectId']}}" class="btn btn-primary btn-sm viewDocs">View</div></td>

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

    </div>

        <script data-require="jquery@*" data-semver="3.0.0" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.js">
        </script>
        <script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>

        <script>
            $(document).ready(
                function() {


                    $("#initiatorName").select2({
                        dropdownParent: $("#initiatorNameField")
                    });
                    $("#workflowCode").select2({
                        dropdownParent: $("#workflowCodeField")
                    });


                    $('#initiatorName,#workflowCode').on('change', function() {
                        filterData();
                    });

                    function filterData() {
                        var Employee = $('#initiatorName').val();
                        var workflow = $('#workflowCode').val();
                        $.ajax({
                            url: "{{ route('userWiseReportSearchFilter') }}",
                            type: 'ajax',
                            method: 'post',
                            data: {
                                "_token": "{{ csrf_token() }}",
                                Employee: Employee,
                                workflow: workflow,
                            },
                            success: function(data) {
                                var table = $('#service_table').DataTable();
                                var entities = data.entities;
                                var datas = data.datas;
                                if (workflow && Employee == '') {
                                    $("#initiatorName").empty();
                                    var wfOption = '<option value=""> Select Workflow Name</option>';
                                    $("#initiatorName").append(wfOption);
                                    $.each(datas, function(key, val) {
                                        initiatorItems = "<option  value=" + val.id + ">" + val
                                            .first_name + "(" + val.sap_id + ")</option>";
                                        $("#initiatorName").append(initiatorItems);
                                    });
                                }
                                table.clear().draw();
                                $.each(entities, function(key, val) {
                                    var sNo = key + 1;
                                    var projectCode = val.projectCode;
                                    var projectName = val.projectName;
                                    var workflowName = val.workflowName;
                                    var workflowCode = val.workflowCode;
                                    var workflowLevel = val.workflowLevel;
                                    var dueDate = val.dueDate;
                                    var noOfDays = val.noOfDays;
                                    var initiater = val.initiater;
                                    var department = val.department;
                                    var projectId = val.projectId;
                                    var activeStatus = "";

                                    var editurl = '{{ route('viewDocListing', ':id') }}';
                                    editurl = editurl.replace(':id', projectId);
                                    var viewBtn = '<div id=' + projectId +
                                    ' class="btn btn-success viewDocs">View</div>';
                                    table.row.add([projectCode, projectName, workflowCode,
                                        workflowName, initiater, department, workflowLevel,
                                        dueDate, noOfDays, activeStatus, viewBtn
                                    ]).draw();
                                });
                                $('#initiatorName  option:selected').prop("selected", false);


                            },
                            error: function() {
                                $("#otp_error").text("Update Error");
                            }

                        });

                    }
                });
            $('.resetBtn').on('click', function() {
                console.log("well");
                $('#workflowCode,#initiatorName').val("").trigger('change');
                location.reload();
            });
            $(document).on('click', '.viewDocs', function () {
    console.log("well and good");
    var id = $(this).attr('id');


    var url = "{{route('viewDocListing')}}";
    var form = $('<form action="' + url + '" method="post">' +
        ' {{ csrf_field() }} <input type="hidden" name="id" value="' + id + '" />' +
        '</form>');
    $('body').append(form);
    form.submit();
});

            function exportData() {
                /* Get the HTML data using Element by Id */
                var table = document.getElementById("service_table");

                /* Declaring array variable */
                var rows = [];

                //iterate through rows of table
                for (var i = 0, row; row = table.rows[i]; i++) {
                    //rows would be accessed using the "row" variable assigned in the for loop
                    //Get each cell value/column from the row
                    column1 = row.cells[0].innerText;
                    column2 = row.cells[1].innerText;
                    column3 = row.cells[2].innerText;
                    column4 = row.cells[3].innerText;
                    column5 = row.cells[4].innerText;
                    column6 = row.cells[5].innerText;
                    column7 = row.cells[6].innerText;
                    column8 = row.cells[7].innerText;
                    column9 = row.cells[8].innerText;
                    column10 = row.cells[9].innerText;

                    /* add a new records in the array */
                    rows.push(
                        [
                            column2,
                            column3,
                            column4,
                            column5,
                            column6,
                            column7,
                            column8,
                            column9,
                            column10,
                        ]
                    );

                }
                csvContent = "data:text/csv;charset=utf-8,";

                /* add the column delimiter as comma(,) and each row splitted by new line character (\n) */
                rows.forEach(function(rowArray) {
                    row = rowArray.join(",");
                 csvContent += row + "\r\n";
                });

                var encodedUri = encodeURI(csvContent);
                var link = document.createElement("a");
                link.setAttribute("href", encodedUri);
                link.setAttribute("download", "userwiseReport.csv");
                document.body.appendChild(link);
                link.click();
            }
        </script>
    @endsection

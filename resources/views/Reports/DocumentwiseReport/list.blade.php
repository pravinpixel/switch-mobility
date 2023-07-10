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
                        Documentwise Report</h1>
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
                        <li class="breadcrumb-item text-muted">Documentwise Report</li>
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
                            <div class="row col-md-12">

                                <div class="col-md-3" id="workflowCodeField">
                                    <label class=" fs-6 fw-semibold mb-2">workflow Name & Code</label>
                                    <select name="workflowCode" id="workflowCode" class="form-select workFlow">
                                        <option value="">Select workflow </option>
                                        @foreach ($workflowDatas as $workflowData)
                                        <option value="{{ $workflowData->id }}">
                                            {{ $workflowData->workflow_name }}({{ $workflowData->workflow_code }})
                                        </option>
                                        @endforeach

                                    </select>


                                </div>
                                <div class="col-md-3" id="documentNameField">
                                    <!--begin::Label-->
                                    <label class=" fs-6 fw-semibold mb-2">Document Name </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <!--begin::Input-->
                                    <select name="documentName" id="documentName" class="form-select documentType">
                                        <option value=""> Select Workflow Name</option>


                                    </select>

                                </div>
                                <div class="col-md-3" id="projectNameField">
                                    <!--begin::Label-->
                                    <label class=" fs-6 fw-semibold mb-2">Project Name & Code</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <select name="projectName" id="projectName" class="form-select projectName">
                                        <option value=""> Select Project Name</option>

                                    </select>
                                </div>
                                <div class="col-md-1">
                                    <label class="fs-6 fw-semibold mb-2">&nbsp;</label>
                                    <button class="btn btn-warning badge badge-secondary" onclick="reset()">Reset</button>
                                </div>
                                &nbsp;&nbsp;&nbsp;&nbsp;
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

                        </div>
                        <!--begin::Card title-->
                        <!--begin::Table-->
                        <table class="table align-middle table-row-bordered fs-6 gy-5" id="service_table">
                            <!--begin::Table head-->
                            <thead>
                                <!--begin::Table row-->
                                <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">

                                    
                                    <th>Workflow Code</th>
                                    <th>Workflow Name</th>
                                    <th>Initiator</th>
                                    <th>Department</th>
                                    <th>Level</th>
                                    <th>Due Date</th>
                                    <th>No of Days</th>
                                    <th>status</th>
                                    <th>Actions</th>
                                </tr>
                                <!--end::Table row-->
                            </thead>
                            <!--end::Table head-->
                            <!--begin::Table body-->
                            <tbody class="text-gray-600 fw-semibold" id="tableContent">
                                @foreach($entities as $entity )
                                <tr>
                                   
                                    <td>{{$entity['workflowCode']}}</td>
                                    <td>{{$entity['workflowName']}}</td>
                                    <td>{{$entity['initiater']}}</td>
                                    <td>{{$entity['department']}}</td>
                                    <td>{{$entity['workflowLevel']}}</td>
                                    <td>{{$entity['dueDate']}}</td>
                                    <td>{{$entity['noOfDays']}}</td>
                                    <td></td>
                                    <td>
                                        <div id="{{$entity['projectId']}}" class="btn switchPrimaryBtn  viewDocs">View</div>
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




<script>
    $(document).ready(
        function() {

            console.log("well");
            $("#projectName").select2({
                dropdownParent: $("#projectNameField")
            });
            $("#workflowCode").select2({
                dropdownParent: $("#workflowCodeField")
            });
            $("#documentName").select2({
                dropdownParent: $("#documentNameField")
            });

            $('#workflowCode').on('change', function() {
                $("#documentName").empty();
                var wfOptiondata = '<option value=""> Select Workflow Name</option>';
                $("#documentName").append(wfOptiondata);
                $("#projectName").empty();
                var projectOptiondata = '<option value=""> Select Project Name</option>';
                $("#projectName").append(projectOptiondata);

            });
            $('#documentName,#projectName,#workflowCode').on('change', function() {
                filterData();
            });
            $(document).on('click', '.viewDocs', function() {
                console.log("well and good");
                var id = $(this).attr('id');


                var url = "{{route('viewDocListing')}}";
                var form = $('<form action="' + url + '" method="post">' +
                    ' {{ csrf_field() }} <input type="hidden" name="id" value="' + id + '" />' +
                    '</form>');
                $('body').append(form);
                form.submit();
            });

            function filterData() {

                var workflow = $('#workflowCode').val();
                var docuName = $('#documentName').val();
                var projectName = $('#projectName').val();
                if (workflow || docuName || projectName !== '') {
                    $.ajax({
                        url: "{{ route('documnetWiseReportSearchFilter') }}",
                        type: 'ajax',
                        method: 'post',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            workflowCode: workflow,
                            docuName: docuName,
                            projectName: projectName,
                        },
                        success: function(data) {
                            var table = $('#service_table').DataTable();
                            var entities = data.entities;
                            console.log(entities);
                            var documents = data.document;
                            if (workflow && docuName == '') {
                                $("#documentName").empty();
                                var docOption = '<option value=""> Select Workflow Name</option>';
                                $("#documentName").append(docOption);
                                var documentitems = "";
                                $.each(documents, function(key, val) {
                                    documentitems += "<option  value=" + val.id + ">" + val
                                        .name + "</option>";
                                });
                                $("#documentName").append(documentitems);
                            }
                            table.clear().draw();
                            if (projectName == '') {
                                $("#projectName").empty();
                                var projectOption = '<option value=""> Select Project Name</option>';
                                $("#projectName").append(projectOption);
                            }
                                $.each(entities, function(key, val) {
                                    console.log(entities);
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

                                    var viewBtn = '<div id=' + projectId +
                                        ' class="btn switchPrimaryBtn  viewDocs">View</div>';
                                    var projectNameOptionItems = "<option value=" + projectId +
                                        ">" +
                                        projectName + "(" + projectCode + ")</option>";
                                    $("#projectName").append(projectNameOptionItems);
                                    table.row.add([workflowCode, workflowName, initiater,
                                        department, workflowLevel, dueDate, noOfDays,
                                        activeStatus, viewBtn
                                    ]).draw();

                                });
                            
                        },
                        error: function() {
                            $("#otp_error").text("Update Error");
                        }
                    });

                }

            }
        });

    function reset() {
        $('#documentName,#projectName,#workflowCode').val("").trigger('change');
        location.reload();
        // $("#service_table").load(location.href + " #service_table").abort();



    }

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
          

            /* add a new records in the array */
            rows.push(
                [
                    column1,
                    column2,
                    column3,
                    column4,
                    column5,
                    column6,
                    column7,
                    column8,
                    column9,
                  
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
        link.setAttribute("download", "DocumnetwiseReports.csv");
        document.body.appendChild(link);
        link.click();
    }
</script>
@endsection

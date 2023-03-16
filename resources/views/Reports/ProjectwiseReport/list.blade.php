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
                    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Projectwise Report</h1>
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
                        <li class="breadcrumb-item text-muted">Projectwise Report</li>
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
                                <div class="col-md-3" style="display:inline;" id="departmentField">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-semibold mb-2">Department</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <select name="department" id="department" class="form-select">
                                        <option value="">Select Department</option>
                                        @foreach($departmentDatas as $departmentData)
                                        <option value="{{$departmentData->id}}">{{$departmentData->name}}</option>
                                        @endforeach
                                    </select>


                                </div>
                                <div class="col-md-3" style="display:inline;" id="workflowCodeField">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-semibold mb-2">Workflow Name & Code</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <select name="workflowCode" id="workflowCode" class="form-select">
                                        <option value="">First Select Department</option>
                                        <!-- @foreach($workflowDatas as $workflowData)
                                        <option value="{{$workflowData->id}}">{{$workflowData->workflow_name}}({{$workflowData->workflow_code}})</option>
                                        @endforeach -->
                                    </select>


                                </div>
                                <div class="col-md-3" style="display:inline;" id="projectNameField">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-semibold mb-2">Project Name & Code</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <select name="projectName" id="projectName" class="form-select">
                                        <option value="">First Select Department & Workflow</option>
                                        <!-- @foreach($projectDatas as $projectdata)
                                        <option value="{{$projectdata->id}}">{{$projectdata->project_name}}({{$projectdata->project_code}}) </option>
                                        @endforeach -->
                                    </select>


                                </div>

                                <div class="col-md-2" style="display:none;" id="projectCodeField">
                                    <!--begin::Label-->

                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <select name="status" id="status" class="form-select">
                                        <option value="">Select Status</option>
                                        @foreach($projectDatas as $projectdata)
                                        <option value="{{$projectdata->id}}">{{$projectdata->project_code}}</option>
                                        @endforeach
                                    </select>


                                </div>
                                <div class="col-md-1">
                                    <label class="fs-6 fw-semibold mb-2">&nbsp;</label>
                                    <button class="btn btn-warning resetBtn">Reset</button>
                                </div>
                            </div> <br>


                        </div>



                    </div>
                    <!--end::Card header-->
                    <!--begin::Card body-->
                    <div class="card-body py-4">
                        <!--begin::Card title-->
                        <div class="card-title">
                            <!--begin::Search-->
                            <div class="d-flex align-items-center position-relative my-1" style="display: none;">
                                <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                                <!-- <span class="svg-icon svg-icon-1 position-absolute ms-6">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor" />
                                        <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="currentColor" />
                                    </svg>
                                </span> -->
                                <!--end::Svg Icon-->
                                <input type="text" class="form-control form-control-solid w-250px ps-14 deptSearch" placeholder="Search" style="display: none;" />
                            </div>
                            <!--end::Search-->
                        </div>
                        <!--begin::Card title-->
                        <!--begin::Table-->
                        <table class="table align-middle table-row-dashed fs-6 gy-5" id="service_table">
                            <!--begin::Table head-->
                            <thead>
                                <!--begin::Table row-->
                                <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">

                                    <th>S.no</th>
                                    <th>Project Code</th>
                                    <th>Project Name</th>
                                    <th>Workflow Name</th>
                                    <th>Workflow Code</th>
                                    <th>Initiater</th>
                                    <th>Department</th>
                                    <th>Level</th>
                                    <th>Due Date</th>
                                    <th>No Of Days</th>
                                    <th>Status</th>
                                    <th>Action</th>

                                </tr>
                                <!--end::Table row-->
                            </thead>
                            <!--end::Table head-->
                            <!--begin::Table body-->
                            <tbody class="text-gray-600 fw-semibold" id="tableContent">
                                @foreach($entities as $entity)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$entity['projectCode']}}</td>
                                    <td>{{$entity['projectName']}}</td>
                                    <td>{{$entity['workflowName']}}</td>
                                    <td>{{$entity['workflowCode']}}</td>
                                    <td>{{$entity['initiater']}}</td>
                                    <td>{{$entity['department']}}</td>
                                    <td>{{$entity['workflowLevel']}}</td>
                                    <td>{{$entity['dueDate']}}</td>
                                    <td>{{$entity['noOfDays']}}</td>
                                    <td></td>
                                    <td><a href={{route("viewDocListing",$entity['projectId']) }} class="btn btn-primary">View</a></td>

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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script>
    $(document).ready(
        function() {

            $("#projectName").select2({
                dropdownParent: $("#projectNameField")
            });
            $("#workflowCode").select2({
                dropdownParent: $("#workflowCodeField")
            });
            $("#department").select2({
                dropdownParent: $("#departmentField")
            });


            var table = $('#service_table').DataTable({
                filter: true,
                "lengthMenu": [
                    [10, 25, 50, -1],
                    [10, 25, 50, "All"]
                ],
                "searching": true,
            });



            $('#department').on('change', function() {
                $("#workflowCode").empty();
                var wfOptiondata = '<option value="">First Select Department</option>';
                $("#workflowCode").append(wfOptiondata);

                $("#projectName").empty();
                var wfOptiondata = '<option value="">First Select Department & Workflow</option>';
                $("#projectName").append(wfOptiondata);

             

            });

            $('#department,#projectName,#workflowCode').on('change', function() {
                filterData();
            });





            function filterData() {
                console.log("well");

                var department = ($('#department').val()) ? $('#department').val() : "";
                var projectName = ($('#projectName').val()) ? $('#projectName').val() : "";
                var workflowCode = ($('#workflowCode').val()) ? $('#workflowCode').val() : "";


                if (department) {
                    $.ajax({
                        url: "{{ route('projectwiseReportSearchFilter') }}",
                        type: 'ajax',
                        method: 'post',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            department: department,
                            projectId: projectName,
                            workflowId: workflowCode,
                        },
                        success: function(data) {
                            $("#projectName").empty();
                            var entities = data.entities;
                            var workflowData = data.workflowDatas;
                            if (department && workflowCode == "") {


                                $("#workflowCode").empty();
                                var wfOptiondata = '<option value="">Select Workflow Name & Code</option>';
                                $("#workflowCode").append(wfOptiondata);
                                var workflowitems = "";
                                $.each(workflowData, function(key, val) {
                                    console.log(val);
                                    workflowitems += "<option value=" + val.id + ">" + val.workflow_name + "(" + val.workflow_code + ")</option>";
                                });
                                $("#workflowCode").append(workflowitems);
                            }

                            table.clear().draw();

                            var projectNameOptionData = '<option value="">Select Project Name & Code</option>';
                            $("#projectName").append(projectNameOptionData);
                            var projectNameOptionItems = "";
                            $.each(entities, function(key, val) {
                                var sNo = key + 1;
                                var projectCode = val.projectCode;
                                var projectName = val.projectName;
                                var workflowId = val.workflowId;
                                var workflowName = val.workflowName;
                                var workflowCode = val.workflowCode;
                                var workflowLevel = val.workflowLevel;
                                var dueDate = val.dueDate;
                                var noOfDays = val.noOfDays;

                                var initiater = val.initiater;
                                var department = val.department;
                                var projectId = val.projectId;
                                var activeStatus = "";

                                var editurl = '{{ route("viewDocListing", ":id") }}';
                                editurl = editurl.replace(':id', projectId);
                                var viewBtn = '<a href=' + editurl + ' class="btn btn-primary">View</a>';

                                projectNameOptionItems += "<option value=" + projectId + ">" + projectName + "(" + projectCode + ")</option>";
                                table.row.add([sNo, projectCode, projectName, workflowName, workflowCode, initiater, department, workflowLevel, dueDate, noOfDays, activeStatus, viewBtn]).draw();
                            });
                            console.log(projectNameOptionItems);
                            // $("#workflowCode").html("");
                            $("#projectName").append(projectNameOptionItems);
                            $("#projectName").val(projectName);
                        },
                        error: function() {
                            $("#otp_error").text("Update Error");
                        }

                    });
                }
            }
            $('.resetBtn').on('click', function() {
                console.log("well");
                $('#department').val("").trigger('change');
            });
        });
</script>
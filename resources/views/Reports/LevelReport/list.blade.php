@extends('layouts.app')

@section('content')
<style>
    .green-bg {
        background-color: #13ce36 !important;
    }

    .red-bg {
        background-color: red !important;
    }

    .yellow-bg {
        background-color: #ecab3c !important;
    }

    table.table.dataTable td.levelTd {
        color: white !important;
        max-width: 144px !important;
        min-width: 144px !important;


    }

    table.table.dataTable td,
    table.table.dataTable th {
        border: 1px solid lightgrey;
    }

    .view-button {
        display: inline-block;
        padding: 5px 10px;
        /* Adjust the padding to control the button size */
        background-color: #3565ed;
        color: #fff;
        text-decoration: none;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    .view-button:hover {
        background-color: #3565ed;
        /* Change to a darker shade of blue on hover */
        color: #fff;
        /* Maintain the text color as white on hover */
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
                    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Level Report</h1>
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
                        <li class="breadcrumb-item text-muted">Level Report</li>
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
                    <div class="card-header border-0 p-3">
                        <h3>Level Report - As on {{$todayDate}}</h3>
                        <div class="card-title col-12">
                            <div class="row col-12">
                                <div class="col-md-4">
                                    <label class="fs-6 form-label fw-bold text-dark "> WorkFlow Name / Code </label>
                                    <!--begin::Select-->
                                    <select class="form-select workflowFilter" name="workflow_code_name" data-kt-select2="true" data-placeholder="WorkFlow Name (Code)" data-allow-clear="false" id="workflow">
                                        <option></option>
                                        @foreach ($workflowModels as $wf)
                                        <option value="{{ $wf['id'] }}">
                                            {{ $wf['workflow_name'] }} ({{ $wf['workflow_code'] }})
                                        </option>
                                        @endforeach
                                    </select>
                                    <!--end::Select-->
                                </div>
                                <div class="col-md-3">
                                    <label class="fs-6 form-label fw-bold text-dark "> Project Name / Code </label>
                                    <!--begin::Select-->
                                    <select class="form-select projectFilter" name="project_code_name" data-kt-select2="true" data-placeholder="Project Name (Code)" data-allow-clear="false" id="project_code_name">
                                        <option></option>

                                    </select>
                                    <!--end::Select-->
                                </div>


                                <div class="w-auto" onclick="filterData()">
                                    <label class="fs-6 d-block fw-semibold mb-2">&nbsp;</label>
                                    <button class="btn switchPrimaryBtn ">Search</button>
                                </div>
                                <div class="w-auto">
                                    <label class="fs-6 fw-semibold mb-2 d-block">&nbsp;</label>
                                    <button class="btn btn-warning resetBtn  ">Reset</button>
                                </div>

                            </div>
                        </div>



                    </div>
                    <hr/>
                    <!--end::Card header-->
                    <!--begin::Card body-->
                    <div class="card-body  p-3">
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
                                <input type="text" style="display: none;" class="form-control form-control-solid w-250px ps-14 deptSearch" placeholder="Search" />
                            </div>
                            <!--end::Search-->
                        </div>
                        <!--begin::Card title-->
                        <!--begin::Table-->
                        <table class=" levelReporttable align-middle  fs-6 gy-5 table" id="service_table">
                            <!--begin::Table head-->
                            <thead>
                                <!--begin::Table row-->
                                <tr class="text-start align-middle text-muted fw-bold fs-7 text-uppercase gs-0">



                                    <th>Workflow</th>
                                    <th>Project Name</th>
                                    <th>Document Name</th>
                                    <th>Level 1</th>
                                    <th>Level 2</th>
                                    <th>Level 3</th>
                                    <th>Level 4</th>
                                    <th>Level 5</th>
                                    <th>Level 6</th>
                                    <th>Level 7</th>
                                    <th>Level 8</th>
                                    <th>Level 9</th>
                                    <th>Level 10</th>
                                    <th>Level 11</th>
                                </tr>
                                <!--end::Table row-->
                            </thead>
                            <!--end::Table head-->
                            <!--begin::Table body-->
                            <tbody class="text-gray-600 fw-semibold" id="tableContent">
                                @foreach($tableDatas as $key=>$tableData)
                                <tr>
                                    <td>{{$tableData['wfName'] }}</td>
                                    <td>{{$tableData['projectName']}}</td>
                                    <td>{{$tableData['docName']}}</td>
                                    <?php
                                    $dynamicLevelStatusData = $tableDatas[$key]['dynamicLevelStatusData'];
                                    $dynamicLevelStatusId = $tableDatas[$key]['dynamicLevelStatusId'];


                                    $dynamicLevelRowResDatas = $tableDatas[$key]['dynamicLevelRowResDatas'];
                                    // Access the array within $tableDatas
                                    $level1BgColorStyle = (isset($dynamicLevelStatusData['level1Status'])) ? $dynamicLevelStatusData['level1Status'] : 'green-bg';
                                    $level2BgColorStyle = (isset($dynamicLevelStatusData['level2Status'])) ? $dynamicLevelStatusData['level2Status'] : 'green-bg';
                                    $level3BgColorStyle = (isset($dynamicLevelStatusData['level3Status'])) ? $dynamicLevelStatusData['level3Status'] : 'green-bg';
                                    $level4BgColorStyle = (isset($dynamicLevelStatusData['level4Status'])) ? $dynamicLevelStatusData['level4Status'] : 'green-bg';
                                    $level5BgColorStyle = (isset($dynamicLevelStatusData['level5Status'])) ? $dynamicLevelStatusData['level5Status'] : 'green-bg';
                                    $level6BgColorStyle = (isset($dynamicLevelStatusData['level6Status'])) ? $dynamicLevelStatusData['level6Status'] : 'green-bg';
                                    $level7BgColorStyle = (isset($dynamicLevelStatusData['level7Status'])) ? $dynamicLevelStatusData['level7Status'] : 'green-bg';
                                    $level8BgColorStyle = (isset($dynamicLevelStatusData['level8Status'])) ? $dynamicLevelStatusData['level8Status'] : 'green-bg';
                                    $level9BgColorStyle = (isset($dynamicLevelStatusData['level9Status'])) ? $dynamicLevelStatusData['level9Status'] : 'green-bg';
                                    $level10BgColorStyle = (isset($dynamicLevelStatusData['level10Status'])) ? $dynamicLevelStatusData['level10Status'] : 'green-bg';
                                    $level11BgColorStyle = (isset($dynamicLevelStatusData['level11Status'])) ? $dynamicLevelStatusData['level11Status'] : 'green-bg';

                                    ?>


                                    <td class="@if($tableData['getLastLevel'] >= 1){{$level1BgColorStyle}}@endif levelTd">
                                        @if(isset($dynamicLevelStatusData['level1Status']) && isset($dynamicLevelRowResDatas['level1levelResData']))
                                        <?php echo $dynamicLevelRowResDatas['level1levelResData']; ?>
                                        @endif


                                    </td>
                                    <td class="@if($tableData['getLastLevel'] >= 2){{$level2BgColorStyle}}@endif levelTd">
                                        @if(isset($dynamicLevelStatusData['level2Status']) && isset($dynamicLevelRowResDatas['level2levelResData']))
                                        <?php echo $dynamicLevelRowResDatas['level2levelResData']; ?>
                                        @endif
                                    </td>
                                    <td class="@if($tableData['getLastLevel'] >= 3){{$level3BgColorStyle}}@endif levelTd">

                                        @if(isset($dynamicLevelStatusData['level3Status']) && isset($dynamicLevelRowResDatas['level3levelResData']))
                                        <?php echo $dynamicLevelRowResDatas['level3levelResData']; ?>
                                        @endif

                                    </td>
                                    <td class="@if($tableData['getLastLevel'] >= 4){{$level4BgColorStyle}}@endif levelTd">

                                        @if(isset($dynamicLevelStatusData['level4Status']) && isset($dynamicLevelRowResDatas['level4levelResData']))
                                        <?php echo $dynamicLevelRowResDatas['level4levelResData']; ?>
                                        @endif

                                    </td>
                                    <td class="@if($tableData['getLastLevel'] >= 5){{$level5BgColorStyle}}@endif levelTd">
                                        @if(isset($dynamicLevelStatusData['level5Status']) && isset($dynamicLevelRowResDatas['level5levelResData']))
                                        <?php echo $dynamicLevelRowResDatas['level5levelResData']; ?>
                                        @endif

                                    </td>
                                    <td class="@if($tableData['getLastLevel'] >= 6){{$level6BgColorStyle}}@endif levelTd">

                                        @if(isset($dynamicLevelStatusData['level6Status']) && isset($dynamicLevelRowResDatas['level6levelResData']))
                                        <?php echo $dynamicLevelRowResDatas['level6levelResData']; ?>
                                        @endif

                                    </td>
                                    <td class="@if($tableData['getLastLevel'] >= 7){{$level7BgColorStyle}}@endif levelTd">

                                        @if(isset($dynamicLevelStatusData['level7Status']) && isset($dynamicLevelRowResDatas['level7levelResData']))
                                        <?php echo $dynamicLevelRowResDatas['level7levelResData']; ?>
                                        @endif

                                    </td>
                                    <td class="@if($tableData['getLastLevel'] >= 8){{$level8BgColorStyle}}@endif levelTd">

                                        @if(isset($dynamicLevelStatusData['level8Status']) && isset($dynamicLevelRowResDatas['level8levelResData']))
                                        <?php echo $dynamicLevelRowResDatas['level8levelResData']; ?>
                                        @endif

                                    </td>
                                    <td class="@if($tableData['getLastLevel'] >= 9){{$level9BgColorStyle}}@endif levelTd">
                                        @if(isset($dynamicLevelStatusData['level9Status']) && isset($dynamicLevelRowResDatas['level9levelResData']))
                                        <?php echo $dynamicLevelRowResDatas['level9levelResData']; ?>
                                        @endif

                                    </td>
                                    <td class="@if($tableData['getLastLevel'] >= 10){{$level10BgColorStyle}}@endif levelTd">
                                        @if(isset($dynamicLevelStatusData['level10Status']) && isset($dynamicLevelRowResDatas['level10levelResData']))
                                        <?php echo $dynamicLevelRowResDatas['level10levelResData']; ?>
                                        @endif

                                    </td>
                                    <td class="@if($tableData['getLastLevel'] >= 11){{$level11BgColorStyle}}@endif levelTd">

                                        @if(isset($dynamicLevelStatusData['level11Status']) && isset($dynamicLevelRowResDatas['level11levelResData']))
                                        <?php echo $dynamicLevelRowResDatas['level11levelResData']; ?>
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





<script>
    $(document).ready(
        function() {


            var todayDate = new Date();
            var today = todayDate.toISOString().substr(0, 10);



            todayDate.setDate(todayDate.getDate() - 6); //number  of days to add, e.x. 15 days
            var nextSixDay = todayDate.toISOString().substr(0, 10);


            //filterData(nextSixDay,today);



            $('.workflowFilter').on('change', function() {
                console.log("well an good");
                var dropdown = $(".projectFilter");

                // Initialize Select2 on the dropdown element
                dropdown.select2();
                dropdown.empty();
                filterData();
            });
        });
    $(document).on('click', '.view-button', function() {
        console.log("well and good");

        var id = $(this).attr('id');
        var levelId = $(this).attr('data-id');

        var url = "{{ route('viewDocListing') }}";
        var form = $('<form action="' + url + '" method="post">' +
            ' {{ csrf_field() }} <input type="hidden" name="id" value="' + id + '" /><input type="hidden" name="levelId" value="' + levelId + '" />' +
            '</form>');
        $('body').append(form);
        form.submit();
    });
    $('.resetBtn').on('click', function() {

        location.reload();
        // $("#service_table").load(location.href + " #service_table");
    });


    function filterData() {
        console.log("well");
        var projectId = $('.projectFilter').val();
        var wfId = $('.workflowFilter').val();
        console.log(projectId);
        console.log(wfId);
        if (projectId || wfId) {
            $.ajax({
                url: "{{ route('levelwiseReportSearchFilter') }}",
                type: 'ajax',
                method: 'post',
                data: {
                    "_token": "{{ csrf_token() }}",
                    projectId: projectId,
                    wfId: wfId,
                },
                success: function(resData) {
                    console.log(resData);
                    var entities = resData.entities;
                    console.log(resData.projectDataModels);
                    if (!projectId) {
                        var dropdown = $(".projectFilter");

                        // Initialize Select2 on the dropdown element
                        dropdown.select2();
                        dropdown.empty();
                        var option = new Option("Project Code/Name", "");
                        dropdown.append(option);
                        // Assuming 'resData.projectDataModels' is your AJAX response
                        $.each(resData.projectDataModels, function(index, item) {
                            var dataf = item.projectName + ' (' + item.projectCode + ')';

                            // Create a new option and append it to the Select2 dropdown
                            var option = new Option(dataf, item.projectId);
                            dropdown.append(option);
                        });

                        // Trigger an event to refresh Select2 after populating data
                        dropdown.trigger('change');
                    }
                    var table = $('#service_table').DataTable();
                    table.clear().draw();
                    // var tableContent = $("#service_table tbody");
                    // tableContent.empty();
                    // Clear the existing rows from the table's body


                    $.each(resData.tableDatas, function(index, val) {
                        console.log(val);

                        var rowresData = val.dynamicLevelRowResDatas;
                        var rowStatusData = val.dynamicLevelStatusData;
                        var rowStatusId = val.dynamicLevelStatusId;
                        var docName = val.docName;
                        var projectrowId = val.projectId;
                        var projectName = val.projectName;
                        var workflowName = val.wfName;


                        var level1levelStatusData = (rowStatusData.level1Status) ? rowStatusData.level1Status : "green-bg";
                        var level2levelStatusData = (rowStatusData.level2Status) ? rowStatusData.level2Status : "green-bg";
                        var level3levelStatusData = (rowStatusData.level3Status) ? rowStatusData.level3Status : "green-bg";
                        var level4levelStatusData = (rowStatusData.level4Status) ? rowStatusData.level4Status : "green-bg";
                        var level5levelStatusData = (rowStatusData.level5Status) ? rowStatusData.level5Status : "green-bg";
                        var level6levelStatusData = (rowStatusData.level6Status) ? rowStatusData.level6Status : "green-bg";
                        var level7levelStatusData = (rowStatusData.level7Status) ? rowStatusData.level7Status : "green-bg";
                        var level8levelStatusData = (rowStatusData.level8Status) ? rowStatusData.level8Status : "green-bg";
                        var level9levelStatusData = (rowStatusData.level9Status) ? rowStatusData.level9Status : "green-bg";
                        var level10levelStatusData = (rowStatusData.level10Status) ? rowStatusData.level10Status : "green-bg";
                        var level11levelStatusData = (rowStatusData.level11Status) ? rowStatusData.level11Status : "green-bg";

                        var level1levelResData = (rowresData.level1levelResData) ? rowresData.level1levelResData : "";
                        var level2levelResData = (rowresData.level2levelResData) ? rowresData.level2levelResData : "";
                        var level3levelResData = (rowresData.level3levelResData) ? rowresData.level3levelResData : "";
                        var level4levelResData = (rowresData.level4levelResData) ? rowresData.level4levelResData : "";
                        var level5levelResData = (rowresData.level5levelResData) ? rowresData.level5levelResData : "";
                        var level6levelResData = (rowresData.level6levelResData) ? rowresData.level6levelResData : "";
                        var level7levelResData = (rowresData.level7levelResData) ? rowresData.level7levelResData : "";
                        var level8levelResData = (rowresData.level8levelResData) ? rowresData.level8levelResData : "";
                        var level9levelResData = (rowresData.level9levelResData) ? rowresData.level9levelResData : "";
                        var level10levelResData = (rowresData.level10levelResData) ? rowresData.level10levelResData : "";
                        var level11levelResData = (rowresData.level11levelResData) ? rowresData.level11levelResData : "";
                        // Create and append a new table row based on your data structure
                        var newRow = "<tr>" +
                            "<td>" + workflowName + "</td>" +
                            "<td>" + projectName + "</td>" +
                            "<td>" + docName + "</td>" +
                            "<td class='" + (val.getLastLevel >= 1 ? level1levelStatusData : "") + " levelTd'>" + level1levelResData + "</td>" +
                            "<td class='" + (val.getLastLevel >= 2 ? level2levelStatusData : "") + " levelTd'>" + level2levelResData + "</td>" +
                            "<td class='" + (val.getLastLevel >= 3 ? level3levelStatusData : "") + " levelTd'>" + level3levelResData + "</td>" +
                            "<td class=' " + (val.getLastLevel >= 4 ? level4levelStatusData : "") + " levelTd'>" + level4levelResData + "</td>" +
                            "<td class='" + (val.getLastLevel >= 5 ? level5levelStatusData : "") + " levelTd'>" + level5levelResData + "</td>" +
                            "<td class='" + (val.getLastLevel >= 6 ? level6levelStatusData : "") + " levelTd'>" + level6levelResData + "</td>" +
                            "<td class='" + (val.getLastLevel >= 7 ? level7levelStatusData : "") + " levelTd'>" + level7levelResData + "</td>" +
                            "<td class='" + (val.getLastLevel >= 8 ? level8levelStatusData : "") + " levelTd'>" + level8levelResData + "</td>" +
                            "<td class='" + (val.getLastLevel >= 9 ? level9levelStatusData : "") + " levelTd'>" + level9levelResData + "</td>" +
                            "<td class='" + (val.getLastLevel >= 10 ? level10levelStatusData : "") + " levelTd'>" + level10levelResData + "</td>" +
                            "<td class='" + (val.getLastLevel >= 11 ? level11levelStatusData : "") + " levelTd'>" + level11levelResData + "</td>" +

                            "</tr>";
                            table.row.add($(newRow)).draw(false);
                       // tableContent.append(newRow);
                    });
                    // $.each(resData.tableDatas, function(key, val) {
                    //     var rowresData = val.dynamicLevelRowResDatas;
                    //     var docName = val.docName;
                    //     // var projectCode = val.projectCode;
                    //     var projectName = val.projectName;
                    //     var workflowName = val.wfName;
                    //     var level1levelResData = (rowresData.level1levelResData) ? rowresData.level1levelResData : "";
                    //     var level2levelResData = (rowresData.level2levelResData) ? rowresData.level2levelResData : "";
                    //     var level3levelResData = (rowresData.level3levelResData) ? rowresData.level3levelResData : "";
                    //     var level4levelResData = (rowresData.level4levelResData) ? rowresData.level4levelResData : "";
                    //     var level5levelResData = (rowresData.level5levelResData) ? rowresData.level5levelResData : "";
                    //     var level6levelResData = (rowresData.level6levelResData) ? rowresData.level6levelResData : "";
                    //     var level7levelResData = (rowresData.level7levelResData) ? rowresData.level7levelResData : "";
                    //     var level8levelResData = (rowresData.level8levelResData) ? rowresData.level8levelResData : "";
                    //     var level9levelResData = (rowresData.level9levelResData) ? rowresData.level9levelResData : "";
                    //     var level10levelResData = (rowresData.level10levelResData) ? rowresData.level10levelResData : "";
                    //     var level11levelResData = (rowresData.level11levelResData) ? rowresData.level11levelResData : "";


                    //     // var initiater = val.initiater;
                    //     // var department = val.department;
                    //     // var projectId = val.projectId;
                    //     // var activeStatus = val.status;
                    //     // var startDate = val.startDate;
                    //     // var endDate = val.endDate;

                    //     // var editurl = '{{ route("viewDocListing", ":id") }}';
                    //     // editurl = editurl.replace(':id', projectId);
                    //     // var viewBtn = '<div id=' + projectId + ' class="btn switchPrimaryBtn  viewDocs">View</div>';


                    //     table.row.add([workflowName, projectName, docName, level1levelResData, level2levelResData, level3levelResData, level4levelResData, level5levelResData, level6levelResData,level7levelResData, level8levelResData, level9levelResData,level10levelResData, level11levelResData]).draw();
                    // });
                },
                error: function() {
                    $("#otp_error").text("Update Error");
                }

            });
        }
    }
</script>
@endsection
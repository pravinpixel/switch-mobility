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
        max-width: 100px !important;
        min-width: 100px !important;
 
   
    }
table.table.dataTable  td , table.table.dataTable  th{
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
                        <h3>Level Report -As on {{$todayDate}}</h3>
                        <div class="card-title col-12">
                            <div class="row col-12">
                                <div class="col-md-3">
                                    <label class="fs-6 form-label fw-bold text-dark "> WorkFlow Code/Name </label>
                                    <!--begin::Select-->
                                    <select class="form-select workflowFilter" name="workflow_code_name" data-kt-select2="true" data-placeholder="WorkFlow Code/Name" data-allow-clear="false" id="workflow">
                                        <option></option>
                                        @foreach ($workflowModels as $wf)
                                        <option value="{{ $wf['id'] }}">
                                            {{ $wf['workflow_name'] }}({{ $wf['workflow_code'] }})
                                        </option>
                                        @endforeach
                                    </select>
                                    <!--end::Select-->
                                </div>
                                <div class="col-md-3">
                                    <label class="fs-6 form-label fw-bold text-dark "> Project Code/Name </label>
                                    <!--begin::Select-->
                                    <select class="form-select projectFilter" name="project_code_name" data-kt-select2="true" data-placeholder="Project Code/Name" data-allow-clear="false" id="project_code_name">
                                        <option></option>
                                        @foreach ($projectDataModels as $projectDataModel)
                                        <option value="{{ $projectDataModel['projectId'] }}">
                                            {{ $projectDataModel['projectName'] }}({{ $projectDataModel['projectCode'] }})
                                        </option>
                                        @endforeach
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
                                <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">



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
                                    <td>{{$tableData['wfName'] }}{{$key}}</td>
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
                                        {{$dynamicLevelRowResDatas['level1levelResData']}}
                                        @endif

                                        @if(isset($dynamicLevelStatusId['level1StatusId'])&&$dynamicLevelStatusId['level1StatusId'] ==4)
                                        <a class="view-button" id="{{ $tableData['projectId']}}">View</a>
                                        @endif
                                    </td>
                                    <td class="@if($tableData['getLastLevel'] >= 2){{$level2BgColorStyle}}@endif levelTd">
                                        @if(isset($dynamicLevelStatusData['level2Status']) && isset($dynamicLevelRowResDatas['level2levelResData']))
                                        {{$dynamicLevelRowResDatas['level2levelResData']}}
                                        @endif
                                        @if(isset($dynamicLevelStatusId['level2StatusId'])&&$dynamicLevelStatusId['level2StatusId'] ==4)
                                        <a class="view-button" id="{{ $tableData['projectId']}}">View</a>
                                        @endif
                                    </td>
                                    <td class="@if($tableData['getLastLevel'] >= 3){{$level3BgColorStyle}}@endif levelTd">

                                        @if(isset($dynamicLevelStatusData['level3Status']) && isset($dynamicLevelRowResDatas['level3levelResData']))
                                        {{$dynamicLevelRowResDatas['level3levelResData']}}
                                        @endif
                                        @if(isset($dynamicLevelStatusId['level3StatusId'])&&$dynamicLevelStatusId['level3StatusId'] ==4)
                                        <a class="view-button" id="{{ $tableData['projectId']}}">View</a>
                                        @endif
                                    </td>
                                    <td class="@if($tableData['getLastLevel'] >= 4){{$level4BgColorStyle}}@endif levelTd">

                                        @if(isset($dynamicLevelStatusData['level4Status']) && isset($dynamicLevelRowResDatas['level4levelResData']))
                                        {{$dynamicLevelRowResDatas['level4levelResData']}}
                                        @endif
                                        @if(isset($dynamicLevelStatusId['level4StatusId'])&&$dynamicLevelStatusId['level4StatusId'] ==4)
                                        <a class="view-button" id="{{ $tableData['projectId']}}">View</a>
                                        @endif
                                    </td>
                                    <td class="@if($tableData['getLastLevel'] >= 5){{$level5BgColorStyle}}@endif levelTd">
                                        @if(isset($dynamicLevelStatusData['level5Status']) && isset($dynamicLevelRowResDatas['level5levelResData']))
                                        {{$dynamicLevelRowResDatas['level5levelResData']}}
                                        @endif
                                        @if(isset($dynamicLevelStatusId['level5StatusId'])&&$dynamicLevelStatusId['level5StatusId'] ==4)
                                        <a class="view-button" id="{{ $tableData['projectId']}}">View</a>
                                        @endif
                                    </td>
                                    <td class="@if($tableData['getLastLevel'] >= 6){{$level6BgColorStyle}}@endif levelTd">

                                        @if(isset($dynamicLevelStatusData['level6Status']) && isset($dynamicLevelRowResDatas['level6levelResData']))
                                        {{$dynamicLevelRowResDatas['level6levelResData']}}
                                        @endif
                                        @if(isset($dynamicLevelStatusId['level6StatusId'])&&$dynamicLevelStatusId['level6StatusId'] ==4)
                                        <a class="view-button" id="{{ $tableData['projectId']}}">View</a>
                                        @endif
                                    </td>
                                    <td class="@if($tableData['getLastLevel'] >= 7){{$level7BgColorStyle}}@endif levelTd">

                                        @if(isset($dynamicLevelStatusData['level7Status']) && isset($dynamicLevelRowResDatas['level7levelResData']))
                                        {{$dynamicLevelRowResDatas['level7levelResData']}}
                                        @endif
                                        @if(isset($dynamicLevelStatusId['level7StatusId'])&&$dynamicLevelStatusId['level7StatusId'] ==4)
                                        <a class="view-button" id="{{ $tableData['projectId']}}">View</a>
                                        @endif
                                    </td>
                                    <td class="@if($tableData['getLastLevel'] >= 8){{$level8BgColorStyle}}@endif levelTd">

                                        @if(isset($dynamicLevelStatusData['level8Status']) && isset($dynamicLevelRowResDatas['level8levelResData']))
                                        {{$dynamicLevelRowResDatas['level8levelResData']}}
                                        @endif
                                        @if(isset($dynamicLevelStatusId['level8StatusId'])&&$dynamicLevelStatusId['level8StatusId'] ==4)
                                        <a class="view-button" id="{{ $tableData['projectId']}}">View</a>
                                        @endif
                                    </td>
                                    <td class="@if($tableData['getLastLevel'] >= 9){{$level9BgColorStyle}}@endif levelTd">
                                        @if(isset($dynamicLevelStatusData['level9Status']) && isset($dynamicLevelRowResDatas['level9levelResData']))
                                        {{$dynamicLevelRowResDatas['level9levelResData']}}
                                        @endif
                                        @if(isset($dynamicLevelStatusId['level9StatusId'])&&$dynamicLevelStatusId['level9StatusId'] ==4)
                                        <a class="view-button" id="{{ $tableData['projectId']}}">View</a>
                                        @endif
                                    </td>
                                    <td class="@if($tableData['getLastLevel'] >= 10){{$level10BgColorStyle}}@endif levelTd">
                                        @if(isset($dynamicLevelStatusData['level10Status']) && isset($dynamicLevelRowResDatas['level10levelResData']))
                                        {{$dynamicLevelRowResDatas['level10levelResData']}}
                                        @endif
                                        @if(isset($dynamicLevelStatusId['level10StatusId'])&&$dynamicLevelStatusId['level10StatusId'] ==4)
                                        <a class="view-button" id="{{ $tableData['projectId']}}">View</a>
                                        @endif
                                    </td>
                                    <td class="@if($tableData['getLastLevel'] >= 11){{$level11BgColorStyle}}@endif levelTd">

                                        @if(isset($dynamicLevelStatusData['level11Status']) && isset($dynamicLevelRowResDatas['level11levelResData']))
                                        {{$dynamicLevelRowResDatas['level11levelResData']}}
                                        @endif
                                        @if(isset($dynamicLevelStatusId['level11StatusId'])&&$dynamicLevelStatusId['level11StatusId'] ==4)
                                        <a class="view-button" id="{{ $tableData['projectId']}}">View</a>
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



            $(".endDate1").change(function() {
                var startDate = $('.startDate').val();
                var endDate = $('.endDate').val();


                if (startDate > endDate) {
                    Swal.fire(
                        'Warning!',
                        'End date should be greater than Start date.',
                        'error'
                    );

                    $('.endDate').val('');
                }
            });


        });
    $(document).on('click', '.view-button', function() {
        console.log("well and good");

        var id = $(this).attr('id');

        var url = "{{ route('viewDocListing') }}";
        var form = $('<form action="' + url + '" method="post">' +
            ' {{ csrf_field() }} <input type="hidden" name="id" value="' + id + '" />' +
            '</form>');
        $('body').append(form);
        form.submit();
    });
    $('.resetBtn').on('click', function() {

        location.reload();
        // $("#service_table").load(location.href + " #service_table");
    });
    $(document).on('change click', '.endDate', function() {
        $('.startDate').attr("max", $(this).val());
    });
    $(document).on('change click', '.startDate', function() {
        $('.endDate').attr("min", $(this).val());
    });

    function filterData(date1 = null, date2 = null) {

        var startDate = ($('.startDate').val()) ? $('.startDate').val() : date1;
        var endDate = ($('.endDate').val()) ? $('.endDate').val() : date2;

        if (startDate && endDate) {
            $.ajax({
                url: "{{ route('dateWiseReportSearchFilter') }}",
                type: 'ajax',
                method: 'post',
                data: {
                    "_token": "{{ csrf_token() }}",
                    startDate: startDate,
                    endDate: endDate,
                },
                success: function(data) {
                    var entities = data.entities;
                    var table = $('#service_table').DataTable();
                    table.clear().draw();

                    $.each(entities, function(key, val) {
                        var sNo = key + 1;
                        var projectCode = val.projectCode;
                        var projectName = val.projectName;
                        var workflowName = val.workflowName;
                        var workflowCode = val.workflowCode;
                        var initiater = val.initiater;
                        var department = val.department;
                        var projectId = val.projectId;
                        var activeStatus = val.status;
                        var startDate = val.startDate;
                        var endDate = val.endDate;

                        var editurl = '{{ route("viewDocListing", ":id") }}';
                        editurl = editurl.replace(':id', projectId);
                        var viewBtn = '<div id=' + projectId + ' class="btn switchPrimaryBtn  viewDocs">View</div>';


                        table.row.add(["", "", "", "", "", "", "", "", "", "", "", "", "", "", ]).draw();
                    });
                },
                error: function() {
                    $("#otp_error").text("Update Error");
                }

            });
        }
    }

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
        link.setAttribute("download", "DatewiseReports.csv");
        document.body.appendChild(link);
        link.click();
    }
</script>
@endsection
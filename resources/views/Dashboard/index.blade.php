@extends('layouts.app')

@section('content')
<style>
    .card.st {
        background-color: #f9f3f3;
    }
</style>
<div class="app-main flex-column flex-row-fluid" id="kt_app_main">
    <!--begin::Content wrapper-->
    <div class="d-flex flex-column flex-column-fluid">
        <!--begin::Toolbar-->
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">

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

                    <!--end::Card header-->
                    <div class="card-body  p-3">

                        <!-- Team -->
                        <section id="team" class="pb-5">
                            <div class="container">
                                <h5 class="section-title h1">Overview</h5>
                                <div class="row responsive-card">
                                    <div class="col-2 d-flex">
                                        <!--begin::Items-->
                                        <a class="bg-gray-100 bg-opacity-70 rounded-2 px-6 py-5"  href="{{url('projects')}}" style="border: none;border-top:5px solid #3565ed">
                                            <!--begin::Symbol-->

                                            <!--end::Symbol-->
                                            <!--begin::Stats-->
                                            <div class="m-0">
                                                @if(auth()->user()->is_super_admin ==1 ||auth()->user()->can('project-view'))
                                                <span>
                                                    @endif
                                                    <!--begin::Number-->
                                                    <span class="text-gray-700 fw-bolder d-block fs-2qx lh-1 ls-n1 mb-1">{{$countArray['totalProjectCount']}}</span>
                                                    <!--end::Number-->
                                                    <!--begin::Desc-->
                                                    <span class="text-gray-500 fw-semibold fs-6">Total Number Of Projects</span>
                                                    @if(auth()->user()->is_super_admin ==1 ||auth()->user()->can('project-view')) <!--end::Desc-->
                                                </span>
                                                @endif
                                            </div>
                                            <!--end::Stats-->
                                        </a>
                                        <!--end::Items-->
                                    </div>
                                    <!-- Team member -->

                                    <!-- ./Team member -->
                                    <!-- Team member -->
                                    <div class="col-2 d-flex">
                                        <!--begin::Items-->
                                        <a class="bg-gray-100 bg-opacity-70 rounded-2 px-6 py-5"  href="{{url('doclisting')}}" style="border: none;border-top:5px solid orange">
                                            <!--begin::Symbol-->

                                            <!--end::Symbol-->
                                            <!--begin::Stats-->

                                            <div class="m-0">
                                                @if(auth()->user()->is_super_admin ==1 ||auth()->user()->can('document-listing-view'))
                                                <span>
                                                    @endif
                                                    <!--begin::Number-->
                                                    <span class="text-gray-700 fw-bolder d-block fs-2qx lh-1 ls-n1 mb-1">{{$countArray['totalDocumentCount']}}</span>
                                                    <!--end::Number-->
                                                    <!--begin::Desc-->
                                                    <span class="text-gray-500 fw-semibold fs-6">Total Number Of Documents</span>
                                                    <!--end::Desc-->
                                            </div>
                                            @if(auth()->user()->is_super_admin ==1 ||auth()->user()->can('project-view')) <!--end::Desc-->
                                            </a>
                                            @endif
                                            <!--end::Stats-->
                                        </div>
                                        <!--end::Items-->
                                  
                                    <!-- ./Team member -->

                                    <!-- Team member -->
                                    <div class="col-2 d-flex">
                                        <!--begin::Items-->
                                        <a class="bg-gray-100 bg-opacity-70 rounded-2 px-6 py-5" href="{{url('doclistingIndex/approved')}}" style="border: none;border-top:5px solid #38eb7a">
                                            <!--begin::Symbol-->

                                            <!--end::Symbol-->
                                            <!--begin::Stats-->
                                            <div class="m-0">
                                                @if(auth()->user()->is_super_admin ==1 ||auth()->user()->can('document-listing-view'))
                                                <span>
                                                    @endif
                                                    <!--begin::Number-->
                                                    <span class="text-gray-700 fw-bolder d-block fs-2qx lh-1 ls-n1 mb-1">{{$countArray['totalApprovedDocumentCount']}}</span>
                                                    <!--end::Number-->
                                                    <!--begin::Desc-->
                                                    <span class="text-gray-500 fw-semibold fs-6">No.of Documents Approved</span>
                                                    <!--end::Desc-->
                                                    @if(auth()->user()->is_super_admin ==1 ||auth()->user()->can('document-listing-view'))
                                                </span>
                                                @endif
                                            </div>
                                            <!--end::Stats-->
                                        </a>
                                        <!--end::Items-->
                                    </div>
                                    <!-- ./Team member -->

                                    <!-- Team member -->
                                    <div class="col-2 d-flex">
                                        <!--begin::Items-->
                                        <a class="bg-gray-100 bg-opacity-70 rounded-2 px-6 py-5" href="{{url('doclistingIndex/pending')}}" style="border: none;border-top:5px solid #3565ed">
                                            <!--begin::Symbol-->

                                            <!--end::Symbol-->
                                            <!--begin::Stats-->
                                            <div class="m-0">
                                                @if(auth()->user()->is_super_admin ==1 ||auth()->user()->can('document-listing-view'))
                                                <span >
                                                    @endif
                                                    <!--begin::Number-->
                                                    <span class="text-gray-700 fw-bolder d-block fs-2qx lh-1 ls-n1 mb-1">{{$countArray['totalPendingDocumentCount']}}</span>
                                                    <!--end::Number-->
                                                    <!--begin::Desc-->
                                                    <span class="text-gray-500 fw-semibold fs-6">No.of Documents Pending</span>
                                                    <!--end::Desc-->
                                                    @if(auth()->user()->is_super_admin ==1 ||auth()->user()->can('document-listing-view'))
                                                </span>
                                                @endif
                                            </div>
                                            <!--end::Stats-->
                                        </a>
                                        <!--end::Items-->
                                    </div>
                                    <!-- ./Team member -->

                                    <!-- Team member -->
                                    <div class="col-2 d-flex" style="">
                                        <!--begin::Items-->
                                        <a class="bg-gray-100 bg-opacity-70 rounded-2 px-6 py-5" href="{{url('doclistingIndex/declined')}}" style="border: none;border-top:5px solid #e6b410">
                                            <!--begin::Symbol-->

                                            <!--end::Symbol-->
                                            <!--begin::Stats-->
                                            <div class="m-0">
                                                @if(auth()->user()->is_super_admin ==1 ||auth()->user()->can('document-listing-view'))
                                                <span >
                                                    @endif
                                                    <!--begin::Number-->
                                                    <span class="text-gray-700 fw-bolder d-block fs-2qx lh-1 ls-n1 mb-1">{{$countArray['totalDeclinedDocumentCount']}}</span>
                                                    <!--end::Number-->
                                                    <!--begin::Desc-->
                                                    <span class="text-gray-500 fw-semibold fs-6">Declined Documents</span>
                                                    <!--end::Desc-->
                                                    @if(auth()->user()->is_super_admin ==1 ||auth()->user()->can('document-listing-view'))
                                                </span>
                                                @endif
                                            </div>
                                            <!--end::Stats-->
                                        </a>
                                        <!--end::Items-->
                                    </div>
                                    <div class="col-2 d-flex">
                                        <!--begin::Items-->
                                        <a class="bg-gray-100 bg-opacity-70 rounded-2 px-6 py-5" href="{{url('doclistingIndex/overdue')}}" style="border: none;border-top:5px solid #38eb7a">
                                            <!--begin::Symbol-->

                                            <!--end::Symbol-->
                                            <!--begin::Stats-->
                                            <div class="m-0">
                                                @if(auth()->user()->is_super_admin ==1 ||auth()->user()->can('document-listing-view'))
                                                <span>
                                                    @endif
                                                    <!--begin::Number-->
                                                    <span class="text-gray-700 fw-bolder d-block fs-2qx lh-1 ls-n1 mb-1">{{$countArray['totalOverDueDocumentCount']}}</span>
                                                    <!--end::Number-->
                                                    <!--begin::Desc-->
                                                    <span class="text-gray-500 fw-semibold fs-6">Documents Overdue</span>
                                                    <!--end::Desc-->
                                                    @if(auth()->user()->is_super_admin ==1 ||auth()->user()->can('document-listing-view'))
                                                </span>
                                                @endif
                                            </div>
                                            <!--end::Stats-->
                                        </a>
                                        <!--end::Items-->
                                    </div>
                                    <!-- ./Team member -->

                                </div>
                                <br>

                                <div class="col-md-12 " style=" display: flex;justify-content: center;flex-wrap:wrap;">
                                    <div class="w-auto">
                                        <!-- <h1 class="text-center">Laravel 9 Dynamic Bar Chart Example - Techsolutionstuff</h1> -->
                                        <div id="barchart_material" style="width: 500px; height: 400px;"></div>
                                    </div>
                                    <div class="w-auto">
                                        <!-- <h1 class="text-center">Laravel 9 Dynamic Bar Chart Example - Techsolutionstuff</h1> -->
                                        <div id="barchart_material1" style="width: 500px; height: 400px;"></div>
                                    </div>
                                </div>
                               
                                <hr>
                                @if(count($approvingProjects)||count($initiatingProjects))
                                <div class="" style="">
                                    <div class="row g-8">
                                        <!--begin::Col-->
                                        <div class="col-md-3">
                                            <label class="fs-6 form-label fw-bold text-dark ">From Date </label>
                                            <input type="date" class="form-control fromDate" name="fromDate" id="fromDate">


                                        </div>

                                        <div class="col-md-3">
                                            <label class="fs-6 form-label fw-bold text-dark ">To Date </label>
                                            <input type="date" class="form-control toDate" name="toDate" id="toDate">

                                        </div>


                                        <div class="w-auto">

                                            <label class="fs-6 fw-semibold mb-2 d-block">&nbsp;</label>
                                            <button class="btn btn-success " onclick="search()">Search</button>

                                        </div>
                                        <div class="w-auto">
                                            <label class="fs-6 fw-semibold mb-2 d-block">&nbsp;</label>
                                            <button class="btn btn-warning resetBtn ">Reset</button>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                @if(count($initiatingProjects))
                                <br>
                                <div class="row">

                                    <h5 class="section-title h1">New Assigning Projects</h5>
                                    <table class="table align-middle table-row-bordered fs-6 gy-5" id="service_table">
                                        <!--begin::Table head-->
                                        <thead>
                                            <!--begin::Table row-->
                                            <tr class="text-end text-muted fw-bold fs-7 text-uppercase gs-0">

                                                <th>Ticket No</th>
                                                <th>Project Code & Name</th>
                                                <th>Work Flow Code & Name</th>
                                                <th>Department</th>
                                                <th>Action</th>
                                            </tr>
                                            <!--end::Table row-->
                                        </thead>
                                        <!--end::Table head-->
                                        <!--begin::Table body-->
                                        <tbody class="text-gray-600 fw-semibold">
                                            <!--begin::Table row-->
                                            @foreach ($initiatingProjects as $key => $d)

                                            <?php
                                            $WorkFlow = $d->workflow;
                                            $initiator = $d->employee;
                                            $department = $initiator->department;
                                            ?>
                                            <tr>
                                                <!--begin::Checkbox-->

                                                <!--end::Checkbox-->
                                                <!--begin::User=-->
                                                <td class="">
                                                    {{ $d->ticket_no }}
                                                </td>

                                                <td>{{ $d->project_name . ' ' . $d->project_code }}</td>
                                                <td>{{ $WorkFlow->workflow_name . ' & ' . $WorkFlow->workflow_code }}</td>

                                                <td>{{ $department->name }}</td>
                                                <td><button class="btn btn-sm switchPrimaryBtn editProject" style="color:white" id="{{ $d->id }}">View</button></td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <br>
                                @endif
                                @if(count($approvingProjects))
                                <div class="row">

                                    <h5 class="section-title h1">Approval Pending Projects</h5>
                                    <table class="table align-middle table-row-bordered fs-6 gy-5" id="service_table1">
                                        <!--begin::Table head-->
                                        <thead>
                                            <!--begin::Table row-->
                                            <tr class="text-muted fw-bold fs-7 text-uppercase gs-0">

                                                <th>Ticket No</th>
                                                <th>Project Name</th>
                                                <th>Project Code</th>
                                                <th>Work Flow Name</th>
                                                <th>Work Flow Code</th>
                                                <th style="width: 140px;">Department</th>
                                                <th style="width: 100px;">Start Date</th>
                                                <th style="width: 100px;">End Date</th>
                                                <th style="width: 100px;">Due Date</th>
                                                <th style="width: 20px;">Level</th>
                                                <th style="width: 20px;">Action</th>

                                            </tr>
                                            <!--end::Table row-->
                                        </thead>
                                        <!--end::Table head-->
                                        <!--begin::Table body-->
                                        <tbody class="text-gray-600 fw-semibold">
                                            <!--begin::Table row-->
                                            @foreach ($approvingProjects as $key => $d)


                                            <tr>
                                                <td>{{ $d['ticketNo'] }}</td>
                                                <td>{{ $d['projectName'] }}</td>
                                                <td>{{ $d['projectCode'] }}</td>

                                                <td>{{ $d['wfname'] }}</td>
                                                <td>{{ $d['wfCode'] }}</td>
                                                <td>{{ $d['department'] }}</td>
                                                <td style="width: 70px;">{{ $d['startDate'] }}</td>
                                                <td style="width: 70px;">{{ $d['endDate'] }}</td>
                                                <td style="width: 80px;">{{ $d['dueDate'] }}</td>
                                                <td style="width: 40px;">{{ $d['level'] }}</td>
                                                <td><button class="btn btn-sm switchPrimaryBtn editDocument" style="color:white" id="{{ $d['projectId'] }}">View</button></td>


                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <br>
                                @endif
                                <div class="row">

                                    <h5 class="section-title h1">Recently Uploaded Documents</h5>
                                    <table class="table align-middle table-row-bordered fs-6 gy-5" id="service_table2">
                                        <!--begin::Table head-->
                                        <thead>
                                            <!--begin::Table row-->
                                            <tr class=" text-muted fw-bold fs-7 text-uppercase gs-0">

                                                <th>Ticket No</th>
                                                <th>Project Code & Name</th>
                                                <th>Work Flow Code & Name</th>
                                                <th>Initiator</th>
                                                <th align="right">Department</th>
                                                <th>Action</th>
                                            </tr>
                                            <!--end::Table row-->
                                        </thead>
                                        <!--end::Table head-->
                                        <!--begin::Table body-->
                                        <tbody class="text-gray-600 fw-semibold">
                                            <!--begin::Table row-->
                                            @foreach ($order_at as $key => $d)

                                            <?php
                                            $WorkFlow = $d->workflow;
                                            $initiator = $d->employee;
                                            $department = $initiator->department;
                                            ?>
                                            <tr>
                                                <!--begin::Checkbox-->

                                                <!--end::Checkbox-->
                                                <!--begin::User=-->
                                                <td class="">
                                                    {{ $d->ticket_no }}
                                                </td>

                                                <td>{{ $d->project_name . ' ' . $d->project_code }}</td>
                                                <td>{{ $WorkFlow->workflow_name . ' & ' . $WorkFlow->workflow_code }}</td>
                                                <td>{{ $initiator->first_name . ' ' . $initiator->last_name }}</td>
                                                <td>{{ $department->name }}</td>
                                                <td><button class="btn btn-sm switchPrimaryBtn editDocument" style="color:white" id="{{ $d->id }}">View</button></td>

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
</div>
</section>
<!-- Team -->
<script>
    
</script>
<style>
     .responsive-card {
        row-gap: 10px;
     }
    .responsive-card > div{
     min-width: 120px !important;

    }
</style>
@endsection
<script data-require="jquery@*" data-semver="3.0.0" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/echarts/5.3.1/echarts.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    $(document).ready(
        function() {
            chart1();
            chart2();
            $(".toDate").change(function() {
                $('.fromDate').attr("max",$(this).val());         
            });
            $(".fromDate").change(function() {
                $('.toDate').attr("min",$(this).val());                             
            });
            $('.resetBtn').on('click', function() {

                location.reload();
                // $("#service_table").load(location.href + " #service_table");
            });

        });


    function chart1() {
        var bars_basic_element = document.getElementById('barchart_material');
        if (bars_basic_element) {
            var totalDocs = "{{$countArray['totalDocumentCount']}}";
            var intervallimit = 1;
            if (totalDocs > 10) {
                intervallimit = 10;
            }

            var bars_basic = echarts.init(bars_basic_element);
            bars_basic.setOption({
                color: ['#3565ed'],
                tooltip: {
                    trigger: 'axis',
                    axisPointer: {
                        type: 'shadow'
                    }
                },
                grid: {
                    left: '3%',
                    right: '4%',
                    bottom: '3%',
                    containLabel: true
                },
                xAxis: [{
                    type: 'category',
                    data: ['Total Docs', 'Approved', 'Declined', 'Pending'],
                    axisTick: {
                        alignWithLabel: true
                    }
                }],
                yAxis: [{
                    type: 'value',
                    interval: intervallimit,
                    name: 'Docs'
                }],
                series: [{
                    name: 'Total',
                    type: 'bar',
                    barWidth: '20%',
                    data: [
                        '{{$countArray["totalDocumentCount"]}}',
                        '{{$countArray["totalApprovedDocumentCount"]}}',
                        '{{$countArray["totalDeclinedDocumentCount"]}}',
                        '{{$countArray["totalPendingDocumentCount"]}}'
                    ]
                }]
            });
        }
    }

    function chart2() {
        var totalProject = "{{$countArray['totalProjectCount']}}";
        var intervallimit = 1;
        if (totalProject > 10) {
            intervallimit = 10;
        }

        var bars_basic_element1 = document.getElementById('barchart_material1');
        if (bars_basic_element1) {

            var bars_basic1 = echarts.init(bars_basic_element1);
            bars_basic1.setOption({
                color: ['#3565ed'],
                tooltip: {
                    trigger: 'axis',
                    axisPointer: {
                        type: 'shadow'
                    }
                },
                grid: {
                    left: '3%',
                    right: '4%',
                    bottom: '3%',
                    containLabel: true
                },
                xAxis: [{
                    type: 'category',
                    data: ['Total Projects', 'Approved', 'Pending', 'Overdue'],
                    axisTick: {
                        alignWithLabel: true
                    }
                }],
                yAxis: [{
                    type: 'value',
                    interval: intervallimit,
                    name: 'Projects'
                }],
                series: [{
                    name: 'Total',
                    type: 'bar',
                    barWidth: '20%',
                    data: [
                        '{{$countArray["totalProjectCount"]}}',
                        '{{$totalAppprovedProjects}}',
                        '{{$totalPendingProjects}}',
                        '{{$totalOverDueProjects}}'
                    ]
                }]
            });
        }
    }

    $(document).on('click', '.editDocument', function() {

        var id = $(this).attr('id');

        var url = "{{ route('editDocument') }}";
        var form = $('<form action="' + url + '" method="post">' +
            ' {{ csrf_field() }} <input type="hidden" name="id" value="' + id + '" />' +
            '</form>');
        $('body').append(form);
        form.submit();
    });
    $(document).on('click', '.editProject', function() {
        var id = $(this).attr('id');
        var url = "{{route('projectEdit')}}";
        var form = $('<form action="' + url + '" method="post">' +
            ' {{ csrf_field() }} <input type="hidden" name="id" value="' + id + '" />' +
            '</form>');
        $('body').append(form);
        form.submit();

    });

    function search() {
        console.log("well done");

        var fromDate = $('.fromDate').val();
        var toDate = $('.toDate').val();
        console.log("fromDate " + fromDate);
        console.log("toDate " + toDate);

        console.log("raja");
        $.ajax({
            url: "{{ route('dashboardSearch') }}",
            type: 'ajax',
            method: 'post',
            data: {
                "_token": "{{ csrf_token() }}",
                fromDate: fromDate,
                toDate: toDate,
            },
            success: function(response) {

                var initiatingProjectTable = $('#service_table').DataTable();
                var approvingProjectTable = $('#service_table1').DataTable();
                var activetable = $('#service_table2').DataTable();

                var initiatingProjectArray = response.myProjects;
                var approvingProjectArray = response.approvingProjects;
                var activeProjects = response.activeProjects;

                initiatingProjectTable.clear().draw();
                approvingProjectTable.clear().draw();
                activetable.clear().draw();

                console.log(initiatingProjectArray);
                console.log(approvingProjectArray);
                console.log(activeProjects);

                //initiating projects
                $.each(initiatingProjectArray, function(key, val) {
                    var ticketNo = val.ticketNo;
                    var projectNameAndCode = val.projectName + "&" + val.projectCode;

                    var workflowNameAndCode = val.workflowName + "&" + val.workflowCode;

                    var initiater = val.initiater;
                    var department = val.department;
                    var projectId = val.projectId;
                    var activeStatus = "";

                    var editurl = "";
                    editurl = editurl.replace(':id', projectId);
                    var viewBtn = '<button id=' + projectId +
                        ' class="btn switchPrimaryBtn editDocument" style="color:white" >View</button>';

                    initiatingProjectTable.row.add([ticketNo, projectNameAndCode, workflowNameAndCode, initiater, department, viewBtn]).draw();
                });
                //approving Projects
                $.each(approvingProjectArray, function(key, val) {
                    var ticketNo = val.ticketNo;
                    var projectName = val.projectName;
                    var projectCode = val.projectCode;
                    var workflowName = val.wfname;
                    var workflowCode = val.wfCode;

                    var startDate = val.startDate;
                    var endDate = val.endDate;
                    var dueDate = val.dueDate;
                    var level = val.level;
                    var department = val.department;
                    var projectId = val.projectId;
                    var activeStatus = "";

                    var viewBtn = '<button id=' + projectId +
                        ' class="btn switchPrimaryBtn editDocument" style="color:white" >View</button>';

                    approvingProjectTable.row.add([ticketNo, projectName, projectCode, workflowName, workflowCode, department, startDate, endDate, dueDate, level, viewBtn]).draw();
                });
                //active Projects
                $.each(activeProjects, function(key, val) {
                    var ticketNo = val.ticketNo;
                    var projectNameAndCode = val.projectName + "&" + val.projectCode;

                    var workflowNameAndCode = val.workflowName + "&" + val.workflowCode;

                    var initiater = val.initiater;
                    var department = val.department;
                    var projectId = val.projectId;
                    var activeStatus = "";

                    var editurl = "";
                    editurl = editurl.replace(':id', projectId);
                    var viewBtn = '<button id=' + projectId +
                        ' class="btn switchPrimaryBtn editDocument" style="color:white" >View</button>';

                    activetable.row.add([ticketNo, projectNameAndCode, workflowNameAndCode, initiater, department, viewBtn]).draw();
                });



            },
            error: function() {
                $("#otp_error").text("Update Error");
            }

        });
    }
</script>

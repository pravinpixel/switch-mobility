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
                    <div class="card-body">

                        <!-- Team -->
                        <section id="team" class="pb-5">
                            <div class="container">
                                <h5 class="section-title h1">Overview</h5>
                                <div class="row">
                                    <div class="col-2">
                                        <!--begin::Items-->
                                        <div class="bg-gray-100 bg-opacity-70 rounded-2 px-6 py-5" style="border: none;border-top:5px solid coral">
                                            <!--begin::Symbol-->

                                            <!--end::Symbol-->
                                            <!--begin::Stats-->
                                            <div class="m-0">
                                                @if(auth()->user()->is_super_admin ==1 ||auth()->user()->can('project-view'))
                                                <a href="{{url('projects')}}">
                                                    @endif
                                                    <!--begin::Number-->
                                                    <span class="text-gray-700 fw-bolder d-block fs-2qx lh-1 ls-n1 mb-1">{{$totProject}}</span>
                                                    <!--end::Number-->
                                                    <!--begin::Desc-->
                                                    <span class="text-gray-500 fw-semibold fs-6">Total Number Of Projects</span>
                                                    @if(auth()->user()->is_super_admin ==1 ||auth()->user()->can('project-view')) <!--end::Desc-->
                                                </a>
                                                @endif
                                            </div>
                                            <!--end::Stats-->
                                        </div>
                                        <!--end::Items-->
                                    </div>
                                    <!-- Team member -->

                                    <!-- ./Team member -->
                                    <!-- Team member -->
                                    <div class="col-2">
                                        <!--begin::Items-->
                                        <div class="bg-gray-100 bg-opacity-70 rounded-2 px-6 py-5" style="border: none;border-top:5px solid #bd7ffa">
                                            <!--begin::Symbol-->

                                            <!--end::Symbol-->
                                            <!--begin::Stats-->

                                            <div class="m-0">
                                                @if(auth()->user()->is_super_admin ==1 ||auth()->user()->can('document-listing-view'))
                                                <a href="{{url('doclisting')}}">
                                                    @endif
                                                    <!--begin::Number-->
                                                    <span class="text-gray-700 fw-bolder d-block fs-2qx lh-1 ls-n1 mb-1"><?php echo $totDocs; ?></span>
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
                                    </div>
                                    <!-- ./Team member -->

                                    <!-- Team member -->
                                    <div class="col-2">
                                        <!--begin::Items-->
                                        <div class="bg-gray-100 bg-opacity-70 rounded-2 px-6 py-5" style="border: none;border-top:5px solid #38eb7a">
                                            <!--begin::Symbol-->

                                            <!--end::Symbol-->
                                            <!--begin::Stats-->
                                            <div class="m-0">
                                                @if(auth()->user()->is_super_admin ==1 ||auth()->user()->can('document-listing-view'))
                                                <a href="{{url('doclistingIndex/approved')}}">
                                                    @endif
                                                    <!--begin::Number-->
                                                    <span class="text-gray-700 fw-bolder d-block fs-2qx lh-1 ls-n1 mb-1"><?php echo $totApprovedDocs; ?></span>
                                                    <!--end::Number-->
                                                    <!--begin::Desc-->
                                                    <span class="text-gray-500 fw-semibold fs-6">No.of Documents Approved</span>
                                                    <!--end::Desc-->
                                                    @if(auth()->user()->is_super_admin ==1 ||auth()->user()->can('document-listing-view'))
                                                </a>
                                                @endif
                                            </div>
                                            <!--end::Stats-->
                                        </div>
                                        <!--end::Items-->
                                    </div>
                                    <!-- ./Team member -->

                                    <!-- Team member -->
                                    <div class="col-2">
                                        <!--begin::Items-->
                                        <div class="bg-gray-100 bg-opacity-70 rounded-2 px-6 py-5" style="border: none;border-top:5px solid #f02b45">
                                            <!--begin::Symbol-->

                                            <!--end::Symbol-->
                                            <!--begin::Stats-->
                                            <div class="m-0">
                                                @if(auth()->user()->is_super_admin ==1 ||auth()->user()->can('document-listing-view'))
                                                <a href="{{url('doclistingIndex/pending')}}">
                                                    @endif
                                                    <!--begin::Number-->
                                                    <span class="text-gray-700 fw-bolder d-block fs-2qx lh-1 ls-n1 mb-1"><?php echo $totPendingDocs ?></span>
                                                    <!--end::Number-->
                                                    <!--begin::Desc-->
                                                    <span class="text-gray-500 fw-semibold fs-6">No.of Documents Pending</span>
                                                    <!--end::Desc-->
                                                    @if(auth()->user()->is_super_admin ==1 ||auth()->user()->can('document-listing-view'))
                                                </a>
                                                @endif
                                            </div>
                                            <!--end::Stats-->
                                        </div>
                                        <!--end::Items-->
                                    </div>
                                    <!-- ./Team member -->

                                    <!-- Team member -->
                                    <div class="col-2" style="">
                                        <!--begin::Items-->
                                        <div class="bg-gray-100 bg-opacity-70 rounded-2 px-6 py-5" style="border: none;border-top:5px solid #e6b410">
                                            <!--begin::Symbol-->

                                            <!--end::Symbol-->
                                            <!--begin::Stats-->
                                            <div class="m-0">
                                                @if(auth()->user()->is_super_admin ==1 ||auth()->user()->can('document-listing-view'))
                                                <a href="{{url('doclistingIndex/declined')}}">
                                                    @endif
                                                    <!--begin::Number-->
                                                    <span class="text-gray-700 fw-bolder d-block fs-2qx lh-1 ls-n1 mb-1"><?php echo  $totDeclinedDocs ?></span>
                                                    <!--end::Number-->
                                                    <!--begin::Desc-->
                                                    <span class="text-gray-500 fw-semibold fs-6">Declined Documents</span>
                                                    <!--end::Desc-->
                                                    @if(auth()->user()->is_super_admin ==1 ||auth()->user()->can('document-listing-view'))
                                                </a>
                                                @endif
                                            </div>
                                            <!--end::Stats-->
                                        </div>
                                        <!--end::Items-->
                                    </div>
                                    <div class="col-2">
                                        <!--begin::Items-->
                                        <div class="bg-gray-100 bg-opacity-70 rounded-2 px-6 py-5" style="border: none;border-top:5px solid #8c05ab">
                                            <!--begin::Symbol-->

                                            <!--end::Symbol-->
                                            <!--begin::Stats-->
                                            <div class="m-0">
                                                @if(auth()->user()->is_super_admin ==1 ||auth()->user()->can('document-listing-view'))
                                                <a href="{{url('doclistingIndex')}}">
                                                    @endif
                                                    <!--begin::Number-->
                                                    <span class="text-gray-700 fw-bolder d-block fs-2qx lh-1 ls-n1 mb-1"><?php echo $totalOverDueProjects; ?></span>
                                                    <!--end::Number-->
                                                    <!--begin::Desc-->
                                                    <span class="text-gray-500 fw-semibold fs-6">Documents Overdue</span>
                                                    <!--end::Desc-->
                                                    @if(auth()->user()->is_super_admin ==1 ||auth()->user()->can('document-listing-view'))
                                                </a>
                                                @endif
                                            </div>
                                            <!--end::Stats-->
                                        </div>
                                        <!--end::Items-->
                                    </div>
                                    <!-- ./Team member -->

                                </div>
                                <br>
                                <div class="col-md-12" style=" display: flex;justify-content: center;">
                                    <div class="col-md-6">
                                        <!-- <h1 class="text-center">Laravel 9 Dynamic Bar Chart Example - Techsolutionstuff</h1> -->
                                        <div id="barchart_material" style="width: 500px; height: 400px;"></div>
                                    </div>
                                    <div class="col-md-6">
                                        <!-- <h1 class="text-center">Laravel 9 Dynamic Bar Chart Example - Techsolutionstuff</h1> -->
                                        <div id="barchart_material1" style="width: 500px; height: 400px;"></div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">

                                    <h5 class="section-title h1">My Initiating Projects</h5>
                                    <table class="table align-middle table-row-bordered fs-6 gy-5" id="service_table">
                                        <!--begin::Table head-->
                                        <thead>
                                            <!--begin::Table row-->
                                            <tr class="text-end text-muted fw-bold fs-7 text-uppercase gs-0">

                                                <th>Ticket No</th>
                                                <th>Project Code & Name</th>
                                                <th>Work Flow Code & Name</th>
                                                <th>Department</th>

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
                                            <tr class="editDocument" id="{{ $d->id}}">
                                                <!--begin::Checkbox-->

                                                <!--end::Checkbox-->
                                                <!--begin::User=-->
                                                <td class="">
                                                    {{ $d->ticket_no }}
                                                </td>

                                                <td>{{ $d->project_name . ' ' . $d->project_code }}</td>
                                                <td>{{ $WorkFlow->workflow_name . ' & ' . $WorkFlow->workflow_code }}</td>

                                                <td>{{ $department->name }}</td>

                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <br>
                                <div class="row">

                                    <h5 class="section-title h1">My Approving Projects</h5>
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

                                            </tr>
                                            <!--end::Table row-->
                                        </thead>
                                        <!--end::Table head-->
                                        <!--begin::Table body-->
                                        <tbody class="text-gray-600 fw-semibold">
                                            <!--begin::Table row-->
                                            @foreach ($approvingProjects as $key => $d)


                                            <tr class="editDocument" id="{{ $d['projectId'] }}">
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


                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <br>
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
@endsection
<script data-require="jquery@*" data-semver="3.0.0" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/echarts/5.3.1/echarts.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    $(document).ready(
        function() {
            chart1();
            chart2();


        });

    function chart1() {
        var bars_basic_element = document.getElementById('barchart_material');
        if (bars_basic_element) {
            var totalDocs = "{{$totDocs}}";
            var intervallimit = 1;
            if (totalDocs > 10) {
                intervallimit = 10;
            }
            console.log(intervallimit);
            var bars_basic = echarts.init(bars_basic_element);
            bars_basic.setOption({
                color: ['#3398DB'],
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
                    name:'Docs'
                }],
                series: [{
                    name: 'Total',
                    type: 'bar',
                    barWidth: '20%',
                    data: [
                        '{{$totDocs}}',
                        '{{$totApprovedDocs}}',
                        '{{$totDeclinedDocs}}',
                        '{{$totPendingDocs}}'
                    ]
                }]
            });
        }
    }

    function chart2() {
        var totalProject = "{{$totProject}}";
        var intervallimit = 1;
        if (totalProject > 10) {
            intervallimit = 10;
        }

        var bars_basic_element1 = document.getElementById('barchart_material1');
        if (bars_basic_element1) {
            console.log("done");
            var bars_basic1 = echarts.init(bars_basic_element1);
            bars_basic1.setOption({
                color: ['#3398DB'],
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
                    name:'Projects'
                }],
                series: [{
                    name: 'Total',
                    type: 'bar',
                    barWidth: '20%',
                    data: [
                        '{{$totProject}}',
                        '{{$totalAppprovedProjects}}',
                        '{{$totalPendingProjects}}',
                        '{{$totalOverDueProjects}}'
                    ]
                }]
            });
        }
    }

    $(document).on('dblclick', '.editDocument', function() {

        var id = $(this).attr('id');


        var url = "{{ route('editDocument') }}";
        var form = $('<form action="' + url + '" method="post">' +
            ' {{ csrf_field() }} <input type="hidden" name="id" value="' + id + '" />' +
            '</form>');
        $('body').append(form);
        form.submit();
    });
</script>
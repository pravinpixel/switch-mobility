@extends('layouts.app')

@section('content')
@php
use Carbon\Carbon;
@endphp
<style>
    body {
        background: #7cbac1;
        margin: 0;
    }

    /* Vertical Tabs */
    .vertical-tabs {
        font-size: 15px;
        padding: 10px;
        color: #000;
        display: flex;
        column-gap: 10px;
        height: 100%;


    }

    .breadcrumbs {
        margin: 10px;
        padding: 5px 0;
        text-align: left
    }

    .top-tap {
        background: white;
        padding: 5px;
        border-radius: 5px;
        border-top: 5px solid darkblue;
        margin: 10px;
        align-items: center;
    }

    .vertical-tabs .nav-tabs .nav-link {
        border-radius: 0;

        text-align: center;
        font-size: 16px;

        color: #000;
        height: 40px;
        width: 120px;
    }

    .vertical-tabs .nav-tabs .nav-link.active {
        background-color: rgba(18, 193, 213, 0.05) !important;
        color: rgb(13, 181, 237);
        border: none !important;
        font-weight: 500;
    }

    .vertical-tabs .tab-content {
        width: 100%;
        border-radius: 5px;
        border-top: 5px solid rgb(13, 181, 237);
    }

    .vertical-tabs .tab-content>.active {
        background: #fff;
        display: block;
    }

    .vertical-tabs .nav.nav-tabs h4 {
        padding: 10px 5px;
    }

    .vertical-tabs .nav.nav-tabs li {
        margin: 5px 0;
    }

    .vertical-tabs .nav.nav-tabs {
        width: 200px;
        display: block;
        float: left;
        background: white;
        display: flex;
        flex-direction: column;
        align-content: center;
        border-radius: 5px;
        align-self: flex-start;
    }

    .vertical-tabs .sv-tab-panel {
        background: #fff;

    }

    @media only screen and (max-width: 420px) {
        .titulo {
            font-size: 22px
        }
    }

    @media only screen and (max-width: 325px) {
        .vertical-tabs {
            padding: 8px;
        }
    }

    footer {
        position: absolute;
        bottom: 0;
        width: 100%;
        text-align: center;
        color: #fff;
        font-size: 9px;
    }

    .rounded {
        border-radius: 50% !important;
    }

    section {
        padding: 60px 0;
    }

    #accordion-style-1 h1,
    #accordion-style-1 a {
        color: #7cbac1;
    }

    #accordion-style-1 .btn-link {
        font-weight: 400;
        color: #7cbac1;
        background-color: transparent;
        text-decoration: none !important;
        font-size: 16px;
        font-weight: bold;
        padding-left: 25px;
    }

    #accordion-style-1 .card-body {
        border-top: 2px solid #007b5e;
    }

    #accordion-style-1 .card-header .btn.collapsed .fa.main {
        display: none;
    }

    #accordion-style-1 .card-header .btn .fa.main {
        background: #7cbac1;
        padding: 13px 11px;
        color: #ffffff;
        width: 35px;
        height: 41px;
        position: absolute;
        left: -1px;
        top: 10px;
        border-top-right-radius: 7px;
        border-bottom-right-radius: 7px;
        display: block;
    }

    /* The Modal (background) */
    .modal {
        display: none;
        /* Hidden by default */
        position: fixed;
        /* Stay in place */
        z-index: 1;
        /* Sit on top */
        padding-top: 100px;
        /* Location of the box */
        left: 0;
        top: 0;
        width: 100%;
        /* Full width */
        height: 100%;
        /* Full height */
        overflow: auto;
        /* Enable scroll if needed */
        background-color: rgb(0, 0, 0);
        /* Fallback color */
        background-color: rgba(0, 0, 0, 0.4);
        /* Black w/ opacity */
    }

    /* Modal Content */
    .modal-content {
        background-color: #fefefe;
        margin: auto;
        padding: 20px;
        border: 1px solid #888;
        width: 30%;
    }

    /* The Close Button */
    .close {
        color: #aaaaaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .close:hover,
    .close:focus {
        color: #000;
        text-decoration: none;
        cursor: pointer;
    }

    table.table-bordered {
        border: 1px solid black;
        margin-top: 20px;
    }

    table.table-bordered>thead>tr>th {
        border: 1px solid black;
    }

    table.table-bordered>tbody>tr>td {
        border: 1px solid black;
    }

    .documentTableth>tr>th {
        color: blue;
        font-size: 15pt;
    }
</style>
<title>VERTICAL TABS</title>
</head>

<body>
    <div id="myModal" class="modal">

        <!-- Modal content -->
        <div class="modal-content">


            <form action="" method="get" id="versionModel">
                @csrf
                <div class="col-md-12 fv-row">
                    <!--begin::Label-->
                    <label class="required fs-6 fw-semibold mb-2">Documents</label><br>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <input style="border: 3px solid #ccc;" type="file" name="againestDocument" required class="form-control againestDocument" accept=".csv,.pdf, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                    <input type="hidden" value="" class="documentId" name="documentId">
                    <input type="hidden" value="" class="levelId" name="levelId">
                </div>
                <div class="col-md-12 fv-row">
                    <!--begin::Label-->
                    <label class="required fs-6 fw-semibold mb-2">Remarks</label><br>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <textarea required class="form-control form-control-solid remarks" style="border: 3px solid #ccc;" name="remarks" rows="4" cols="50"></textarea>

                </div>

                <div class="text-center pt-15">
                    <button type="button" class="btn btn-danger me-3" onclick="closeModel()">Cancel</button>
                    <button type="button" class="btn switchPrimaryBtn store" onclick="submitForm()">
                        <span class="indicator-label">Update and Exit</span>
                        <span class="indicator-progress">Please wait...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                    </button>
                </div>
            </form>
        </div>

    </div>
    <div id="statusChangeModal" class="modal">

        <!-- Modal content -->
        <div class="modal-content">


            <form action="" method="get" id="statusModelForm">
                @csrf
                <div class="col-md-12 fv-row">
                    <!--begin::Label-->
                    <label class="required fs-6 fw-semibold mb-2">status</label><br>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <select name="status" id="status" required class="form-control form-control-solid status" style="border: 3px solid #ccc;">
                        <option value="">Status</option>
                        <option value="2">Declined</option>
                        <option value="3">Change Request</option>
                        <option value="4">Approved</option>
                    </select>

                </div>
                <div class="col-md-12 fv-row documentUploadDiv" style="display:none">
                    <!--begin::Label-->
                    <label class="required fs-6 fw-semibold mb-2">Documents</label><br>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <input style="border: 3px solid #ccc;" type="file" name="againestDocument" required class="form-control againestDocument" accept=".csv,.pdf, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                    <input type="hidden" value="" class="documentId" name="documentId">
                    <input type="hidden" value="" class="levelId" name="levelId">
                </div>
                <div class="col-md-12 fv-row">
                    <!--begin::Label-->
                    <input type="hidden" value="" class="statusdocumentId" name="statusdocumentId">
                    <input type="hidden" value="" class="statuslevelId" name="statuslevelId">
                </div>
                <div class="col-md-12 fv-row">
                    <!--begin::Label-->
                    <label class="required fs-6 fw-semibold mb-2">Remarks</label><br>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <textarea required class="form-control form-control-solid statusremarks" style="border: 3px solid #ccc;" name="statusremarks" rows="4" cols="50"></textarea>

                </div>

                <div class="text-center pt-15">
                    <button type="button" class="btn btn-danger me-3" onclick="closeStatusModel()">Cancel</button>
                    <button type="button" class="btn switchPrimaryBtn store" onclick="submitStatusForm()">
                        <span class="indicator-label">Update and Exit</span>
                        <span class="indicator-progress">Please wait...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                    </button>
                </div>
            </form>
        </div>

    </div>
    <div class="text-center container">

        <div class="row">
            <div class="col-md-6">
                <h3 class="breadcrumbs">View Documents > Ticket No. #{{ $details->ticket_no }}</h3>
            </div>
            <div class="col-md-2">
                <label> </label> <label> </label>
                <a href="{{url('doclisting')}}" class="btn switchPrimaryBtn btn-sm mt-4" style="margin-right:-850px">Back</a>
            </div>
        </div>



        <div class="row top-tap">
            <div class="col-md-3">
                <h4>Ticket Number</h4>
                <p>{{ $details->ticket_no }}</p>
            </div>
            <div class="col-md-3">
                <h4>Project Code</h4>
                <p>{{ $details->project_code }}</p>
            </div>
            <div class="col-md-3">
                <h4>Project Name</h4>
                <p>{{ $details->project_name }}</p>
            </div>
            <div class="col-md-3">
                <h4>Upload Date</h4>
                <p>{{ $details->created_at }}</p>
            </div>
            <div class="col-md-3">
                <h4>Document Type</h4>
                <p>{{ $details->workflow_name }}</p>
            </div>
            <div class="col-md-3">
                <h4>WorkFlow Name & Code </h4>
                <p>{{$details->workflow_name .' '. $details->workflow_code }}</p>
            </div>
            <div class="col-md-3">
                <h4>Department </h4>
                <p>{{ $details->department }}</p>
            </div>
            <div class="col-md-3">
                <h4>Initiator </h4>
                <p>{{ $details->first_name . ' ' . $details->last_name }}</p>
            </div>

            <div class="m-0 d-flex justify-content-end pe-3">
                <!-- <a href="#" class="btn btn-sm btn-flex bg-body btn-color-gray-700 btn-active-color-primary fw-bold " data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">

                    Milestone1
                </a> -->

                <!--  Drop Down Container -->
                <div class="menu menu-sub menu-sub-dropdown w-350px w-md-400px " data-kt-menu="true" id="kt_menu_637dc6b4b8b49">
                    <div class="px-7 py-5">
                        <div class="fs-5 text-dark fw-bold">Milestone Detail</div>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Milestone Name</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Level</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($milestoneDatas as $milestoneData)
                                <tr>
                                    <td>{{$milestoneData->milestone}}</td>
                                    <td>{{Carbon::parse($milestoneData->mile_start_date)->format('d-m-Y')}}</td>
                                    <td>{{Carbon::parse($milestoneData->mile_end_date)->format('d-m-Y')}}</td>
                                    <td>Level-{{$milestoneData->levels_to_be_crossed}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-3" style="display: none;">
                <h4>Initiator</h4>
                <figure>
                    <img src="{{ url('/images/Employee/' . $details->profile_image) }}" class="rounded" width="50" height="50">

                    <figure>

            </div>

        </div>

        <div class="vertical-tabs">

            <ul class="nav nav-tabs" role="tablist">
                <h4>Approval Status</h4>

                @for ($i = 0; $i < count($levelsArray); $i++) <li class="nav-item">
                    <a class="nav-link <?php if ($i == 0) {
                                            echo 'active';
                                        } ?>" data-toggle="tab" href="#pag<?php echo $levelsArray[$i]['levelId']; ?>" role="tab" aria-controls="home" onclick="get_level_data(<?php echo $levelsArray[$i]['levelId']; ?>,<?php echo $details->id; ?>);">Level <?php echo $levelsArray[$i]['levelId']; ?></a>
                    </li>
                    @endfor
            </ul>
            <div class="tab-content">
                @for ($i = 0; $i < count($levelsArray); $i++) <div class="tab-pane <?php if ($i == 0) {
                                                                                        echo 'active';
                                                                                    } ?>" id="pag<?php echo $levelsArray[$i]['levelId']; ?>" role="tabpanel">

            </div>
            @endfor
            <!-- <a href="{{url('doclisting')}}"> <button class="btn switchPrimaryBtn"style="margin-left:-1250px!important">Back</button></a> -->
        </div>



    </div>
    </div>
    </div>
    <button class="btn switchPrimaryBtn float-right-btn float-open-btn">
        <span class="r-90"> MileStone</span>
    </button>
    <div class="card shadow-sm right-card right-card-close overflow-hidden">

        <div class="card-body p-0">
            <div class="card-body milstoneBody p-0">
                <table class="table table-hover table-row-bordered">
                    <thead>
                        <tr>
                            <th>Milestone Name</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Level</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($milestoneDatas as $milestoneData)
                        <?php
                        $pStartDate = date('d-m-Y', strtotime($milestoneData->mile_start_date));

                        $pEndDate = date('d-m-Y', strtotime($milestoneData->mile_end_date));
                        ?>
                        <tr>
                            <td>{{$milestoneData->milestone}}</td>
                            <td>{{$pStartDate}}</td>
                            <td>{{$pEndDate}}</td>
                            <td>{{$milestoneData->levels_to_be_crossed}}</td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>

    </div>
    <style>
      
      .float-right-btn {
            position: fixed;
            right:20px;
            top: 50%;
            transform: translateY(-50%);
            width: 40px;
            height: 100px;
            display: flex;
    justify-content: center;
    align-items: center;
          
        }
.r-90{
    position: relative;

    display: block;
    rotate: -90deg;
}
        .float-open-btn {
            right: 10px;
        }

        .float-close-btn {
            right: 424px;
        }

        .right-card {
            position: fixed;
            right: 2px;
            top: 50%;
            transform: translateY(-50%);
            width: 418px;

        }

        .right-card-close {
            right: -418px;
        }

        .right-card-open {
            right: 2px;
        }
    </style>
    <script>
        $(".float-right-btn").click(function(e) {
            e.stopPropagation();
            $(this).toggleClass("float-open-btn float-close-btn");
            $(".right-card").toggleClass("right-card-close right-card-open");
        });
        $(".right-card").click(function(event) {
            event.stopPropagation();
        });
        $(document).click(function(e) {
            if ($(".right-card-open").length != 0) {
                $(".float-right-btn").toggleClass("float-open-btn float-close-btn");
                $(".right-card").toggleClass("right-card-close right-card-open");
            }
            // $(".right-card").removeClass("right-card-open");
            // $(".right-card").addClass("right-card-close");
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous">
    </script>
</body>

</html>
@endsection
<script data-require="jquery@*" data-semver="3.0.0" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.js">
</script>
<script>
    // Get the modal
    var modal = document.getElementById("myModal");

    // Get the button that opens the modal
    var btn = document.getElementById("myBtn");

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

    // // When the user clicks the button, open the modal 
    // btn.onclick = function() {

    //     modal.style.display = "block";
    // }

    // // When the user clicks on <span> (x), close the modal
    // span.onclick = function() {
    //     modal.style.display = "none";
    // }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>
<script>
    $(document).ready(function() {
        var ProjectId = "{{ $details->id }}";
        var firstLevel = "{{$levelsArray[0]['levelId']}}";

        get_level_data(firstLevel, ProjectId);
        // Get the modal
        var modal = document.getElementById("myModal");
        var statusChangeModal = document.getElementById("statusChangeModal");

        // Get the button that opens the modal
        var btn = document.getElementById("myBtn");

        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close")[0];


    });


    function openVersionModel(id, levelId) {
        $('#versionModel')[0].reset();
        $('#myModal').css('display', 'block');
        $('#myModal').find('.documentId').val(id);
        $('#myModal').find('.levelId').val(levelId);

    }

    function openStatusModel(id, levelId, mainId) {
        $('#statusModelForm')[0].reset();
        $('#statusChangeModal').css('display', 'block');
        $('#statusChangeModal').find('.statusdocumentId').val(id);
        $('#statusChangeModal').find('.statuslevelId').val(levelId);
        $('#statusChangeModal').find('.documentId').val(mainId);
        $('#statusChangeModal').find('.levelId').val(levelId);

    }

    function closeModel() {
        $('#versionModel')[0].reset();

        $('#myModal').css('display', 'none');

    }

    function closeStatusModel() {
        $('#statusModelForm')[0].reset();

        $('#statusChangeModal').css('display', 'none');

    }

    function get_level_data(level, project_id) {
        $(".tab-pane").html("");

        $.ajax({
            url: "{{ url('getProjectLevel') }}",
            type: 'ajax',
            method: 'post',
            data: {
                "_token": "{{ csrf_token() }}",
                level: level,
                project_id: project_id
            },
            success: function(result) {
                var data1 = JSON.parse(result);

                if (data1.length) {

                    $("#pag" + level).html("");
                    $(".image_append" + level).empty();
                    // var date = new Date(data[0].milestone_created),
                    //     yr = date.getFullYear(),
                    //     month = (date.getMonth() + 1) < 10 ? '0' + (date.getMonth() + 1) : (date.getMonth() + 1),
                    //     day = date.getDate() < 10 ? '0' + date.getDate() : date.getDate(),
                    //     newDate = day + '-' + month + '-' + yr;
                    $("#pag" + level).html('<div class="sv-tab-panel" ><div class="jumbotron"><br><div class="s" ><div class="row"> <div class="col-md-2">Approvers</div><div class="col-md-5 image_append' + level + '" style="display:flex;flex-wrap:nowrap;overflow-x:auto;"></div><div class="col-md-2">Due Date:<div class="due_date_' + level + '"></div></div><div class="col-md-1">Priority<p class="priority_' + level + '"></p></div></div><div class="docsPart"><div class="p-0  w-100" style="border-top:1px solid lightgrey;text-align:left;padding:5px 0;font-weight:bold;margin-left:10px;margin-bottom:10px;">&nbsp;&nbsp;Main Document</div><div class="maindoc_append' + level + '" style=" max-height:400px; overflow-y:auto;"></div><div style="text-align:left;padding:5px 0;font-weight:bold;margin-left:10px;margin-bottom:10px;margin-top:20px;" >&nbsp;&nbsp;Auxilary Document</div><div class="auxdoc_append' + level + '" style=" max-height:400px; overflow-y:auto"></div></div><div class="emptyDocsPart" style="display:none"><hr><p>No Documents is assigned For appproval!</p></div></div></div>');
                    //if (data.length > 0) {

                    $(".image_append" + level).empty();
                    $.each(data1, function(key, val) {
                        var dueDate = new Date(val.due_date);
                        var todayDate = new Date();

                        var millisBetween = dueDate.getTime() - todayDate.getTime();
                        var getdays = millisBetween / (1000 * 3600 * 24);
                        var completionDate = Math.round(Math.abs(getdays));
                        var dateSign = "";
                        if (completionDate) {
                            dateSign = (dueDate.getTime() <= todayDate.getTime()) ? "-" : "+";
                        }




                        var dateAr = val.due_date.split('-');
                        var cnewDate = dateAr[1] + '-' + dateAr[2] + '-' + dateAr[0].slice(-4);

                        var duDateAppend = cnewDate;
                        var badgeType = (dateSign == '-') ? "danger" : "success";
                        duDateAppend += ' <span class="menu-badge"><span class="badge badge-' + badgeType + '">' + dateSign + completionDate + ' Days</span></span>';
                        $(".due_date_" + level).empty();
                        $(".due_date_" + level).append(duDateAppend);
                        var priority = "";
                        if (val.priority == 4) {
                            priority = "High";
                        } else if (val.priority == 3) {
                            priority = "Low";
                        } else if (val.priority == 2) {
                            priority = "Medium";
                        } else {
                            priority = "Important";
                        }
                        $(".priority_" + level).empty();
                        $(".priority_" + level).append(priority);
                        var images = val.profile_image;
                        var baseUrl = "{{ asset('images/Employee/') }}";
                        if (images) {
                            var profile = images;
                        } else {
                            var profile = 'icon-5359553_960_720.png';
                        }
                        $(".image_append" + level).append('<figure><img src="' + baseUrl + '/' + profile + '" class="rounded"  width="50" height="50"><figcaption  style="white-space: nowrap;">[' + val.first_name + ' ,' + val.desName + ']&nbsp;</figcaption></figure>');
                    });
                    $.ajax({
                        url: "{{ url('getlevelwiseDocument') }}",
                        type: 'ajax',
                        method: 'post',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            level: level,
                            project_id: project_id
                        },
                        success: function(result) {
                            var data = result;
                            var baseUrl = "{{ asset('/') }}";

                            $(".maindoc_append" + level).empty();
                            $(".auxdoc_append" + level).empty();
                            var levelstageStatus = [];

                            $('.docsPart').css('display', 'block');
                            $('.emptyDocsPart').css('display', 'none');
                            if (data.main_docs) {
                                var getMainDocArray = data.main_docs;
                                if (getMainDocArray.length == 0) {


                                    $('.docsPart').css('display', 'none');
                                    $('.emptyDocsPart').css('display', 'block');
                                }
                                $.each(data.main_docs, function(key, val) {

                                    var currentStatusId = val.status;
                                    var currentFileName = val.file_name;
                                    var statusColour = "warning";
                                    if (currentStatusId == 2) {
                                        var currentStatusData = "Declined";
                                    } else if (currentStatusId == 3) {
                                        var currentStatusData = "Change Request";
                                    } else if (currentStatusId == 4) {
                                        var currentStatusData = "Approved";
                                        var statusColour = "success";
                                    } else {
                                        var currentStatusData = "Waiting For Approval";
                                    }

                                    var docMainDetailArray = val.get_doc_detail;

                                    console.log(docMainDetailArray);

                                    if (val.status == 1) {
                                        var status = "Pending";
                                    } else if (val.status == 2) {
                                        var status = "Declined";
                                    } else {
                                        var status = "Approved";
                                    }
                                    var versionMainDocDiv = '<div class="">';
                                    versionMainDocDiv += '<div class="accordion " style="margin:auto;width:98%;" id="accordionExample' + key + '">';
                                    versionMainDocDiv += '<div class="card p-0"> <div class=" border-0" id="heading' + key + '">';
                                    versionMainDocDiv += '<h5 class="mb-0 w-100">';
                                    versionMainDocDiv += '<button class="btn  btn-link p-1 m-1 pb-0 btn-block " style="text-align:left;border-bottom:1px solid lightgrey;display: flex;align-items: center;justify-content:space-between;width:99%;" type="button" data-toggle="collapse" data-target="#collapse' + key + '" aria-expanded="false" aria-controls="collapse' + key + '"><h3 style = "font-style:bold;padding-left:10px;">' + currentFileName + '</h3> <p class="text-right mainlevelStatus-' + level + "-" + key + '"></p> <p class="btn btn-' + statusColour + ' status-accordion" style="margin-right:40px;">' + currentStatusData + '</p></button>';
                                    versionMainDocDiv += '</h5>';
                                    versionMainDocDiv += '</div>';
                                    versionMainDocDiv += '<div id="collapse' + key + '" class="collapse fade" aria-labelledby="heading' + key + '" data-parent="#accordionExample' + key + '">';
                                    versionMainDocDiv += '<div class="card-body">';
                                    versionMainDocDiv += ' <table class="table table-striped documentTable">';
                                    versionMainDocDiv += ' <thead class="documentTableth">';
                                    versionMainDocDiv += ' <tr> <th scope="col">Version ID </th> <th scope="col">Remarks</th> <th scope="col">Status</th> <th scope="col">Last Updation</th> <th scope="col">Action</th> </tr>';
                                    versionMainDocDiv += '</thead>';
                                    versionMainDocDiv += '<tbody style="">';
                                    var mainDocSize = docMainDetailArray.length;
                                    var showMainDocAction = mainDocSize - 1;

                                    for (var i = docMainDetailArray.length - 1; i >= 0; --i) {

                                        var remarkData = (docMainDetailArray[i].remark) ? docMainDetailArray[i].remark : "";
                                        var updatedBy = docMainDetailArray[i].employee;
                                        var updatedPerson = "";

                                        if (updatedBy) {
                                            updatedPerson = updatedBy.first_name + " " + updatedBy.middle_name + " " + updatedBy.last_name;
                                        }

                                        var statusData = "";
                                        if (docMainDetailArray[i].status == 1) {
                                            var statusData = "Waiting  For Approval";

                                        } else if (docMainDetailArray[i].status == 2) {
                                            var statusData = "Declined";

                                        } else if (docMainDetailArray[i].status == 3) {
                                            var statusData = "Change Request";
                                        } else if (docMainDetailArray[i].status == 4) {
                                            var statusData = "Approved";
                                        } else {
                                            var statusData = "Waiting For Approval";
                                        }

                                        // $(".status").html(statusData);
                                        console.log($(".status-accordion").html());
                                        var dateFormat = new Date(docMainDetailArray[i].updated_at);
                                        var lastUpdate = ("Date: " + dateFormat.getDate() +
                                            "/" + (dateFormat.getMonth() + 1) +
                                            "/" + dateFormat.getFullYear() +
                                            " " + dateFormat.getHours() +
                                            ":" + dateFormat.getMinutes() +
                                            ":" + dateFormat.getSeconds());
                                        versionMainDocDiv += '<tr>';
                                        versionMainDocDiv += '<td>ver ' + docMainDetailArray[i].version + '</td>';
                                        versionMainDocDiv += '<td>' + remarkData + '</td>';
                                        versionMainDocDiv += '<td>' + statusData + '</td>';
                                        versionMainDocDiv += '<td>' + updatedPerson + "(" + lastUpdate + ')</td>';

                                        versionMainDocDiv += '<td>';


                                        // if (i == showMainDocAction) {
                                        var classData = "mainlevelStatus-" + level + "-" + key;
                                        var stateData = statusData;
                                        var state = [{
                                            "class": classData
                                        }, {
                                            "res": stateData
                                        }];
                                        levelstageStatus.push(state);
                                        // $(".mainlevelStatus-" + level + "-" + i).append(statusData);

                                        versionMainDocDiv += '<a class="btn btn-success btn-xs" href="' + baseUrl + 'projectDocuments/' + docMainDetailArray[i].document_name + '" target="_blank" download title="download"><i class="las la-download"></i> Download</a>';
                                        // versionMainDocDiv += ' <a class="btn btn-warning btn-xs" href="' + baseUrl + 'projectDocuments/' + docMainDetailArray[i].document_name + '" target="_blank" view title="view"><i class="las la-eye"></i></a>&nbsp;<button class="btn btn-sm btn-primary" onclick="openVersionModel(' + val.id + ',' + level + ')"> <i class="las la-upload"></i>';
                                        versionMainDocDiv += '</button>';
                                        // }
                                        versionMainDocDiv += '</td>';
                                        versionMainDocDiv += '</tr>';
                                    }
                                    versionMainDocDiv += '</tbody>';
                                    versionMainDocDiv += '</table> ';
                                    versionMainDocDiv += '</div>';
                                    versionMainDocDiv += '</div>';
                                    versionMainDocDiv += '</div>';
                                    versionMainDocDiv += '</div>';


                                    $(".maindoc_append" + level).append(versionMainDocDiv);
                                });

                            } else {
                                $('.docsPart').css('display', 'none');
                                $('.emptyDocsPart').css('display', 'block');
                            }
                            if (data.aux_docs) {
                                var versionAuxDocDiv1 = '<div class="card-body">';
                                var versionAuxDocDiv1 = '<br>';
                                versionAuxDocDiv1 += '<table class="table table-striped documentTable">';
                                versionAuxDocDiv1 += '<thead class="documentTableth">';
                                versionAuxDocDiv1 += '<tr>';
                                versionAuxDocDiv1 += '<th scope="col">File Name</th><th scope="col">Action</th>';
                                versionAuxDocDiv1 += '</tr>';
                                versionAuxDocDiv1 += '</thead>';
                                versionAuxDocDiv1 += ' <tbody>';
                                versionAuxDocDiv1 += ' </tbody>';
                                $.each(data.aux_docs, function(key, val) {
                                    versionAuxDocDiv1 += '<tr>';
                                    versionAuxDocDiv1 += '<td>' + val.original_name + '</td>';
                                    versionAuxDocDiv1 += '<td><a class="btn btn-success btn-sm" href="' + baseUrl + 'projectDocuments/' + val.document_name + '" target="_blank" download title="download"><i class="las la-download"></i></a> Download</td>';
                                    versionAuxDocDiv1 += '</tr>';
                                });
                                versionAuxDocDiv1 += ' </table>';
                                versionAuxDocDiv1 += ' </br>';
                                $(".auxdoc_append" + level).append(versionAuxDocDiv1);
                                // $.each(data.aux_docs, function(key1, val) {
                                //     var docAuxDetailArray = val.doc_detail;

                                //     var baseUrl = "{{ asset('/') }}";
                                //     if (val.status == 0) {
                                //         var status = "Waiting";
                                //     } else if (val.status == 1) {
                                //         var status = "Approved";
                                //     } else {
                                //         var status = "Pending";
                                //     }
                                //     var versionAuxDocDiv = '<div class="row">';
                                //     versionAuxDocDiv += '<div class="accordion" style="margin:auto;width:98%;" id="accordionExample1">';
                                //     versionAuxDocDiv += '<div class="card">';
                                //     versionAuxDocDiv += '<div class="border-0" id="heading' + key1 + '">';
                                //     versionAuxDocDiv += ' <h5 class="mb-0 w-100"><button class="btn  btn-link w-100 p-1 m-1 pb-0 btn-block " style="text-align:left;border-bottom:1px solid lightgrey;display: flex;align-items: center;justify-content:space-between;" type="button" data-toggle="collapse" data-target="#collapse1' + key1 + '" aria-expanded="false" aria-controls="collapse' + key1 + '"><h3 style = "font-style:bold;padding-left:10px;">' + val.original_name + '</h3><p class="auxlevelStatus' + (key1 - 1) + '"></p><p class="btn btn-light-danger status-accordion" style="margin-right:40px;visibility:hidden;">asdas</p></button></h5>';
                                //     versionAuxDocDiv += '</div>';
                                //     versionAuxDocDiv += ' <div id="collapse1' + key1 + '" class="collapse fade" aria-labelledby="heading' + key1 + '" data-parent="#accordionExample1">';
                                //     versionAuxDocDiv += '<div class="card-body">';
                                //     versionAuxDocDiv += '<table class="table table-striped documentTable">';
                                //     versionAuxDocDiv += '<thead class="documentTableth">';
                                //     versionAuxDocDiv += '<tr>';
                                //     versionAuxDocDiv += '<th scope="col">Version ID</th><th scope="col">Last Updated</th> <th scope="col">Action</th>';
                                //     versionAuxDocDiv += '</tr>';
                                //     versionAuxDocDiv += '</thead>';
                                //     versionAuxDocDiv += ' <tbody>';
                                //     var auxDocSize = docAuxDetailArray.length;
                                //     var showAuxDocAction = auxDocSize - 1;


                                //     for (j = docAuxDetailArray.length - 1; j >= 0; --j) {
                                //         var remarkData = (docAuxDetailArray[j].remark) ? docAuxDetailArray[j].remark : "";

                                //         var dateFormat = new Date(docAuxDetailArray[j].updated_at);
                                //         var lastUpdate = ("Date: " + dateFormat.getDate() +
                                //             "/" + (dateFormat.getMonth() + 1) +
                                //             "/" + dateFormat.getFullYear() +
                                //             " " + dateFormat.getHours() +
                                //             ":" + dateFormat.getMinutes() +
                                //             ":" + dateFormat.getSeconds());

                                //         var statusData = "";
                                //         if (docAuxDetailArray[j].status == 1) {
                                //             var statusData = "Waiting For Approval";
                                //         } else if (docAuxDetailArray[j].status == 2) {
                                //             var statusData = "Declined";
                                //         } else if (docAuxDetailArray[j].status == 3) {
                                //             var statusData = "change Request";
                                //         } else if (docAuxDetailArray[j].status == 4) {
                                //             var statusData = "Approved";
                                //         } else {
                                //             var statusData = "Waiting For Approval";
                                //         }

                                //         $(".mainlevelStatus" + j).html("");
                                //         $(".mainlevelStatus" + j).append("(" + statusData + ")");
                                //         versionAuxDocDiv += '<tr>';
                                //         versionAuxDocDiv += '<td>ver ' + docAuxDetailArray[j].version + '</td>';
                                //         // versionAuxDocDiv += '<td>' + remarkData + '</td>';
                                //         // versionAuxDocDiv += '<td>' + statusData + '</td>';
                                //         versionAuxDocDiv += '<td>' + lastUpdate + '</td>';
                                //         versionAuxDocDiv += '<td>';
                                //         // if (j == showAuxDocAction) {
                                //         versionAuxDocDiv += '<a class="btn btn-success btn-xs" href="' + baseUrl + 'projectDocuments/' + docAuxDetailArray[j].document_name + '" target="_blank" download title="download"><i class="las la-download"></i></a>';
                                //         // versionAuxDocDiv += ' <a class="btn btn-warning btn-xs" href="' + baseUrl + 'projectDocuments/' + docAuxDetailArray[j].document_name + '" target="_blank" view title="view"><i class="las la-eye"></i></a>&nbsp;<button class="btn btn-sm btn-primary" onclick="openVersionModel(' + val.id + ',' + level + ')"> <i class="las la-upload"></i>';
                                //         versionAuxDocDiv += '</button>';
                                //         // }
                                //         versionAuxDocDiv += '</td>';
                                //         versionAuxDocDiv += '</tr>';
                                //     }
                                //     versionAuxDocDiv += '</tbody>';
                                //     versionAuxDocDiv += '</table>';
                                //     versionAuxDocDiv += '</div>';
                                //     versionAuxDocDiv += '</div>';
                                //     versionAuxDocDiv += '</div>';
                                //     versionAuxDocDiv += '</div>';
                                //     versionAuxDocDiv += '</div>';
                                //     $(".auxdoc_append" + level).append(versionAuxDocDiv);
                                // });
                            }
                        },
                        error: function(err) {
                            console.log(err);
                        }
                    });
                    // $(".doc_append" + level).empty();
                    // $(".doc_append" + level).append('<div class="row"> <div class="accordion" id="accordionExample">@foreach ($maindocument as $key=> $md)<div class="card"> <div class="card-header" id="heading<?php echo $key; ?>"> <h5 class="mb-0"><button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapse<?php echo $key; ?>" aria-expanded="false" aria-controls="collapse<?php echo $key; ?>"><i class="fa fa-angle-double-right mr-3"></i>{{$md->document}}</button></h5> </div><div id="collapse<?php echo $key; ?>" class="collapse fade" aria-labelledby="heading<?php echo $key; ?>" data-parent="#accordionExample"> <div class="card-body"> TEST </div></div></div>@endforeach</div></div><div class="row"> <div class="accordion" id="accordionExample1">@foreach ($auxdocument as $key1=> $ad)<div class="card"> <div class="card-header" id="heading<?php echo $key1; ?>"> <h5 class="mb-0"><button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapse1<?php echo $key1; ?>" aria-expanded="false" aria-controls="collapse<?php echo $key1; ?>"><i class="fa fa-angle-double-right mr-3"></i>{{$ad->document}}</button></h5> </div><div id="collapse1<?php echo $key1; ?>" class="collapse fade" aria-labelledby="heading<?php echo $key1; ?>" data-parent="#accordionExample1"> <div class="card-body"> TEST1 </div></div></div>@endforeach</div></div>');
                    // }
                    //OLD
                    // if(data){
                    //     $.each(data, function(key, val) {
                    //         console.log(val.hod_image);
                    //     var len=key+1;
                    //     var baseUrl = "{{ asset('images/') }}";
                    //    $("#pag"+key).html('<div class="tab-pane" id="pag'+key+'" role="tabpanel"><div class="sv-tab-panel"><h3>Level '+len+'</h3><hr><div class="jumbotron"><div class="row"><div class="col-md-2">Approvers</div><div class="col-md-6" style="display:inline-flex;flex-flow:row"><figure><img src="'+baseUrl +'/'+ val.hod_image+'" class="rounded" width="50" height="50"><figcaption>'+val.hod_first_name+' '+val.hod_last_name+'</figcaption></figure><figure><img src="'+baseUrl +'/'+ val.staff_image+'" class="rounded" width="50" height="50"><figcaption>'+val.staff_first_name+' '+val.staff_last_name+'</figcaption></figure></div><div class="col-md-4">Milestone:<br>Planned Date:</div></div></div></div></div>');
                    // });
                    // }
                } else {

                    $(".tab-pane").html("");
                    alert('Level -' + level + ' Not Available');
                }
            },
            error: function(err) {
                console.log(err);
            }
        });
    }


    function update_status(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You can always change the status to active or in-active!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3565ed',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Change it!'
        }).then(isConfirmed => {
            if (isConfirmed.value) {


                if (isConfirmed.value) {
                    Swal.fire(
                        'Changed!',
                        'Document status has been changed successfully!',
                        'success'
                    );
                }
            }
        });
    }

    function submitStatusForm() {




        var formData = new FormData($('#statusModelForm')[0]);
        formData.append('csrfmiddlewaretoken', '{{ csrf_token() }}');

        $.ajax({
            url: "{{ url('docStatus') }}",
            type: 'ajax',
            method: 'post',
            dataType: 'json',
            processData: false,
            contentType: false,

            data: formData,
            success: function(result) {

                var ProjectId1 = "{{ $details->id }}";
                if (result.status == 'success') {
                    var levelId = $('.statuslevelId').val();
                    closeStatusModel();
                    get_level_data(levelId, ProjectId1);
                } else {

                    window.location.reload();
                }
            }
        });
    }
    $(document).on('change', '.status', function() {

        if ($(this).val() == 2 || $(this).val() == 3) {
            $('.documentUploadDiv').css('display', 'block');
        } else {
            $('.documentUploadDiv').css('display', 'none');
        }
    });

    function submitForm() {
        console.log("well done");


        var remark = $('.remarks').val();
        var documentId = $('.documentId').val();
        var statusversion = $('.statusversion').val();
        var formData = new FormData($('#versionModel')[0]);
        formData.append('csrfmiddlewaretoken', '{{ csrf_token() }}');

        $.ajax({
            url: "{{ url('uploadDocumentVersion') }}",
            type: 'ajax',
            method: 'post',
            dataType: 'json',
            processData: false,
            contentType: false,

            data: formData,
            success: function(result) {

                var ProjectId1 = "{{ $details->id }}";
                if (result.status == 'success') {
                    var levelId = $('.levelId').val();
                    closeModel();
                    get_level_data(levelId, ProjectId1);
                } else {

                    window.location.reload();
                }
            }
        });
    }
</script>
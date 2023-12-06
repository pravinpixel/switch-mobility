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
        z-index: 2;
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
    .milstoneBody {
    max-height: 300px!important; /* Adjust the height as needed */
    overflow-y: scroll!important;
    }
    .marg-top-10 {
        margin-top: 10px;
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
                    <button type="button" class="btn switchPrimaryBtn  store" onclick="submitForm()">
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
                    <button type="button" class="btn switchPrimaryBtn  store" onclick="submitStatusForm()">
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
        <h3 class="breadcrumbs">Approved Documents> Ticket No. #{{ $details->ticket_no }}</h3>
    </div>
    <div class="col-md-2">
        <label> </label> <label> </label>
        <a href="{{url('approvalListIndex')}}" class="btn switchPrimaryBtn btn-sm mt-3" style="margin-right:-850px">Back</a>
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
                <p>{{date('d-m-Y H:i:s', strtotime($details->created_at)) }}</p>
            </div>
            <div class="col-md-3">
                <h4>Document Type</h4>
                <p>{{ $details->document_type }}</p>
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
                <p>{{ $details->first_name .' ' . $details->middle_name. ' ' . $details->last_name }}</p>
            </div>


            <div class="col-md-3" style="display: none;">
                <h4>Initiator</h4>
                <figure>
                    <img src="{{ url('/images/Employee/' . $details->profile_image) }}" class="rounded" width="50" height="50">

                    <figure>

            </div>

        </div>

        <div class="vertical-tabs">


            <div class="tab-content1" style="width:100%!important">
                <div class="card-body">
                    <table class="table table-striped documentTable">
                        <thead class="documentTableth">
                            <tr>
                                <th scope="col">Document Name </th>

                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody style="">
                            @foreach($models as $model)

                            <tr>
                                <td style="max-width: 50%; overflow-wrap: anywhere">{{$model->original_name}}</td>
                                <td>
                                <a class="btn btn-sm btn-primary viewDocument" target="_blank" title="View Document" id="{{$model->projectId}}"><i class="fas fa-eye"></i></a> View Document<br/>
                                <a class="btn btn-sm btn-success marg-top-10" download="OriginalDocs" href="{{ asset('/projectDocuments/') }}<?php echo "/".$model->document_name; ?>" title="Download Orginal Document" id="{{$model->id}}"><i class="las la-download"></i></a> Download Orginal Document<br/>
                                <a class="btn btn-sm btn-warning actionDocs marg-top-10" target="_blank" title="Download Approved Document" id="{{$model->id}}"><i class="las la-download"></i></a> Download Approved Document</td>
                            </tr>
                            @endforeach

                        </tbody>

                    </table>
                </div>

            </div>


        </div>
    </div>
    </div>
    <button class="btn switchPrimaryBtn float-right-btn float-open-btn">
        <span class="r-90"> MileStone</span>
    </button>
    <div class="card shadow-sm right-card right-card-close p-0 overflow-hidden">
        <div class="card-body milstoneBody p-0">
            <table class="table table-row-dashed">
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
                        <td>{{$milestoneData->levels_to_be_crossed}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
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
            z-index: 2;
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
            z-index: 2;
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
    $(document).ready(function() {
        var ProjectId = "{{ $details->id }}";

    });

    $(document).on('click', '.actionDocs', function() {

        var id = $(this).attr('id');


            var url = "{{ route('approvedDocsDownload') }}";

        var form = $('<form action="' + url + '" method="post">' +
            ' {{ csrf_field() }} <input type="hidden" name="id" value="' + id + '" />' +
            '</form>');
        $('body').append(form);
        form.submit();
    });

    $(document).on('click', '.viewDocument', function() {
        console.log("well and good");

        var id = $(this).attr('id');

        var url = "{{ route('viewDocListing') }}";
        var form = $('<form action="' + url + '" method="post">' +
            ' {{ csrf_field() }} <input type="hidden" name="id" value="' + id + '" />' +
            '</form>');
        $('body').append(form);
        form.submit();
    });
</script>
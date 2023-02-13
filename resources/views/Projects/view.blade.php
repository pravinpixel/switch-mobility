@extends('layouts.app')

@section('content')
<style>
    body {
        background: #7cbac1;
        margin: 0;
    }

    /* Vertical Tabs */
    .vertical-tabs {
        font-size: 15px;
        padding: 10px;
        color: #000
    }

    .vertical-tabs .nav-tabs .nav-link {
        border-radius: 0;
        background: #fff;
        text-align: center;
        font-size: 16px;
        border: 1px solid #424242;
        color: #000;
        height: 40px;
        width: 120px;
    }

    .vertical-tabs .nav-tabs .nav-link.active {
        background-color: #7cbac1 !important;
        color: #fff;
    }

    .vertical-tabs .tab-content>.active {
        background: #fff;
        display: block;
    }

    .vertical-tabs .nav.nav-tabs {
        border-bottom: 0;
        border-right: 3px solid #000;
        display: block;
        float: left;
        margin-right: 20px;
        padding-right: 15px;
    }

    .vertical-tabs .sv-tab-panel {
        background: #fff;
        height: 452px;
        padding-top: 10px;
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
    table.table-bordered{
    border:1px solid black;
    margin-top:20px;
  }
table.table-bordered > thead > tr > th{
    border:1px solid black;
}
table.table-bordered > tbody > tr > td{
    border:1px solid black;
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
                <div class="col-md-12 fv-row">
                    <!--begin::Label-->
                    <label class="required fs-6 fw-semibold mb-2">status</label><br>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <select name="statusversion" id="statusversion" required class="form-control form-control-solid statusversion" style="border: 3px solid #ccc;">
                        <option value="">Status</option>
                        <option value="1">Pending</option>
                        <option value="2">Completed</option>
                    </select>

                </div>
                <div class="text-center pt-15">
                    <button type="button" class="btn btn-danger me-3" onclick="closeModel()">Cancel</button>
                    <button type="button" class="btn btn-primary store" onclick="submitForm()">
                        <span class="indicator-label">Update and Exit</span>
                        <span class="indicator-progress">Please wait...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                    </button>
                </div>
            </form>
        </div>

    </div>
    <div class="text-center container">
        <h3>Documents > Ticket No. #{{ $details->id }}</h3>
        <hr style="border: 3px solid #8007f0;border-radius: 8px;">
        <div class="row" style="max-height: 64px!important">
            <div class="col-md-3">
                <h4>Document Type</h4>
                <h4>{{ $details->document_type }}</h4>
            </div>
            <div class="col-md-3">
                <h4>Project Name & Code </h4>
                <h4>{{ $details->project_name }} {{ $details->project_code }}</h4>
            </div>
            <div class="col-md-3">
                <h4>Work Flow Name & Code </h4>
                <h4>{{ $details->workflow_name }} {{ $details->workflow_code }}</h4>
            </div>
            <div class="col-md-3">
                <figure>
                    <img src="{{ url('/images/' . $details->profile_image) }}" class="rounded" width="50" height="50">
                    <figcaption>
                        {{ $details->first_name . ' ' . $details->last_name }},{{ $details->department }},{{ $details->designation }}
                    </figcaption>
                    <figure>
            </div>
        </div>
        <div class="vertical-tabs">

            <ul class="nav nav-tabs" role="tablist">
                <h4>Approval Status</h4>
                @for ($i = 1; $i <= $levelCount; $i++) <li class="nav-item">
                    <a class="nav-link <?php if ($i == 1) {
                                            echo 'active';
                                        } ?>" data-toggle="tab" href="#pag<?php echo $i; ?>" role="tab" aria-controls="home" onclick="get_level_data(<?php echo $i; ?>,<?php echo $details->id; ?>);">Level<?php echo $i; ?></a>
                    </li>
                    @endfor
            </ul>
            <div class="tab-content" >
                @for ($i = 1; $i <= $levelCount; $i++) <div class="tab-pane <?php if ($i == 1) {
                                                                                echo 'active';
                                                                            } ?>" id="pag<?php echo $i; ?>" role="tabpanel">
            </div>

        </div>
        @endfor

    </div>
    </div>
    </div>

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
    //     console.log("well");
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
        get_level_data(1, ProjectId);
        // Get the modal
        var modal = document.getElementById("myModal");

        // Get the button that opens the modal
        var btn = document.getElementById("myBtn");

        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close")[0];


    });
  

    function openVersionModel(id,levelId) {
        $('#versionModel')[0].reset();
        $('#myModal').css('display', 'block');
        $('#myModal').find('.documentId').val(id);
        $('#myModal').find('.levelId').val(levelId);

    }

    function closeModel() {
        $('#versionModel')[0].reset();

        $('#myModal').css('display', 'none');

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
                var data = JSON.parse(result);
                console.log("dahna");
                console.log(data.length);
                if (data.length) {
                    console.log("data if");

                    $("#pag" + level).html("");
                    $(".image_append" + level).empty();
                    var date = new Date(data[0].milestone_created),
                        yr = date.getFullYear(),
                        month = (date.getMonth() + 1) < 10 ? '0' + (date.getMonth() + 1) : (date.getMonth() + 1),
                        day = date.getDate() < 10 ? '0' + date.getDate() : date.getDate(),
                        newDate = day + '-' + month + '-' + yr;
                    $("#pag" + level).html('<div class="sv-tab-panel" ><h3></h3><hr style="border: 3px solid blue;border-radius: 8px;"><div class="jumbotron"><div class="row"><div class="col-md-2">Approvers</div><div class="col-md-6 image_append' + level + '" style="display:inline-flex;flex-flow:row"></div><div class="col-md-4">Milestone:' + newDate + '<br>Milestone Start Date:' + data[0].mile_start_date + '</div></div><hr><div class="doc_append' + level + '" style=" max-height:300px; overflow-y:auto"></div></div></div>');
                    if (data.length > 0) {

                        $(".image_append" + level).empty();
                        $.each(data, function(key, val) {
                            var baseUrl = "{{ asset('images/') }}";
                           
                            $(".image_append" + level).append('<figure><img src="' + baseUrl + '/' + val.staff_image + '" class="rounded" width="50" height="50"><figcaption>' + val.staff_first_name + ' ' + val.staff_last_name + '&nbsp;</figcaption></figure>');
                        });
                        $.ajax({
                            url: "{{ url('getProjectDocs') }}",
                            type: 'ajax',
                            method: 'post',
                            data: {
                                "_token": "{{ csrf_token() }}",
                                level: level,
                                project_id: project_id
                            },
                            success: function(result) {
                                var data = JSON.parse(result);
                                console.log(data);
                              
                                $(".doc_append" + level).empty();
                                if (data.main_docs) {
                                    $.each(data.main_docs, function(key, val) {
                                       var docMainDetailArray = val.doc_detail;
                                      
                                        var baseUrl = "{{ asset('/') }}";
                                        if (val.status == 0) {
                                            var status = "Waiting";
                                        } else if (val.status == 1) {
                                            var status = "Approved";
                                        } else {
                                            var status = "Pending";
                                        }
                                        var versionMainDocDiv = '<div class="row">';
                                            versionMainDocDiv +='<div class="accordion" id="accordionExample' + key + '">';
                                                versionMainDocDiv +='<div class="card"> <div class="card-header" id="heading' + key + '">';
                                                    versionMainDocDiv+='<h5 class="mb-0">';
                                                    versionMainDocDiv+='<button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapse' + key + '" aria-expanded="false" aria-controls="collapse' + key + '"><i class="fa fa-angle-double-right mr-3"></i>' + val.original_name + '</button>';
                                                    versionMainDocDiv+='</h5>';
                                                versionMainDocDiv+='</div>';
                                                versionMainDocDiv+='<div id="collapse' + key + '" class="collapse fade" aria-labelledby="heading' + key + '" data-parent="#accordionExample' + key + '">';
                                                    versionMainDocDiv +='<div class="card-body">';
                                                        versionMainDocDiv +=' <table class="table table-bordered">'; 
                                                            versionMainDocDiv +=' <thead>';
                                                            versionMainDocDiv +=' <tr> <th scope="col">Version </th> <th scope="col">Remarks</th> <th scope="col">Status</th> <th scope="col">Action</th> </tr>';
                                                            versionMainDocDiv +='</thead>';
                                                                versionMainDocDiv +='<tbody style="">';
                                                                    for(var i =0;i<docMainDetailArray.length;i++)
                                                                    {
                                                                        var remarkData = (docMainDetailArray[i].remark)?docMainDetailArray[i].remark:"";
                                                                        var statusData = (docMainDetailArray[i].status ==2)?"Completed":"Pending";
                                                                        versionMainDocDiv +='<tr>';
                                                                            versionMainDocDiv +='<td>v'+docMainDetailArray[i].version+'</td>';
                                                                            versionMainDocDiv +='<td>'+remarkData+'</td>';
                                                                            versionMainDocDiv +='<td>' + statusData + '</td>';
                                                                            versionMainDocDiv +='<td><a class="btn btn-info btn-xs" href="javascript:void(0);" onclick="update_status(' + docMainDetailArray[i].id + ')" title="Change Status"> <i class="las la-toggle-on"></i></a> &nbsp;';
                                                                            versionMainDocDiv +='<a class="btn btn-success btn-xs" href="' + baseUrl + '/' + docMainDetailArray[i].document_name + '" target="_blank" download title="download"><i class="las la-download"></i></a>';
                                                                            versionMainDocDiv +=' <a class="btn btn-warning btn-xs" href="' + baseUrl + '/' + docMainDetailArray[i].document_name + '" target="_blank" view title="view"><i class="las la-eye"></i></a>&nbsp;<button class="btn btn-sm btn-primary" onclick="openVersionModel(' + val.id + ','+level+')"> <i class="las la-upload"></i>';
                                                                            versionMainDocDiv +='</button>';
                                                                            versionMainDocDiv +='</td>';
                                                                        versionMainDocDiv +='</tr>';
                                                                    }
                                                                versionMainDocDiv +='</tbody>';
                                                        versionMainDocDiv +='</table> ';
                                                    versionMainDocDiv +='</div>';
                                                versionMainDocDiv +='</div>';
                                            versionMainDocDiv +='</div>';
                                        versionMainDocDiv +='</div>';
                                                                               
                                       
                                        $(".doc_append" + level).append(versionMainDocDiv);
                                    });
                                }
                                if (data.aux_docs) {
                                    $.each(data.aux_docs, function(key1, val) {
                                        var docAuxDetailArray = val.doc_detail;
                                        console.log(docAuxDetailArray);
                                        var baseUrl = "{{ asset('/') }}";
                                        if (val.status == 0) {
                                            var status = "Waiting";
                                        } else if (val.status == 1) {
                                            var status = "Approved";
                                        } else {
                                            var status = "Pending";
                                        }
                                        var versionAuxDocDiv='<div class="row">';
                                            versionAuxDocDiv+='<div class="accordion" id="accordionExample1">';
                                                versionAuxDocDiv+='<div class="card">';
                                                    versionAuxDocDiv+='<div class="card-header" id="heading' + key1 + '">';
                                                        versionAuxDocDiv+=' <h5 class="mb-0"><button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapse1' + key1 + '" aria-expanded="false" aria-controls="collapse' + key1 + '"><i class="fa fa-angle-double-right mr-3"></i>' + val.original_name + '</button></h5>';
                                                    versionAuxDocDiv+='</div>';
                                                    versionAuxDocDiv+=' <div id="collapse1' + key1 + '" class="collapse fade" aria-labelledby="heading' + key1 + '" data-parent="#accordionExample1">';
                                                        versionAuxDocDiv+='<div class="card-body">';
                                                            versionAuxDocDiv+='<table class="table table-bordered">';
                                                                versionAuxDocDiv+='<thead>';
                                                                    versionAuxDocDiv+='<tr>';
                                                                    versionAuxDocDiv+='<th scope="col">Version</th><th scope="col">Remarks</th> <th scope="col">Status</th> <th scope="col">Action</th>';
                                                                    versionAuxDocDiv+='</tr>';
                                                                versionAuxDocDiv+='</thead>';
                                                                versionAuxDocDiv+=' <tbody>';
                                                                for(j=0;j<docAuxDetailArray.length;j++){
                                                                    var remarkData = (docAuxDetailArray[j].remark)?docAuxDetailArray[j].remark:"";
                                                                        var statusData = (docAuxDetailArray[j].status ==2)?"Completed":"Pending";
                                                                        versionAuxDocDiv +='<tr>';
                                                                        versionAuxDocDiv +='<td>v'+docAuxDetailArray[j].version+'</td>';
                                                                        versionAuxDocDiv +='<td>'+remarkData+'</td>';
                                                                        versionAuxDocDiv +='<td>' + statusData + '</td>';
                                                                        versionAuxDocDiv +='<td><a class="btn btn-info btn-xs" href="javascript:void(0);" onclick="update_status(' + docAuxDetailArray[j].id + ')" title="Change Status"> <i class="las la-toggle-on"></i></a> &nbsp;';
                                                                        versionAuxDocDiv +='<a class="btn btn-success btn-xs" href="' + baseUrl + '/' + docAuxDetailArray[j].document_name + '" target="_blank" download title="download"><i class="las la-download"></i></a>';
                                                                        versionAuxDocDiv +=' <a class="btn btn-warning btn-xs" href="' + baseUrl + '/' + docAuxDetailArray[j].document_name + '" target="_blank" view title="view"><i class="las la-eye"></i></a>&nbsp;<button class="btn btn-sm btn-primary" onclick="openVersionModel(' + val.id + ','+level+')"> <i class="las la-upload"></i>';
                                                                        versionAuxDocDiv +='</button>';
                                                                        versionAuxDocDiv +='</td>';
                                                                        versionAuxDocDiv +='</tr>';
                                                                }
                                                                versionAuxDocDiv+='</tbody>';
                                                            versionAuxDocDiv+='</table>';
                                                        versionAuxDocDiv+='</div>';
                                                    versionAuxDocDiv+='</div>';
                                                versionAuxDocDiv+='</div>';
                                            versionAuxDocDiv+='</div>';
                                        versionAuxDocDiv+='</div>';
                                        $(".doc_append" + level).append(versionAuxDocDiv);
                                    });
                                }
                            },
                            error: function(err) {
                                console.log(err);
                            }
                        });
                        // $(".doc_append" + level).empty();
                        // $(".doc_append" + level).append('<div class="row"> <div class="accordion" id="accordionExample">@foreach ($maindocument as $key=> $md)<div class="card"> <div class="card-header" id="heading<?php echo $key; ?>"> <h5 class="mb-0"><button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapse<?php echo $key; ?>" aria-expanded="false" aria-controls="collapse<?php echo $key; ?>"><i class="fa fa-angle-double-right mr-3"></i>{{$md->document}}</button></h5> </div><div id="collapse<?php echo $key; ?>" class="collapse fade" aria-labelledby="heading<?php echo $key; ?>" data-parent="#accordionExample"> <div class="card-body"> TEST </div></div></div>@endforeach</div></div><div class="row"> <div class="accordion" id="accordionExample1">@foreach ($auxdocument as $key1=> $ad)<div class="card"> <div class="card-header" id="heading<?php echo $key1; ?>"> <h5 class="mb-0"><button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapse1<?php echo $key1; ?>" aria-expanded="false" aria-controls="collapse<?php echo $key1; ?>"><i class="fa fa-angle-double-right mr-3"></i>{{$ad->document}}</button></h5> </div><div id="collapse1<?php echo $key1; ?>" class="collapse fade" aria-labelledby="heading<?php echo $key1; ?>" data-parent="#accordionExample1"> <div class="card-body"> TEST1 </div></div></div>@endforeach</div></div>');
                    }
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
                    console.log("data else");
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
            confirmButtonColor: '#3085d6',
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
                console.log(result.status);
                var ProjectId1 = "{{ $details->id }}";
               if(result.status =='success'){
                var levelId = $('.levelId').val();
                closeModel();
                get_level_data(levelId,ProjectId1);
                }
               
              else{
                    console.log(result);
                    window.location.reload();
                }
            }
        });
    }   
</script>
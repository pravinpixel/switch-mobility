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
</style>
<title>VERTICAL TABS</title>
</head>

<body>

    <div class="text-center container">
        <h3>Projects->Ticket No.#{{ $details->id }}</h3>
        <hr>
        <div class="row">
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
        <hr>

        <div class="vertical-tabs">

            <ul class="nav nav-tabs" role="tablist">
                <h4>Approval Status</h4>
                @for ($i = 1; $i <= 11; $i++) <li class="nav-item">
                    <a class="nav-link <?php if ($i == 1) {
                                            echo 'active';
                                        } ?>" data-toggle="tab" href="#pag<?php echo $i; ?>" role="tab" aria-controls="home" onclick="get_level_data(<?php echo $i; ?>,<?php echo $details->id; ?>);">Level<?php echo $i; ?></a>
                    </li>
                    @endfor
            </ul>
            <div class="tab-content">
                @for ($i = 1; $i <= 11; $i++) <div class="tab-pane <?php if ($i == 1) {
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
      $(document).ready(function() {
        var ProjectId = "{{ $details->id }}";
        get_level_data(1,ProjectId);
      });
    function get_level_data(level, project_id) {
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
                console.log(data);
                $("#pag" + level).html("");
                $(".image_append" + level).empty();
                var date = new Date(data[0].milestone_created),
                    yr = date.getFullYear(),
                    month = (date.getMonth() + 1) < 10 ? '0' + (date.getMonth() + 1) : (date.getMonth() + 1),
                    day = date.getDate() < 10 ? '0' + date.getDate() : date.getDate(),
                    newDate = day + '-' + month + '-' + yr;
                $("#pag" + level).html('<div class="sv-tab-panel" ><h3></h3><hr><div class="jumbotron"><div class="row"><div class="col-md-2">Approvers</div><div class="col-md-6 image_append' + level + '" style="display:inline-flex;flex-flow:row"></div><div class="col-md-4">Milestone:' + newDate + '<br>Milestone Start Date:' + data[0].mile_start_date + '</div></div><hr><div class="doc_append' + level + '" style=" max-height:400px; overflow-y:auto"></div></div></div>');
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
                                    var baseUrl = "{{ asset('/') }}";
                                    if (val.status == 0) {
                                        var status = "Waiting";
                                    } else if (val.status == 1) {
                                        var status = "Approved";
                                    } else {
                                        var status = "Pending";
                                    }
                                    $(".doc_append" + level).append('<div class="row"> <div class="accordion" id="accordionExample' + key + '"><div class="card"> <div class="card-header" id="heading' + key + '"> <h5 class="mb-0"><button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapse' + key + '" aria-expanded="false" aria-controls="collapse' + key + '"><i class="fa fa-angle-double-right mr-3"></i>Main Document</button></h5> </div><div id="collapse' + key + '" class="collapse fade" aria-labelledby="heading' + key + '" data-parent="#accordionExample' + key + '"> <div class="card-body"> <table class="table table-striped"> <thead> <tr> <th scope="col">Remarks</th> <th scope="col">Status</th> <th scope="col">Action</th> </tr></thead> <tbody> <tr> <td>' + val.remarks + '</td><td>' + status + '</td><td><a class="btn btn-info btn-xs" href="javascript:void(0);" onclick="update_status(' + val.id + ')" title="Change Status"> <i class="las la-toggle-on"></i></a> &nbsp;<a class="btn btn-warning btn-xs" href="' + baseUrl + '/' + val.document + '" target="_blank" view title="view"><i class="las la-eye"></i></a>&nbsp;<a class="btn btn-success btn-xs" href="' + baseUrl + '/' + val.document + '" target="_blank" download title="download"><i class="las la-download"></i></a> </td></tr></tbody></table> </div></div></div></div></div>');
                                });
                            }
                            if (data.aux_docs) {
                                $.each(data.aux_docs, function(key1, val) {
                                    var baseUrl = "{{ asset('/') }}";
                                    if (val.status == 0) {
                                        var status = "Waiting";
                                    } else if (val.status == 1) {
                                        var status = "Approved";
                                    } else {
                                        var status = "Pending";
                                    }
                                    $(".doc_append" + level).append('<div class="row"> <div class="accordion" id="accordionExample1"><div class="card"> <div class="card-header" id="heading' + key1 + '"> <h5 class="mb-0"><button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapse1' + key1 + '" aria-expanded="false" aria-controls="collapse' + key1 + '"><i class="fa fa-angle-double-right mr-3"></i>Auxillary Document</button></h5> </div><div id="collapse1' + key1 + '" class="collapse fade" aria-labelledby="heading' + key1 + '" data-parent="#accordionExample1"> <div class="card-body"> <table class="table table-striped"> <thead> <tr> <th scope="col">Remarks</th> <th scope="col">Status</th> <th scope="col">Action</th> </tr></thead> <tbody> <tr> <td>' + val.remarks + '</td><td>' + status + '</td><td><a class="btn btn-info btn-xs" href="javascript:void(0);" onclick="update_status(' + val.id + ')" title="Change Status"> <i class="las la-toggle-on"></i></a> &nbsp;<a class="btn btn-warning btn-xs" href="' + baseUrl + '/' + val.document + '" target="_blank" view title="view"><i class="las la-eye"></i></a>&nbsp;<a class="btn btn-success btn-xs" href="' + baseUrl + '/' + val.document + '" target="_blank" download title="download"><i class="las la-download"></i></a>  </td></tr></tbody></table> </div></div></div></div></div>');
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
                $.ajax({
                    url: "{{ url('docStatus') }}",
                    type: 'ajax',
                    method: 'post',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        id: id,
                    },
                    success: function(result) {
                        if (result) {
                            console.log(result);
                            window.location.reload();
                        }
                    }
                });

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
</script>
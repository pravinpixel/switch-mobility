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
                        <img src="{{ url('/images/' . $details->profile_image) }}" class="rounded" width="50"
                            height="50">
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
                    @for ($i = 0; $i <= 10; $i++)
                        <li class="nav-item">
                            <a class="nav-link <?php if ($i == 0) {
                                echo 'active';
                            } ?>" data-toggle="tab" href="#pag<?php echo $i; ?>"
                                role="tab" aria-controls="home"
                                onclick="get_level_data(<?php echo $i + 1; ?>,<?php echo $details->id; ?>);">Level<?php echo $i + 1; ?></a>
                        </li>
                    @endfor
                </ul>
                <div class="tab-content">
                    @for ($i = 0; $i <= 10; $i++)
                        <div class="tab-pane <?php if ($i == 0) {
                            echo 'active';
                        } ?>" id="pag<?php echo $i; ?>" role="tabpanel">
                            <div class="sv-tab-panel">
                                <h3>Level <?php echo $i + 1; ?></h3>
                                <hr>
                                <div class="jumbotron">

                                    <div class="row">
                                        <div class="col-md-2">
                                            Approvers
                                        </div>
                                        <div class="col-md-6" style="display: inline-flex;flex-flow: row;">
                                            @foreach ($details1 as $det)
                                                <figure>
                                                    <img src="{{ url('/images/' . $det->hod_image) }}" class="rounded"
                                                        width="50" height="50">
                                                    <figcaption>
                                                        {{ $det->hod_first_name . ' ' . $det->hod_last_name }}&nbsp;
                                                    </figcaption>
                                                </figure>
                                                <figure>
                                                    <img src="{{ url('/images/' . $det->staff_image) }}" class="rounded"
                                                        width="50" height="50">
                                                    <figcaption>
                                                        {{ $det->staff_first_name . ' ' . $det->staff_last_name }}&nbsp;
                                                    </figcaption>
                                                </figure>
                                            @endforeach
                                        </div>
                                        <div class="col-md-4">
                                            Milestone:<?php echo date('d-m-Y', strtotime($details1[0]->milestone_created)); ?><br>
                                            Planned Date:<?php echo date('d-m-Y', strtotime($details1[0]->milestone_planned)); ?>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="accordion" id="accordionExample">
                                            @foreach ($details1 as $key => $d1)
                                                <div class="card">
                                                    <div class="card-header" id="heading<?php echo $key; ?>">
                                                        <h5 class="mb-0">
                                                            <button class="btn btn-link btn-block text-left" type="button"
                                                                data-toggle="collapse"
                                                                data-target="#collapse<?php echo $key; ?>"
                                                                aria-expanded="false"
                                                                aria-controls="collapse<?php echo $key; ?>">
                                                                <i
                                                                    class="fa fa-angle-double-right mr-3"></i>{{ $d1->main_document }}
                                                            </button>
                                                        </h5>
                                                    </div>

                                                    <div id="collapse<?php echo $key; ?>" class="collapse fade"
                                                        aria-labelledby="heading<?php echo $key; ?>"
                                                        data-parent="#accordionExample">
                                                        <div class="card-body">
                                                            Anim pariatur cliche reprehenderit, enim eiusmod high
                                                            life
                                                            accusamus terry richardson ad squid. 3 wolf moon officia
                                                            aute, non cupidatat skateboard dolor brunch. Food truck
                                                            quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon
                                                            tempor,
                                                            sunt aliqua put a bird on it squid single-origin coffee
                                                            nulla assumenda shoreditch et. Nihil anim keffiyeh
                                                            helvetica, craft beer labore wes anderson cred nesciunt
                                                            sapiente ea proident. Ad vegan excepteur butcher vice
                                                            lomo.
                                                            Leggings occaecat craft beer farm-to-table, raw denim
                                                            aesthetic synth nesciunt you probably haven't heard of
                                                            them
                                                            accusamus labore sustainable VHS.
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>




                                    </div>
                                </div>
                            </div>
                        </div>
                    @endfor

                </div>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
            integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
        </script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
            integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous">
        </script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"
            integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous">
        </script>
    </body>

    </html>

@endsection
<script data-require="jquery@*" data-semver="3.0.0" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.js">
</script>

<script>
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
            },
            error: function(err) {
                console.log(err);
            }
        });
    }
</script>

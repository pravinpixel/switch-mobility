@extends('layouts.app')

@section('content')
<style>
    * {
        box-sizing: border-box
    }

    /* Style the tab */
    .tab {
        float: left;
        border: 1px solid #ccc;
        background-color: #f1f1f1;
        height: 1100px;
        width: 30%;
    }

    /* Style the buttons inside the tab */
    .tab button {
        display: block;
        background-color: inherit;
        color: black;
        padding: 22px 16px;
        width: 100%;
        border: none;
        outline: none;
        text-align: left;
        cursor: pointer;
        transition: 0.3s;
        font-size: 17px;
    }

    /* Change background color of buttons on hover */
    .tab button:hover {
        background-color: #ddd;
    }

    /* Create an active/current "tab button" class */
    .tab button.active {
        background-color: #ccc;
    }

    /* Style the tab content */
    .tabcontent {
        float: left;
        padding: 0px 12px;
        border: 1px solid #ccc;
        width: 70%;
        border-left: none;
        height: 1100px;
    }

    #critical {
        border: 2px solid white;
        box-shadow: 0 0 0 1px red;
        appearance: none;
        border-radius: 50%;
        width: 12px;
        height: 12px;
        background-color: #fff;
        transition: all ease-in 0.2s;

    }

    #critical:checked {
        background-color: red;
    }

    #low {
        border: 2px solid white;
        box-shadow: 0 0 0 1px green;
        appearance: none;
        border-radius: 50%;
        width: 12px;
        height: 12px;
        background-color: #fff;
        transition: all ease-in 0.2s;

    }

    #low:checked {
        background-color: green;
    }

    #medium {
        border: 2px solid white;
        box-shadow: 0 0 0 1px blue;
        appearance: none;
        border-radius: 50%;
        width: 12px;
        height: 12px;
        background-color: #fff;
        transition: all ease-in 0.2s;

    }

    #medium:checked {
        background-color: blue;
    }

    #high {
        border: 2px solid white;
        box-shadow: 0 0 0 1px black;
        appearance: none;
        border-radius: 50%;
        width: 12px;
        height: 12px;
        background-color: #fff;
        transition: all ease-in 0.2s;

    }

    #high:checked {
        background-color: black;
    }

    .pdf_upload {
        cursor: pointer;
        border: 1px solid lightgrey;

    }

    .pfdf-upload input {
        background-color: lightgrey;
    }

    .plus-pdf {
        background-color: skyblue;
        padding: 10px;
        cursor: pointer;
    }

    .delete-pdf {
        /* background-color: red !important; */
        background-image: linear-gradient(195deg, #CF0D03, #6E0100) !important;
        padding: 10px 15px !important;
        cursor: pointer;
        color: white;
    }

    .delete-pdf i {
        color: white;
    }

    .pdf-iframe {
        width: 100px;
        height: 100px;

    }

    .pdf_delete_btn {
        width: 100px !important;
    }

    .pdf-view {
        border: 1px solid black;
        padding: 5px;
    }

    .pdf {
        margin: 0 10px;
        width: 100px;
    }

    .pdf label {
        width: 100%;
    }

    .pdf-view .upload-text {
        margin: 40px auto;
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
    }

    .pdf-view .upload-text i {
        display: block;
        font-size: 3rem;
        margin-bottom: 0.5rem;
        color: #5C67FF;
    }

    .pdf-view .upload-text span {
        display: block;
    }

    .pdf-view:has(.pdf) .upload-text {
        display: none;
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
                    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                        Project </h1>
                    <!--end::Title-->
                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">
                            <a href="#" class="text-muted text-hover-primary">Home</a>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-400 w-5px h-2px"></span>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">Project</li>
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
                    <div class="card-header border-0 p-3 ">

                        <form method="post">
                            @csrf
                            <!--begin::Row-->
                            <div class="row">
                                <!--begin::Col-->
                                <div class="col-md-3">
                                    <label class="fs-6 form-label fw-bold text-dark ">Project Code / Name </label>
                                    <select class="form-select form-select-solid mainFilters projectId" name="project_code_name" data-kt-select2="true" data-placeholder="Project Code / Name" data-allow-clear="true" id="projectCode">
                                        <option></option>
                                        @foreach ($projects_all as $project)
                                        <option value="{{ $project['id'] }}">
                                            {{ $project['project_name'] }}( {{ $project['project_code'] }})
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <!--begin::Col-->
                                <div class="col-md-2">
                                    <label class="fs-6 form-label fw-bold text-dark "> Initiator </label>
                                    <select class="form-select form-select-solid mainFilters initiatorId " name="initiater" data-kt-select2="true" data-placeholder="Select Initiator" data-allow-clear="true" id="initiator">
                                        <option></option>
                                        @foreach ($initiaters as $employee)
                                        <?php

                                        $initiater = $employee['first_name'] . " " . $employee['middle_name'] . " " . $employee['last_name'];

                                        ?>
                                        <option value="{{ $employee['id']}}">
                                            {{ $initiater }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-sm-2">
                                    <label class="fs-6 form-label fw-bold text-dark">Start Date</label>
                                    <input type="date" class="form-control dateWiseFilter startDate" id="startDate" name="start_date" placeholder="Enter Start Date">
                                </div>
                                <div class="col-sm-2">
                                    <label class="fs-6 form-label fw-bold text-dark">End Date</label>
                                    <input type="date" class="form-control dateWiseFilter endDate" id="endDate" name="end_date" placeholder="Enter End Date">
                                </div>
                                <div class="w-auto SearchFilter">
                                    <label class="fs-6 fw-semibold d-block mb-2">&nbsp;</label>
                                    <span class="btn btn-success">Search</span>
                                </div>
                                <div class="w-auto">
                                    <label class="fs-6 fw-semibold d-block mb-2">&nbsp;</label>
                                    <span class="btn btn-warning " onclick="reset()">Reset</span>
                                </div>
                            </div>
                        </form>


                        <div class="card-toolbar add-button-datatable">
                            <!--begin::Toolbar-->
                            <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                                <!--begin::Filter-->
                                @if(auth()->user()->is_super_admin ==1 ||auth()->user()->can('project-create'))
                                <!--begin::Add user-->
                                <a href="{{url('projects/create')}}">
                                    <button type="button" class="btn switchPrimaryBtn ">
                                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr075.svg-->
                                        <span class="svg-icon svg-icon-2">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1" transform="rotate(-90 11.364 20.364)" fill="currentColor" />
                                                <rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="currentColor" />
                                            </svg>
                                        </span>
                                        <!--end::Svg Icon-->Add
                                    </button>
                                </a>
                                @endif
                                <!--end::Add user-->
                            </div>
                            <!--end::Toolbar-->
                            <!--begin::Group actions-->
                            <div class="d-flex justify-content-end align-items-center d-none" data-kt-user-table-toolbar="selected">
                                <div class="fw-bold me-5">
                                    <span class="me-2" data-kt-user-table-select="selected_count"></span>Selected
                                </div>
                                <button type="button" class="btn btn-danger" data-kt-user-table-select="delete_selected">Delete Selected</button>
                            </div>
                            <!--end::Group actions-->

                            <!--begin::Modal - Add task-->
                            <div class="modal fade" id="kt_modal_add_user" tabindex="-1" aria-hidden="true">
                                <!--begin::Modal dialog-->
                                <div class="modal-dialog modal-dialog-centered mw-850px">
                                    <!--begin::Modal content-->
                                    <div class="modal-content">

                                        <!--begin::Modal header-->
                                        <div class="modal-header" id="kt_modal_add_user_header">
                                            <!--begin::Modal title-->
                                            <h2 class="fw-bold">Add</h2>
                                            <!--end::Modal title-->
                                            <!--begin::Close-->
                                            <div class="btn btn-icon btn-sm btn-active-icon-primary" data-kt-users-modal-action="close">
                                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                                                <span class="svg-icon svg-icon-1">
                                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor" />
                                                        <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor" />
                                                    </svg>
                                                </span>
                                                <!--end::Svg Icon-->
                                            </div>
                                            <!--end::Close-->
                                        </div>
                                        <!--end::Modal header-->
                                        <!--begin::Modal body-->
                                        <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">



                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!--end::Card header-->
                    <!--begin::Card body-->
                    <div class="card-body  p-3">

                        <!--begin::Table-->
                        <table class="table align-middle table-row-bordered fs-6 gy-5" id="service_table">
                            <!--begin::Table head-->
                            <thead>
                                <!--begin::Table row-->
                                <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">

                                    <th class="min-w-50px">Project Code</th>
                                    <th class="min-w-50px">Project Name</th>
                                    <th class="min-w-50px">Start Date</th>
                                    <th class="min-w-50px">End Date</th>
                                    <th class="min-w-50px">Project Initiator</th>
                                    <!-- <th class="min-w-125px">Current Milestone</th>
                                    <th class="min-w-125px">Milestone Start Date</th>
                                    <th class="min-w-125px">Milestone End Date</th> -->
                                    <th class="text-end min-w-100px">Actions</th>
                                </tr>
                                <!--end::Table row-->
                            </thead>
                            <!--end::Table head-->
                            <!--begin::Table body-->
                            <tbody class="text-gray-600 fw-semibold">
                                <!--begin::Table row-->
                                @foreach ($projects_all as $key => $d)
                                <?php
                                $employee = $d['employee'];
                                $initiater = "";
                                if ($employee) {
                                    $initiater = $employee->first_name . " " . $employee->middle_name . " " . $employee->last_name;
                                }
                                ?>
                                <tr>

                                    <td>{{ $d->project_code }}</td>
                                    <td>{{ $d->project_name }}</td>
                                    <td>{{ date('d-m-Y', strtotime($d->start_date)) }}</td>
                                    <td>{{ date('d-m-Y', strtotime($d->end_date)) }}</td>
                                    <td>{{ $initiater }}</td>
                                    <!-- <td></td>
                                    <td></td> -->
                                    <td>
                                        <div class="d-flex my-3 ms-9">
                                            <!--begin::Edit-->
                                            @if (auth()->user()->is_super_admin == 1 ||auth()->user()->can('project-edit'))

                                            <a class="editProject" style="display:inline;cursor: pointer;" id="{{ $d->id }}" title="Edit Project"><i class="fa-solid fa-pen" style="color:orange"></i></a>

                                            @endif
                                            @if (auth()->user()->is_super_admin == 1 || auth()->user()->can('project-delete'))
                                            <div onclick="delete_item(<?php echo $d->id; ?>);" style="display:inline;cursor: pointer; margin-left: 10px;" id="{{ $d->id }}" class="" title="Delete Project"><i class="fa-solid fa-trash" style="color:red"></i></div>


                                            @endif

                                            <!--end::More-->
                                        </div>
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
    $(document).ready(function() {
        var isSuperAdmin = "{{ auth()->user()->is_super_admin }}";
        var isAuthorityEdit = "{{ auth()->user()->can('project-edit') }}";
        var isAuthorityDelete = "{{ auth()->user()->can('project-delete') }}";

    });
    $(document).on('change click', '.mainFilters', function() {

        $('.mainFilters').not($(this)).val('').trigger('change');
        $('.dateWiseFilter').val('');
    });
    $(document).on('change click', '.dateWiseFilter', function() {

        $('.mainFilters').not($(this)).val('').trigger('change');
        var startDateInput = document.getElementById('startDate');
        var endDateInput = document.getElementById('endDate');
        // Get the selected dates from the input fields
        var startDate = new Date(startDateInput.value);
        var endDate = new Date(endDateInput.value);

        // Check if the end date is before the start date
        if (endDate < startDate) {
            $('.endDate').val('');
        }

    });
    $(".endDate").change(function() {
        $('.startDate').attr("max", $(this).val());
        var startDate = $('.startDate').val();
        var endDate = $('.startDate').val();     
    });
    $(".startDate").change(function() {
        $('.endDate').attr("min", $(this).val());
        var startDate = $('.startDate').val();
        var endDate = $('.endDate').val();       
    });

    function reset() {


        location.reload();
        // $("#service_table").load(location.href + " #service_table").abort();




    }
    $(document).on('click', '.SearchFilter', function() {
        var isSuperAdmin = "{{ auth()->user()->is_super_admin }}";
        var isAuthorityEdit = "{{ auth()->user()->can('project-edit') }}";
        var isAuthorityDelete = "{{ auth()->user()->can('project-delete') }}";

        console.log("well");
        var table = $('#service_table').DataTable();
        var projectId = $('.projectId').val();
        var initiatorId = $('.initiatorId').val();
        var startDate = $('.startDate').val();
        var endDate = $('.endDate').val();
        var nextpart = false;
        var paramName = "";
        var paramData = "";
        if (projectId) {
            paramName = "projectId";
            nextpart = true;
        } else if (initiatorId) {

            paramName = "initiatorId";
            nextpart = true;
        } else if (startDate && endDate) {

            paramName = "dates";
            nextpart = true;

        } else {

            paramName = "";
            nextpart = true;
        }

        if (nextpart == true) {
            $.ajax({
                url: "{{ route('projectListFilters') }}",
                type: 'ajax',
                method: 'post',
                data: {
                    "_token": "{{ csrf_token() }}",
                    projectId: projectId,
                    initiatorId: initiatorId,
                    startDate: startDate,
                    endDate: endDate,
                    paramName: paramName
                },
                success: function(data) {
                    console.log(data);
                    table.clear().draw();


                    $.each(data.datas, function(key, val) {

                        var id = val.id;
                        var projectCode = val.project_code;
                        var projectName = val.project_name;

                        var start_date = val.start_date;
                        var end_date = val.end_date;
                        var employeeModel = val.employee;
                        var initiatorName = "";
                        if (employeeModel) {

                            var FirstName = (employeeModel.first_name) ? employeeModel.first_name : '';
                            var MidName = (employeeModel.middle_name) ? employeeModel.middle_name : '';
                            var LastName = (employeeModel.last_name) ? employeeModel.last_name : '';
                            initiatorName = FirstName + "" + MidName + " " + LastName;

                        }
                        var editUrl = "";
                        var deleteBtn = "";

                        if (isSuperAdmin || isAuthorityEdit || isAuthorityDelete) {
                            var editUrl = '<a class="editProject" style="display:inline;cursor: pointer;" id="' + id + '" title="Edit Project"><i class="fa-solid fa-pen" style="color:orange"></i></a>';
                        }
                        if (isSuperAdmin || isAuthorityEdit || isAuthorityDelete) {
                            var deleteBtn = '<div onclick="delete_item(' + id + ');" style="display:inline;cursor: pointer; margin-left: 10px;" id="' + id + '" class="" title="Delete Project"><i class="fa-solid fa-trash" style="color:red"></i></div>';

                        }

                        // var editurl = '{{ route("employees.edit", ":id") }}';
                        // editurl = editurl.replace(':id', id);
                        // var editBtn = (
                        //     '<a href="' + editurl + '" style="display:inline;cursor: pointer;" title="Edit Employeee"><i class="fa-solid fa-pen" style="color:orange"></i></a>'
                        // );
                        // var deleteBtn = (
                        //     '<div  onclick="delete_item(' + id + ');" style="display:inline;cursor: pointer;margin-left: 10px;" title="Delete Employeee"><i class="fa-solid fa-trash" style="color:red"></i></div>'
                        // );


                        var Action = (editUrl +
                            deleteBtn
                        );
                        // var status = val.is_active;
                        // var person = pic + "<br>" + firstName + " " + lastName +
                        //     "<br>" + "Email:" + email;
                        // var result = (
                        //     '<label class="switch"><input type="checkbox" data-id="' +
                        //     id + '" class="status" ' + activeStatus +
                        //     '>  <span class="slider round"></span></label>');

                        table.row.add([projectCode, projectName, start_date, end_date, initiatorName, Action]).draw();

                    });


                },
                error: function() {
                    $("#otp_error").text("Update Error");
                }

            });
        }
    });
    $(document).on('blur', '.project_name', function() {
        console.log("$(this).val()");


        $.ajax({
            url: "{{ route('projectNameValidation') }}",
            type: 'ajax',
            method: 'post',
            data: {
                "_token": "{{ csrf_token() }}",
                id: $('.project_id').val(),
                name: $('.project_name').val(),
            },
            success: function(data) {
                console.log(data);


                var alertName = 'projectNameAlert';
                console.log(data.response);
                console.log(alertName);

                if (data.response == false) {
                    $('#submitBtn').attr('disabled', true);

                    document.getElementById(alertName).style.display = "block";
                    document.getElementById(alertName).style.color = "red";
                    document.getElementById(alertName).innerHTML = 'Name Is Exists*';
                    return false;
                }
                document.getElementById(alertName).style.display = "none";
                $('#submitBtn').attr('disabled', false);
                return true;


            },
            error: function() {
                $("#otp_error").text("Update Error");
            }

        });

    });

    $(function() {
        $('.multi-field-wrapper').each(function() {
            var $wrapper = $('.multi-fields', this);

            $(".add-field", $(this)).click(function(e) {

                var length = $(".multi-field").length;
                var inputAppends = $(".multi-field input[required]");
                let identity;
                $(".notifyAlert").remove();

                $.each(inputAppends, function(index, inputAppend) {
                    var inputValue = inputAppend.value;
                    // Do something with the input value in each iteration, such as calling a function
                    if (inputValue == "") {
                        identity = $(inputAppend).prev().html();
                        $(inputAppend).parent().append(`<p class="notifyAlert" style="display: block; color: red;">` + identity + ` Is Mandatory*</p> `);
                    }

                });
                if ($(".notifyAlert").length == 0) {
                    if (length <= 11) {
                        $('.multi-field:first-child', $wrapper).clone(true).appendTo($wrapper).find(
                            'input').val('').focus();
                    }
                }

            });


            $('.multi-field .remove-field', $wrapper).click(function() {
                if ($('.multi-field', $wrapper).length > 1)
                    $(this).parent('.multi-field').remove();
            });
        });
    });
</script>


@endsection
<script data-require="jquery@*" data-semver="3.0.0" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.js">
</script>
<script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $(".initiator_id").select2({
            dropdownParent: $("#kt_modal_create_campaign")
        });
        $(".initiator_id").select2({
            dropdownParent: $("#kt_modal_create_campaign")
        });
        // on form submit
        $("#designation_form").on('submit', function() {
            // to each unchecked checkbox
            $(this).find('input[type=checkbox]:not(:checked)').prop('checked', true).val(0);
        })

        $(".designation_form_edit").on('submit', function() {
            // to each unchecked checkbox
            $(this).find('input[type=checkbox]:not(:checked)').prop('checked', true).val(0);
        })
    })
    setTimeout(function() {
        $('.alert').fadeOut('fast');
    }, 5000);

    $(document).ready(function() {
        $('.modal').each(function() {
            $(this).on('hidden.bs.modal', function() {
                window.location.reload();
                //fires when evey popup close. Ex. resetModal();
            });
        });
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

    function set_min(start_date) {
        $('.end_date').attr('min', start_date);
    }

    function set_min_max_value() {
        var start_date = $('.start_date').val();
        var end_date = $('.end_date').val();
        $('.planned_date').attr('min', start_date);
        $('.planned_date').attr('max', end_date);
    }

    function set_mile_min_max() {
        var start_date = $('.start_date').val();
        var end_date = $('.end_date').val();
        $('.mile_start_date').attr('min', start_date);
        $('.mile_start_date').attr('max', end_date);
        $('.mile_end_date').attr('min', start_date);
        $('.mile_end_date').attr('max', end_date);
    }

    function set_min_max_value_due_date() {
        var start_date = $('.start_date').val();
        var end_date = $('.end_date').val();
        $('.duedate').attr('min', start_date);
        $('.duedate').attr('max', end_date);
    }


    function openCity(evt, cityName, level) {
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tabcontent");
        var $Blocktab = $(tabcontent).filter(function() {
            return $(this).css("display") === "block";
        });

        if ($Blocktab.length) {
            $Blocktab.find("input[required]").each(function() {
                if ($(this).val().trim() === "") {
                    $(".error-msg").remove();
                    $(this).after("<span class='error-msg'>This field is required.</span>");

                } else {
                    for (i = 0; i < tabcontent.length; i++) {
                        tabcontent[i].style.display = "none";
                    }
                    tablinks = document.getElementsByClassName("tablinks");
                    for (i = 0; i < tablinks.length; i++) {
                        tablinks[i].className = tablinks[i].className.replace(" active", "");
                    }
                    document.getElementById("London" + level).style.display = "block";
                    evt.currentTarget.className += " active";
                    var project_id = $(".project_id").val();
                    var workflow_id = $('.workflow_id').find(":selected").val();
                    if (project_id === '' && workflow_id != '') {

                        $.ajax({
                            url: "{{ url('getEmployeeByWorkFlow') }}",
                            method: "POST",
                            type: "ajax",
                            data: {
                                "_token": "{{ csrf_token() }}",
                                workflow_id: workflow_id,
                                level: level
                            },
                            success: function(result) {
                                var data = JSON.parse(result);
                                console.log(data);
                                if (data.designation_name) {
                                    $(".staff_label").html(data.designation_name);
                                }
                                if (data.employees) {
                                    $('.employee_append' + level)
                                        .find('option')
                                        .remove();
                                    $(".employee_append" + level).prepend("<option value=''></option>").val('');
                                    $.each(data.employees, function(key, value) {
                                        var option = '<option value="' + value.id + '">' + value.first_name + " " + value.last_name +
                                            '</option>';
                                        $('.employee_append' + level).append(option);
                                    });
                                }

                            },
                            error: function(error) {
                                console.log(error);
                            }
                        });
                    } else {
                        $.ajax({
                            url: "{{ route('getProjectDetailsById') }}",
                            type: 'ajax',
                            method: 'post',
                            data: {
                                "_token": "{{ csrf_token() }}",
                                project_id: project_id,
                                level: level
                            },
                            success: function(result) {
                                var data = JSON.parse(result);
                                console.log(data.main_documents);
                                // $(".main_document"+level).empty();
                                $.each(data.main_documents, function(key2, value2) {
                                    var n = level - 1;
                                    $(".main_document" + n).empty();
                                    if (value2.document) {
                                        var file = "{{ URL::to('/') }}" + value2.document;
                                        var attachment = '<a href="' + file + '" target="_blank" class="main_document" style="">Click to Open</a>&nbsp;<a href="javascript:void(0);" onclick="delete_document(' + value2.id + ');"><i style="color: red;" class="fas fa-trash"></i></a><br>';
                                        $(".main_document" + n).append(attachment);
                                    }
                                });
                                console.log(data.aux_documents);

                                $.each(data.aux_documents, function(key3, value3) {
                                    var n = level - 1;
                                    $(".auxillary_document" + n).empty();
                                    if (value3.document) {
                                        var file = "{{ URL::to('/') }}" + value3.document;
                                        var attachment = '<a href="' + file + '" target="_blank" class="main_document" style="">Click to Open</a>&nbsp;<a href="javascript:void(0);" onclick="delete_document(' + value3.id + ');"><i style="color: red;" class="fas fa-trash"></i></a><br>';
                                        $(".auxillary_document" + n).append(attachment);
                                    }
                                });
                            }
                        });
                    }
                }
            });
        }


    }
    $(function() {

        document.getElementById("defaultOpen").click(function(e) {
            e.preventDefault();
        });

        for (i = 0; i <= 10; i++) {
            $(".main_document" + i).hide();
            $(".auxillary_document" + i).hide();
        }
    });




    function get_document_workflow(document_type_id) {
        var workflow_id = $('.workflow_id').find(":selected").val();
        $.ajax({
            url: "{{ url('getWorkflowByDocumentType') }}",
            method: "POST",
            type: "ajax",
            data: {
                "_token": "{{ csrf_token() }}",
                document_type_id: document_type_id
            },
            success: function(result) {
                var data = JSON.parse(result);
                $('.workflow_edit')
                    .find('option')
                    .remove();
                $(".workflow_hidden").val(data[0].id);
                $.each(data, function(key, value) {
                    var option = '<option selected value="' + value.id + '">' + value.workflow_name +
                        '</option>';
                    $('.workflow_edit').append(option);
                    get_workflow_type(value.id);
                });
            },
            error: function(error) {
                console.log(error);
            }
        });
    }



    function get_workflow_type(workflow_id) {
        console.log("Old function done");
        $.ajax({
            url: "{{ url('getWorkflowById') }}",
            type: 'ajax',
            method: 'post',
            data: {
                "_token": "{{ csrf_token() }}",
                workflow_id: workflow_id,
            },
            success: function(result) {
                $('.tab').html("");
                $('.LevelTabContent').html("");
                var data = JSON.parse(result);
                var WFLevelBtn = data['workflow_level'];
                console.log(WFLevelBtn);
                var SelectId = [];
                if (WFLevelBtn) {

                    for (var wfl = 0; wfl < WFLevelBtn.length; wfl++) {
                        console.log(WFLevelBtn[wfl].levelId);
                        console.log(WFLevelBtn[wfl].designationId);
                        var levelDesignation = WFLevelBtn[wfl].designationId;

                        var levelBtnRow = '<button type="button" class="tablinks"  onclick="openCity(event, London' + WFLevelBtn[wfl].levelId + ',' + WFLevelBtn[wfl].levelId + ')" id="defaultOpen" >Level' + WFLevelBtn[wfl].levelId + '</button>';
                        $('.tab').append(levelBtnRow);
                        var contentshow = "";
                        if (wfl != 0) {
                            contentshow = "style='display:none'";
                        }

                        var levelTabContentData = '<div id="London' + WFLevelBtn[wfl].levelId + '" class="tabcontent" ' + contentshow + '>';
                        levelTabContentData += '<br><h4 style="text-align:center;">Level' + WFLevelBtn[wfl].levelId + '</h4>';

                        levelTabContentData += '<input type="hidden" class="project_level' + WFLevelBtn[wfl].levelId + '" name="project_level[]" value="' + WFLevelBtn[wfl].levelId + '">';

                        levelTabContentData += '<div class="col-md-12 fv-row">';
                        levelTabContentData += '<label class="required fs-6 fw-semibold mb-2">Due Date</label>';
                        levelTabContentData += '<input type="date" required class="form-control w-50 duedate due_date' + WFLevelBtn[wfl].levelId + '" name="due_date[]" onclick="set_min_max_value_due_date();" />';
                        levelTabContentData += '</div><br><br>';
                        levelTabContentData += '<div class="col-md-12 fv-row"><label class="required fs-6 fw-semibold mb-2">Priority</label><br>';

                        levelTabContentData += 'Important <input id="critical" type="checkbox" class="priority priority1' + WFLevelBtn[wfl].levelId + '" name="priority[]" value="1">&nbsp;&nbsp;';
                        levelTabContentData += 'Medium <input id="low" type="checkbox" class="priority priority2' + WFLevelBtn[wfl].levelId + '" name="priority[]" value="2">&nbsp;&nbsp;';
                        levelTabContentData += 'Low <input id="medium" type="checkbox" class="priority priority3' + WFLevelBtn[wfl].levelId + '" name="priority[]" value="3">&nbsp;&nbsp;';
                        levelTabContentData += 'High <input id="high" type="checkbox" class="priority priority4' + WFLevelBtn[wfl].levelId + '" name="priority[]" value="4" checked>';

                        levelTabContentData += '</div><br><br>';
                        levelTabContentData += '<h4>Approvers</h4>';
                        levelTabContentData += ' <div class="col-md-6 fv-row">';
                        for (var lvldesc = 0; lvldesc < levelDesignation.length; lvldesc++) {
                            var levelApprovers = levelDesignation[lvldesc].desEmployee;

                            levelTabContentData += '<br><br><h4>' + levelDesignation[lvldesc].desName + '</h4>';
                            var uniqueId = "SelectLevel" + wfl + lvldesc;
                            var uniqueApproverName = "approver_" + WFLevelBtn[wfl].levelId + "_" + lvldesc;
                            console.log("uniqueApproverName >" + uniqueApproverName);
                            SelectId.push(uniqueId);
                            levelTabContentData += '<select name = "' + uniqueApproverName + '[]" class="form-select w-50 form-select-solid" id="' + uniqueId + '" data-control="select2" data-placeholder="Select an option" data-allow-clear="true" multiple="multiple">';
                            levelTabContentData += '<option></option>';
                            for (var lvlApvrs = 0; lvlApvrs < levelApprovers.length; lvlApvrs++) {

                                levelTabContentData += '<option value="' + levelApprovers[lvlApvrs].id + '">' + levelApprovers[lvlApvrs].first_name + '</option>';

                            }
                            levelTabContentData += '</select>';

                        }
                        levelTabContentData += '</div><br><br>';

                        levelTabContentData += '<div class="col-md-12 fv-row">';
                        levelTabContentData += '<label class="fs-6 fw-semibold mb-2">Documents</label><br>';
                        levelTabContentData += ' <div class="col-md-12 p-3 pdf_container input-group">  <label class="row col-12 m-2 pdf-view row " for="pdf' + WFLevelBtn[wfl].levelId + '"> <div class="upload-text"><i class="fa fa-cloud-upload"></i><span>Drag &amp; Drop files here or click to browse</span></div> </label> <input type="file" name="main_document' + WFLevelBtn[wfl].levelId + '[]" id="pdf' + WFLevelBtn[wfl].levelId + '" class="form-control border-0" onchange="pdfPreview(this)" style="display:none;" accept=".csv,.pdf, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"> </div>';
                        levelTabContentData += '</div';

                        levelTabContentData += '<br><br><div class="col-md-12 fv-row">';
                        levelTabContentData += '<label class="fs-6 fw-semibold mb-2">Auxillary Documents</label><br>';
                        levelTabContentData += '<div class="col-md-12 p-3 pdf_container input-group">  <label class="row col-12 m-2 pdf-view row " for="pdfa1a2' + WFLevelBtn[wfl].levelId + '"> <div class="upload-text"><i class="fa fa-cloud-upload"></i><span>Drag &amp; Drop files here or click to browse</span></div> </label> <input type="file" name="auxillary_document' + WFLevelBtn[wfl].levelId + '[]" id="pdfa1a2' + WFLevelBtn[wfl].levelId + '"class="form-control border-0" onchange="pdfPreview(this)" style="display:none;" accept=".csv,.pdf, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"> </div>';
                        levelTabContentData += '</div';

                        levelTabContentData += '</div>';

                        $('.LevelTabContent').append(levelTabContentData);

                    }
                    SelectId.forEach(function(selectId) {
                        $("#" + selectId).select2();
                    });

                }

                if (WFLevelBtn.length) {
                    $('.levels_to_be_crossed')
                        .find('option')
                        .remove();
                    for (var i = 0; i < WFLevelBtn.length; i++) {
                        console.log("LevelData " + WFLevelBtn[i].levelId);
                        var option = '<option selected value="' + +WFLevelBtn[i].levelId + '">' + +WFLevelBtn[i].levelId +
                            '</option>';
                        $('.levels_to_be_crossed').append(option);
                    }


                    $(".total_levels").val(WFLevelBtn.length);
                } else {
                    $(".total_levels").val(0);
                }
            }
        });

        var project_id = $(".project_id").val();
        console.log("project_id" + project_id);
        if (project_id === "") {
            $.ajax({
                url: "{{ url('getEmployeeByWorkFlow') }}",
                method: "POST",
                type: "ajax",
                data: {
                    "_token": "{{ csrf_token() }}",
                    workflow_id: workflow_id,
                    level: 1
                },
                success: function(employee) {
                    var data1 = JSON.parse(employee);
                    console.log(data1);
                    if (data1.designation_name) {
                        $(".staff_label").html(data1.designation_name);
                    }
                    if (data1.employees) {
                        $('.employee_append1')
                            .find('option')
                            .remove();
                        $(".employee_append1").prepend("<option value=''>Select</option>").val('');
                        $.each(data1.employees, function(key1, value1) {
                            var option = '<option value="' + value1.id + '">' + value1.first_name + " " + value1.last_name +
                                '</option>';
                            $('.employee_append1').append(option);
                        });
                    }
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }

    }

    function get_workflow_typeEdit(workflow_id) {
        console.log("this function done");
        $.ajax({
            url: "{{ url('getWorkflowByProjectId') }}",
            type: 'ajax',
            method: 'post',
            data: {
                "_token": "{{ csrf_token() }}",
                workflow_id: workflow_id,
                project_id: $(".project_id").val(),
            },
            success: function(result) {

                $('.tab').html("");
                $('.LevelTabContent').html("");
                var data = result.response;

                var WFLevelBtn = data.workflow_level;

                var SelectId = [];
                if (WFLevelBtn) {

                    for (var wfl = 0; wfl < WFLevelBtn.length; wfl++) {

                        var levelDesignation = WFLevelBtn[wfl].designationId;

                        var masterData = WFLevelBtn[wfl].projectMasterData;
                        var projectApprovers = WFLevelBtn[wfl].projectApprovers;

                        var priority = masterData.priority;
                        var due_date = masterData.due_date;
                        console.log(projectApprovers);

                        var levelBtnRow = '<button type="button" class="tablinks"  onclick="openCity(event, London' + WFLevelBtn[wfl].levelId + ',' + WFLevelBtn[wfl].levelId + ')" id="defaultOpen" >Level' + WFLevelBtn[wfl].levelId + '</button>';
                        $('.tab').append(levelBtnRow);
                        var contentshow = "";
                        if (wfl != 0) {
                            contentshow = "style='display:none'";
                        }

                        var levelTabContentData = '<div id="London' + WFLevelBtn[wfl].levelId + '" class="tabcontent" ' + contentshow + '>';
                        levelTabContentData += '<br><h4 style="text-align:center;">Level' + WFLevelBtn[wfl].levelId + '</h4>';

                        levelTabContentData += '<input type="hidden" class="project_level' + WFLevelBtn[wfl].levelId + '" name="project_level[]" value="' + WFLevelBtn[wfl].levelId + '">';

                        levelTabContentData += '<div class="col-md-12 fv-row">';
                        levelTabContentData += '<label class="required fs-6 fw-semibold mb-2">Due Date</label>';
                        levelTabContentData += '<input type="date" required class="form-control w-50 duedate due_date' + WFLevelBtn[wfl].levelId + '" name="due_date[]" onclick="set_min_max_value_due_date();" value="' + due_date + '"/>';
                        levelTabContentData += '</div><br><br>';
                        levelTabContentData += '<div class="col-md-12 fv-row"><label class="required fs-6 fw-semibold mb-2">Priority</label><br>';
                        var check1 = (priority == 1) ? "checked" : "";
                        var check2 = (priority == 2) ? "checked" : "";
                        var check3 = (priority == 3) ? "checked" : "";
                        var check4 = (priority == 4) ? "checked" : "";

                        levelTabContentData += 'Important <input id="critical" type="checkbox" class="priority priority1' + WFLevelBtn[wfl].levelId + '" name="priority[]" value="1" ' + check1 + '>&nbsp;&nbsp;';
                        levelTabContentData += 'Medium <input id="low" type="checkbox" class="priority priority2' + WFLevelBtn[wfl].levelId + '" name="priority[]" value="2" ' + check2 + '>&nbsp;&nbsp;';
                        levelTabContentData += 'Low <input id="medium" type="checkbox" class="priority priority3' + WFLevelBtn[wfl].levelId + '" name="priority[]" value="3" ' + check3 + '>&nbsp;&nbsp;';
                        levelTabContentData += 'High <input id="high" type="checkbox" class="priority priority4' + WFLevelBtn[wfl].levelId + '" name="priority[]" value="4" ' + check4 + '>';

                        levelTabContentData += '</div><br><br>';
                        levelTabContentData += '<h4>Approvers</h4>';
                        levelTabContentData += ' <div class="col-md-6 fv-row">';
                        for (var lvldesc = 0; lvldesc < levelDesignation.length; lvldesc++) {
                            var levelApprovers = levelDesignation[lvldesc].desEmployee;

                            levelTabContentData += '<br><br><h4>' + levelDesignation[lvldesc].desName + '</h4>';
                            var uniqueId = "SelectLevel" + wfl + lvldesc;
                            var uniqueApproverName = "approver_" + WFLevelBtn[wfl].levelId + "_" + lvldesc;
                            console.log("uniqueApproverName >" + uniqueApproverName);
                            SelectId.push(uniqueId);
                            levelTabContentData += '<select name = "' + uniqueApproverName + '[]" class="form-select w-50 form-select-solid" id="' + uniqueId + '" data-control="select2" data-placeholder="Select an option" data-allow-clear="true" multiple="multiple">';
                            levelTabContentData += '<option></option>';
                            for (var lvlApvrs = 0; lvlApvrs < levelApprovers.length; lvlApvrs++) {
                                var selectedStatus = (projectApprovers.includes(levelApprovers[lvlApvrs].id)) ? "selected" : "";
                                levelTabContentData += '<option value="' + levelApprovers[lvlApvrs].id + '" ' + selectedStatus + '>' + levelApprovers[lvlApvrs].first_name + '</option>';

                            }
                            levelTabContentData += '</select>';

                        }
                        levelTabContentData += '</div><br><br>';

                        levelTabContentData += '<div class="col-md-12 fv-row">';
                        levelTabContentData += '<label class="fs-6 fw-semibold mb-2">Documents</label><br>';
                        levelTabContentData += ' <div class="col-md-12 p-3 pdf_container input-group">  <label class="row col-12 m-2 pdf-view row " for="pdf' + WFLevelBtn[wfl].levelId + '"> <div class="upload-text"><i class="fa fa-cloud-upload"></i><span>Drag &amp; Drop files here or click to browse</span></div> </label> <input type="file" name="main_document' + WFLevelBtn[wfl].levelId + '[]" id="pdf' + WFLevelBtn[wfl].levelId + '" class="form-control border-0" onchange="pdfPreview(this)" style="display:none;" accept=".csv,.pdf, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"> </div>';
                        levelTabContentData += '</div';

                        levelTabContentData += '<br><br><div class="col-md-12 fv-row">';
                        levelTabContentData += '<label class="fs-6 fw-semibold mb-2">Auxillary Documents</label><br>';
                        levelTabContentData += '<div class="col-md-12 p-3 pdf_container input-group">  <label class="row col-12 m-2 pdf-view row " for="pdfa1a2' + WFLevelBtn[wfl].levelId + '"> <div class="upload-text"><i class="fa fa-cloud-upload"></i><span>Drag &amp; Drop files here or click to browse</span></div> </label> <input type="file" name="auxillary_document' + WFLevelBtn[wfl].levelId + '[]" id="pdfa1a2' + WFLevelBtn[wfl].levelId + '"class="form-control border-0" onchange="pdfPreview(this)" style="display:none;" accept=".csv,.pdf, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"> </div>';
                        levelTabContentData += '</div';

                        levelTabContentData += '</div>';

                        $('.LevelTabContent').append(levelTabContentData);

                    }
                    SelectId.forEach(function(selectId) {
                        $("#" + selectId).select2();
                    });

                }

                if (WFLevelBtn.length) {
                    $('.levels_to_be_crossed')
                        .find('option')
                        .remove();
                    for (var i = 0; i < WFLevelBtn.length; i++) {
                        console.log("LevelData " + WFLevelBtn[i].levelId);
                        var option = '<option selected value="' + +WFLevelBtn[i].levelId + '">' + +WFLevelBtn[i].levelId +
                            '</option>';
                        $('.levels_to_be_crossed').append(option);
                    }


                    $(".total_levels").val(WFLevelBtn.length);
                } else {
                    $(".total_levels").val(0);
                }
            }
        });

        var project_id = $(".project_id").val();

        if (project_id === "") {
            $.ajax({
                url: "{{ url('getEmployeeByWorkFlow') }}",
                method: "POST",
                type: "ajax",
                data: {
                    "_token": "{{ csrf_token() }}",
                    workflow_id: workflow_id,
                    level: 1,
                },
                success: function(employee) {
                    var data1 = JSON.parse(employee);
                    console.log(data1);
                    if (data1.designation_name) {
                        $(".staff_label").html(data1.designation_name);
                    }
                    if (data1.employees) {
                        $('.employee_append1')
                            .find('option')
                            .remove();
                        $(".employee_append1").prepend("<option value=''>Select</option>").val('');
                        $.each(data1.employees, function(key1, value1) {
                            var option = '<option value="' + value1.id + '">' + value1.first_name + " " + value1.last_name +
                                '</option>';
                            $('.employee_append1').append(option);
                        });
                    }
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }

    }

    function clear_form() {
        $(".sap_id").val("");
        $(".department").val("");
        $(".designation").val("");
    }

    $(document).ready(function() {
        // on form submit
        $("#designation_form1").on('submit', function() {
            // to each unchecked checkbox
            $(this).find('input[type=checkbox]:not(:checked)').prop('checked', true).val(0);
        });
        $(".sap_id").val("");
        $(".department").val("");
        $(".designation").val("");
    })


    $(document).on('change', '.priority', function() {
        $('input[name="priority[]"]').not(this).prop('checked', false);
    });

    function delete_item(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3565ed',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then(isConfirmed => {
            if (isConfirmed.value) {
                $.ajax({
                    url: "{{ url('projects') }}" + "/" + id,
                    type: 'ajax',
                    method: 'delete',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        id: id,
                    },
                    success: function(result) {
                        if (result) {
                            window.location.reload();
                        }
                    }
                });
                if (isConfirmed.value) {
                    Swal.fire(
                        'Deleted!',
                        'Project has been deleted.',
                        'success'
                    );

                }
            }
        });
    }

    function get_employee_details(emp_id) {
        var workflow_id = $(".workflow_edit").find(":selected").val();
        if (workflow_id) {
            // get_workflow_typeEdit(workflow_id);
        }

        $.ajax({
            url: "{{ route('getDetailsById') }}",
            type: 'ajax',
            method: 'post',
            data: {
                "_token": "{{ csrf_token() }}",
                emp_id: emp_id,
            },
            success: function(result) {
                var data = JSON.parse(result);
                $(".sap_id").val(data[0].sap_id);
                $(".department").val(data[0].department_name);
                $(".designation").val(data[0].designation_name);
            }
        });
    }


    function get_edit_details(project_id) {

        $.ajax({
            url: "{{ route('getProjectDetailsById') }}",
            type: 'ajax',
            method: 'post',
            data: {
                "_token": "{{ csrf_token() }}",
                project_id: project_id,
            },
            success: function(result) {
                var data = JSON.parse(result);
                console.log(data);
                $(".project_id").prop('disabled', false);
                $(".project_id").val(data.project.id);
                $(".project_name").val(data.project.project_name);
                $(".project_code").val(data.project.project_code);
                $(".start_date").val(data.project.start_date);
                $(".end_date").val(data.project.end_date);
                $(".role").val(data.project.role);
                $(".initiator_id").val(data.project.initiator_id).trigger('change')
                $(".document_type_id").val(data.project.document_type_id);
                // $(".total_levels").val(data.project);
                //get_document_workflow(data.project.document_type_id);
                $(".workflow_id").val(data.project.workflow_id).prop("selected", true);
                $(".workflow_hidden").val(data.project.workflow_id);
                set_min(data.project.start_date);
                get_workflow_typeEdit(data.project.workflow_id);
                get_employee_details(data.project.initiator_id);

                $(".multi-fields").html("");
                $.each(data.milestone, function(key, val) {
                    $(".multi-fields").append('<div class="multi-field"><div class="row"><div class="col-md-4 fv-row"><label class="required fs-6 fw-semibold mb-2">Mile Stone</label><input type="text" class="form-control" name="milestone[]" value="' + val.milestone + '"></div><div class="col-md-2 fv-row"><label class="required fs-6 fw-semibold mb-2">Start Date</label><input type="date" class="form-control form-control-solid mile_start_date" placeholder="Enter Start Date" name="mile_start_date[]" value="' + val.mile_start_date + '" required></div><div class="col-md-2 fv-row"><label class="required fs-6 fw-semibold mb-2">End Date</label><input type="date" class="form-control form-control-solid mile_end_date" placeholder="Enter End Date" name="mile_end_date[]" value="' + val.mile_end_date + '" required></div><div class="col-md-4 fv-row"><label class="required fs-6 fw-semibold mb-2">Level To Be Crossed</label><select class="form-control levels_to_be_crossed" name="level_to_be_crosssed[]"><option value="">Select</option>@for($i=1; $i<=11; $i++)<option <?php echo "'+val.levels_to_be_crossed+'=={{$i}}" ? "selected" : ''; ?> value="{{$i}}">{{$i}}</option>@endfor</select></div></div><br><button type="button" class="btn btn-sm btn-danger remove-field1" onclick="remove_more();">Remove</button><button type="button" class="btn btn-sm btn-success add-field1" onclick="append_more();">Add field</button></div>');
                });

                $.each(data.levels, function(key, val1) {
                    var input = '<input type="hidden" name=project_level_edit[] value="' + val1.project_level + '">';
                    $('.project_level_edit').append(input);

                    $('.staff' + key)
                        .find('option')
                        .remove();
                    $.each(data.employees, function(key1, value1) {

                        if (jQuery.inArray(value1.id, data.emp[key]) !== -1) {
                            var selected = "selected";
                        } else {
                            var selected = "";
                        }
                        var option = '<option ' + selected + ' value="' + value1.id + '">' + value1.first_name + " " + value1.last_name +
                            '</option>';
                        $('.staff' + key).append(option);
                    });



                    $(".project_level" + key).val(val1.project_level);
                    $(".due_date" + key).val(val1.due_date);
                    $(".priority" + val1.priority + key).attr('checked', 'checked');
                    // $(".staff" + key).val(val1.staff);

                    $(".auxillary_document" + key).attr("href", "{{ URL::to('/') }}/auxillary_document/" + val1.auxillary_document);
                    $(".main_document" + key).show();
                    $(".auxillary_document" + key).show();
                });
                $(".main_document0").empty();
                $.each(data.main_documents, function(key2, value2) {
                    if (value2.document) {
                        var file = "{{ URL::to('/') }}" + value2.document;
                        var attachment = '<a href="' + file + '" target="_blank" class="main_document" style="">Click to Open</a>&nbsp;<a href="javascript:void(0);" onclick="delete_document(' + value2.id + ');"><i style="color: red;" class="fas fa-trash"></i></a><br>';
                        $(".main_document0").append(attachment);
                    }
                });
                console.log(data.aux_documents);
                $(".auxillary_document0").empty();
                $.each(data.aux_documents, function(key3, value3) {
                    if (value3.document) {
                        var file = "{{ URL::to('/') }}" + value3.document;
                        var attachment = '<a href="' + file + '" target="_blank" class="main_document" style="">Click to Open</a>&nbsp;<a href="javascript:void(0);" onclick="delete_document(' + value3.id + ');"><i style="color: red;" class="fas fa-trash"></i></a><br>';
                        $(".auxillary_document0").append(attachment);
                    }
                });

            }
        });
    }

    function delete_document(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3565ed',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then(isConfirmed => {
            if (isConfirmed.value) {
                $.ajax({
                    url: "{{url('projects')}}" + "/" + id,
                    method: "delete",
                    data: {
                        id: id,
                        "_token": "{{ csrf_token() }}",
                    },
                    success: function(result) {
                        return false;
                        if (result.message == "Failed") {
                            Swal.fire(
                                'Deleted!',
                                'Reference Datas Are Found,deleted Failed.',
                                'error'
                            );
                        } else {
                            Swal.fire(
                                'Deleted!',
                                'Project has been deleted.',
                                'success'
                            );
                            window.location.reload();
                        }
                    }
                });

            }
        });
    }

    function append_more() {

        $('<div class="multi-field"><div class="row"><div class="col-md-4 fv-row"><label class="required fs-6 fw-semibold mb-2">Mile Stone</label><input type="text" class="form-control" name="milestone[]"></div><div class="col-md-2 fv-row"><label class="required fs-6 fw-semibold mb-2">Start Date</label><input type="date" class="form-control form-control-solid mile_start_date" placeholder="Enter Start Date" name="mile_start_date[]" required></div><div class="col-md-2 fv-row"><label class="required fs-6 fw-semibold mb-2">End Date</label><input type="date" class="form-control form-control-solid mile_end_date" placeholder="Enter End Date" name="mile_end_date[]" required></div><div class="col-md-4 fv-row"><label class="required fs-6 fw-semibold mb-2">Level To Be Crossed</label><select class="form-control levels_to_be_crossed" name="level_to_be_crosssed[]"><option value="">Select</option>@for($i=1; $i<=11; $i++)<option value="{{$i}}">{{$i}}</option>@endfor</select></div></div><br><button type="button" class="btn btn-sm btn-danger remove-field1" onclick="remove_more();">Remove</button><button type="button" class="btn btn-sm btn-success add-field1" onclick="append_more();">Add field</button></div>').appendTo(".multi-fields").find('input').val('').end()
        focus();
    }

    function remove_more() {
        $(".multi-fields").children("div[class=multi-field]:last").remove()
        // $(".multi-fields .multi-field:last-child").remove();
    }

    function deletepdf(event) {

        var connect = $(event).prev().attr('connect_id');
        $("input").filter("[connect_id='" + connect + "']").remove();
        $("iframe , img").filter("[connect_id='" + connect + "']").parent().remove();

    }





    function pdfPreview(file) {

        var pdfFile = file.files[0];
        var uniqueNumber = "in-if" + Date.now() + Math.random();
        file.setAttribute('connect_id', uniqueNumber);

        if (pdfFile["name"].endsWith(".pdf")) {
            var objectURL = URL.createObjectURL(pdfFile);
            var FileParent = $(file).parent();
            $(FileParent).find(".pdf-view").append('<div class="pdf" onclick="event.preventDefault()" ><iframe src="' + objectURL + '"  class="pdf-iframe " connect_id="' + uniqueNumber + '" scrolling="no"></iframe><button class="btn btn-danger btn-sm pdf_delete_btn  " onclick="deletepdf(this)">Delete</button></div>');
            $(FileParent).append('<input type="file" name="' + $(file).attr("name") + '" id="' + uniqueNumber + '" accept=".csv,.pdf, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" class="form-control border-0" onchange="pdfPreview(this)" style="display:none;">');
            $(FileParent).find(".pdf-view").attr("for", uniqueNumber);
        } else {
            var objectURL = " https://download.logo.wine/logo/Microsoft_Excel/Microsoft_Excel-Logo.wine.png";
            var FileParent = $(file).parent();
            $(FileParent).find(".pdf-view").append('<div class="pdf" onclick="event.preventDefault()" ><img src="' + objectURL + '"  class="pdf-iframe " connect_id="' + uniqueNumber + '" scrolling="no"></img><button class="btn btn-danger btn-sm pdf_delete_btn  " onclick="deletepdf(this)">Delete</button></div>');
            $(FileParent).append('<input type="file" name="' + $(file).attr("name") + '" id="' + uniqueNumber + '" accept=".csv,.pdf, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" class="form-control border-0" onchange="pdfPreview(this)" style="display:none;">');
            $(FileParent).find(".pdf-view").attr("for", uniqueNumber);
        }



    }
</script>
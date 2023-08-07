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
        height: 745px;
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
        height: 770px;
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
        box-shadow: 0 0 0 1px yellow;
        appearance: none;
        border-radius: 50%;
        width: 12px;
        height: 12px;
        background-color: #fff;
        transition: all ease-in 0.2s;

    }

    #low:checked {
        background-color: yellow;
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
        box-shadow: 0 0 0 1px green;
        appearance: none;
        border-radius: 50%;
        width: 12px;
        height: 12px;
        background-color: #fff;
        transition: all ease-in 0.2s;

    }

    #high:checked {
        background-color: green;
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
                        Document Listing</h1>
                    <!--end::Title-->
                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">
                            <a href="#" class="text-muted text-hover-primary">Document Listing</a>
                        </li>
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

                    <!--end::Card header-->
                    <div class="card-body">
                        <form method="post">
                            @csrf
                            <!--begin::Row-->
                            <div class="row g-8">


                                <div class="col-md-3">
                                    <label class="fs-6 form-label fw-bold text-dark "> WorkFlow Code/Name </label>
                                    <!--begin::Select-->
                                    <select class="form-select form-select-solid workflowFilter" name="workflow_code_name" data-kt-select2="true" data-placeholder="WorkFlow Code/Name" data-allow-clear="true" id="workflow">
                                        <option></option>
                                        @foreach ($workflow as $wf)
                                        <option value="{{ $wf['id'] }}">
                                            {{ $wf['workflow_name'] }}({{ $wf['workflow_code'] }})
                                        </option>
                                        @endforeach
                                    </select>
                                    <!--end::Select-->
                                </div>
                                <!--begin::Col-->
                                <div class="col-md-3">
                                    <label class="fs-6 form-label fw-bold text-dark ">Project Code / Name </label>
                                    <select class="form-select form-select-solid projectFilter" name="project_code_name" data-kt-select2="true" data-placeholder="Project Code / Name" data-allow-clear="true" id="projectCode">
                                        <option></option>
                                        @foreach ($projects as $project)
                                        <option value="{{ $project['id'] }}">
                                            {{ $project['project_name'] }}( {{ $project['project_code'] }})
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <!--begin::Col-->
                                <div class="col-md-3">
                                    <label class="fs-6 form-label fw-bold text-dark "> Ticket No. </label>
                                    <select class="form-select form-select-solid filterDeptAndDes doclistFilter ticket_no" name="ticket_no" data-kt-select2="true" data-placeholder="Ticket No" data-allow-clear="true" id="ticketno">
                                        <option></option>
                                        @foreach ($projects as $project)
                                        <option name="ticket_no" value="{{ $project['id'] }}">
                                            {{ $project['ticket_no'] }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <!--end::Col-->

                                <div class="col-lg-3">
                                    <label class="fs-6 form-label fw-bold text-dark"> Department </label>
                                    <!--begin::Select-->
                                    <select class="form-select form-select-solid filterDeptAndDes doclistFilter" name="department" data-kt-select2="true" data-placeholder="Department" data-allow-clear="true" id="deptId">
                                        <option></option>
                                        @foreach ($departments as $dept)
                                        <option name="department" value="{{ $dept['id'] }}">{{ $dept['name'] }}
                                        </option>
                                        @endforeach
                                    </select>
                                    <!--end::Select-->
                                </div>
                                <div class="col-lg-3">
                                    <label class="fs-6 form-label fw-bold text-dark"> Designation </label>
                                    <!--begin::Select-->
                                    <select class="form-select form-select-solid filterDeptAndDes doclistFilter" name="designation" data-kt-select2="true" data-placeholder="Designation" name="designation" data-allow-clear="true" id="desgId">
                                        <option></option>
                                        @foreach ($designation as $des)
                                        <option value="{{ $des['id'] }}">{{ $des['name'] }}
                                        </option>
                                        @endforeach
                                    </select>
                                    <!--end::Select-->
                                </div>

                                <div class="col-lg-2">
                                    <label class="fs-6 form-label fw-bold text-dark"> Users </label>
                                    <!--begin::Select-->
                                    <select class="form-select form-select-solid filterDeptAndDes doclistFilter" name="users" data-kt-select2="true" data-placeholder="Users" data-allow-clear="true" id="users">
                                        <option></option>
                                        @foreach ($employee as $emp)
                                        <option value="<?php echo $emp['id']; ?>"><?php echo $emp['first_name'] . ' ' . $emp['last_name']; ?></option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-2">
                                    <label class="fs-6 form-label fw-bold text-dark">Start Date</label>
                                    <input type="date" class="form-control dateWiseFilter start_date" id="startDate" name="start_date" placeholder="Enter Start Date">
                                </div>
                                <div class="col-sm-2">
                                    <label class="fs-6 form-label fw-bold text-dark">End Date</label>
                                    <input type="date" class="form-control dateWiseFilter to_date" id="endDate" name="end_date" placeholder="Enter End Date">
                                </div>
                                <div class="w-auto SearchFilter">
                                    <label class="fs-6 fw-semibold mb-2 d-block">&nbsp;</label>
                                    <span class="btn btn-success ">Search</span>
                                </div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <div class="col-md-1">
                                    <label class="fs-6 fw-semibold mb-2">&nbsp;</label>
                                    <span class="btn btn-warning " onclick="reset()">Reset</span>
                                </div>

                        </form>


                        <hr>
                        <table class="table align-middle table-row-bordered fs-6 gy-5" id="service_table">
                            <!--begin::Table head-->
                            <thead>
                                <!--begin::Table row-->
                                <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">

                                    <th class="min-w-125px">Ticket No</th>
                                    <th class="min-w-125px">Work Flow Name & Code </th>
                                    <th class="min-w-125px">Project Name & Code</th>

                                    <th class="min-w-125px">Initiator</th>
                                    <th class="min-w-125px">Department</th>
                                    <th class="">Action</th>
                                </tr>
                                <!--end::Table row-->
                            </thead>
                            <!--end::Table head-->
                            <!--begin::Table body-->
                            <tbody class="text-gray-600 fw-semibold" id="service_table_tbody">
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
                                    <td>{{ $WorkFlow->workflow_name . ' & ' . $WorkFlow->workflow_code }}</td>
                                    <td>{{ $d->project_name . '&' . $d->project_code }}</td>

                                    <td>{{ $initiator->first_name .' ' . $initiator->middle_name .' ' . $initiator->last_name }}</td>
                                    <td>{{ $department->name }}</td>
                                    <td>
                                        <span>

                                            <div style="display:inline;cursor: pointer;" id="{{ $d->id }}" class="viewDocument" title="View Document"><i class="fa-solid fa-eye" style="color:blue"></i></div>

                                            @if (auth()->user()->is_super_admin == 1 ||
                                            auth()->user()->can('document-listing-edit') ||
                                            $d['initiatorStatus'] == 'yes' ||
                                            $d['approverStatus'] == 'yes' ||
                                            Session('authorityType') == 1)
                                            &nbsp; <div style="display:inline;cursor: pointer;" id="{{ $d->id }}" class="editDocument" title="Edit Document"><i class="fa-solid fa-pen" style="color:blue"></i></div>
                                        </span>
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
@endsection
<script data-require="jquery@*" data-semver="3.0.0" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.js">
</script>
<script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

<script>
    $(document).ready(function() {
        var isSuperAdmin = "{{ auth()->user()->is_super_admin }}";
        var isAuthorityEdit = "{{ auth()->user()->can('document-listing-edit') }}";
        var isHigherAuthorityPerson = "{{ Session('authorityType') }}";
        console.log("isSuperAdmin" + isSuperAdmin);
        console.log("isAuthorityEdit" + isAuthorityEdit);
        $('.modal').each(function() {
            $(this).on('hidden.bs.modal', function() {
                window.location.reload();
            });
        });
        $('.dateWiseFilter').on('change', function() {
            $('.filterDeptAndDes').val('').trigger('change');
            if ($('.workflowFilter').val()) {
                $('.workflowFilter').val('').trigger('change');
            }
            if ($('.projectFilter').val()) {
                $('.projectFilter').val('').trigger('change');
            }

        });
        // $('.doclistFilter').on('change', function() {
        //     $("input[type=date]").val("");
        //     documnetFilter();
        // });
        $('.workflowFilter').on('change', function() {
            console.log("well");
            var table = $('#service_table').DataTable();
            $('.filterDeptAndDes').val('').trigger('change');
            if ($('.projectFilter').val()) {
                $('.projectFilter').val('').trigger('change');
            }
            $('.start_date').val('');
            $('.to_date').val('');
            $.ajax({
                url: "{{ route('getProjectByWorkflow') }}",
                type: 'ajax',
                method: 'post',
                data: {
                    "_token": "{{ csrf_token() }}",
                    workflow: $('#workflow').val(),
                },
                success: function(data) {
                    table.clear().draw();
                    var projectFilter = $('.projectFilter');
                    projectFilter.empty();
                    projectFilter.append('<option value="">Project/No</option>');
                    $.each(data.datas, function(key, val) {


                        var ticketNo = val.ticketNo;
                        var deptName = val.department;
                        var initiator = val.initiaterName;
                        var projectCodeandName = val.projectName;
                        var wfCodeandwfName = val.workflowName;

                        var projectId = val.projectId;


                        var act = '<span>';
                        act += '<div style = "display:inline" id="' + projectId +
                            '" class="viewDocument" title="View Document"><i class="fa-solid fa-eye" style="color:blue"></i></div>';
                        if (isSuperAdmin || isAuthorityEdit) {
                            act += '&nbsp; <div style = "display:inline" id="' + projectId +
                                '" class="editDocument"  title="Edit Document"><i class="fa-solid fa-pen"  style="color:blue"></i></div>';
                        }
                        act += '</span>';
                        table.row.add([ticketNo, wfCodeandwfName, projectCodeandName, initiator, deptName, act]).draw();


                        projectFilter.append('<option value="' + projectId + '">' + projectCodeandName + '</option>');
                    });
                    projectFilter.select2();
                    //$('.doclistFilter option:selected').prop("selected", false);
                },
                error: function() {
                    $("#otp_error").text("Update Error");
                }
            });

        });
        $(document).on('change click', '.to_date', function() {
            console.log("To Date");
            var startDate = $('.start_date').val().trim();
            var endDate = $('.to_date').val().trim();

            console.log(startDate);
            console.log(endDate);
            if (startDate && endDate) {
                if (startDate > endDate) {
                    console.log("If part 1 start Date");
                    Swal.fire(
                        'Warning!',
                        'End date should be Lessthen than Start date.',
                        'error'
                    );

                    $('.to_date').val('');
                }
            }
        });
        $(document).on('change click', '.start_date', function() {
            console.log("Start Date");
            var startDate = $('.start_date').val().trim();
            var endDate = $('.to_date').val().trim();

            console.log(startDate);
            console.log(endDate);

            if (startDate && endDate) {
                console.log("If part 1 start Date");
                if (startDate > endDate) {
                    console.log("If part 2 start Date");
                    Swal.fire(
                        'Warning!',
                        'End date should be greater than End date.',
                        'error'
                    );

                    $('.start_date').val('');
                    $('.to_date').val('');

                }
            }
        });
        $('.projectFilter').on('change', function() {
            $('.start_date').val('');
            $('.to_date').val('');
            var table = $('#service_table').DataTable();
            $('.filterDeptAndDes').val('').trigger('change');
            console.log("well one");
            $.ajax({
                url: "{{ route('getProjectById') }}",
                type: 'ajax',
                method: 'post',
                data: {
                    "_token": "{{ csrf_token() }}",
                    projectId: $('.projectFilter').val(),
                },
                success: function(data) {
                    table.clear().draw();

                    $.each(data.datas, function(key, val) {


                        var ticketNo = val.ticketNo;
                        var deptName = val.department;
                        var initiator = val.initiaterName;
                        var projectCodeandName = val.projectName;
                        var wfCodeandwfName = val.workflowName;

                        var projectId = val.projectId;


                        var act = '<span>';
                        act += '<div style = "display:inline" id="' + projectId +
                            '" class="viewDocument" title="View Document"><i class="fa-solid fa-eye" style="color:blue"></i></div>';
                        if (isSuperAdmin || isAuthorityEdit) {
                            act += '&nbsp; <div style = "display:inline" id="' + projectId +
                                '" class="editDocument"  title="Edit Document"><i class="fa-solid fa-pen"  style="color:blue"></i></div>';
                        }
                        act += '</span>';
                        table.row.add([ticketNo, wfCodeandwfName, projectCodeandName, initiator, deptName, act]).draw();



                    });

                    //$('.doclistFilter option:selected').prop("selected", false);
                },
                error: function() {
                    $("#otp_error").text("Update Error");
                }
            });
        });
        $('.SearchFilter').on('click', function() {
            var ticketNo = $('#ticketno').val();
            var ticketValue = (ticketNo === 'Ticket No') ? '' : ticketNo;
            var projectCode = $('#select2-projectCode-container').text();
            var projectValue = (projectCode === 'Project Code / Name') ? '' : projectCode;
            var workflow = $('#select2-workflow-container').text();
            var workflowValue = (workflow === 'WorkFlow Code/Name') ? '' : workflow;
            var department = $('#select2-deptId-container').text();
            var deptValue = (department === 'Department') ? '' : department;
            var designation = $('#select2-desgId-container').text();
            var desgValue = (designation === 'Designation') ? '' : designation;
            var user = $('#select2-users-container').text();
            var UserValue = (user === 'Users') ? '' : user;
            var startdate = $('#startDate').val();
            var enddate = $('#endDate').val();
            if (startdate && enddate) {
                $('.doclistFilter').val("").trigger('change');
                documnetFilter();
            }
            // if (ticketValue || projectValue || workflowValue || deptValue || desgValue || UserValue) {
            //     $("input[type=date]").val("");
            //     documnetFilter();
            // } else {
            //     console.log('failed');
            // }
            else {
                documnetFilter();
            }
        });

        function documnetFilter() {
            var table = $('#service_table').DataTable();
            var ticketNo = $('#ticketno').val();
            console.log(ticketNo);

            var projectCode = "";
            var workflow = "";
            var user = $('#users').val();
            var deptId = $('#deptId').val();
            var desgId = $('#desgId').val();
            var startdate = $('#startDate').val();
            var enddate = $('#endDate').val();
            $.ajax({
                url: "{{ route('docListingSearch') }}",
                type: 'ajax',
                method: 'post',
                data: {
                    "_token": "{{ csrf_token() }}",
                    ticket_no: ticketNo,
                    project_code_name: projectCode,
                    workflow_code_name: workflow,
                    users: user,
                    start_date: startdate,
                    end_date: enddate,
                    department: deptId,
                    designation: desgId,
                },
                success: function(data) {
                    table.clear().draw();
                    $.each(data, function(key, val) {
                        var ticketNo = val.ticket_no;
                        var deptName = val.deptName;
                        var initiator = val.first_name;
                        var projectCode = val.project_code;
                        var projectName = val.project_name;
                        var wfCode = val.workflow_code;
                        var wfName = val.workflow_name;
                        var projectId = val.projectId;
                        var isInitiator = (val.initiatorStatus == "yes") ? 1 : 0;
                        var isApprover = (val.approverStatus == "yes") ? 1 : 0;
                        console.log("isInitiator" + isInitiator);
                        console.log("isApprover" + isApprover);

                        var act = '<span>';
                        act += '<div style = "display:inline" id="' + projectId +
                            '" class="viewDocument" title="View Document"><i class="fa-solid fa-eye" style="color:blue"></i></div>';
                        if (isSuperAdmin || isAuthorityEdit || isInitiator || isApprover ||
                            isHigherAuthorityPerson == 1) {
                            act += '&nbsp; <div style = "display:inline" id="' + projectId +
                                '" class="editDocument"  title="Edit Document"><i class="fa-solid fa-pen"  style="color:blue"></i></div>';
                        }
                        act += '</span>';
                        table.row.add([ticketNo, wfCode + wfName, projectCode + projectName,
                            initiator, deptName, act
                        ]).draw();
                    });
                    //$('.doclistFilter option:selected').prop("selected", false);
                },
                error: function() {
                    $("#otp_error").text("Update Error");
                }
            });
        }
    });
    $(document).on('change click', '.filterDeptAndDes', function() {
        console.log("well");
        $('.filterDeptAndDes').not($(this)).val('').trigger('change');
        if ($('.workflowFilter').val()) {
            $('.workflowFilter').val('').trigger('change');
        }
        if ($('.projectFilter').val()) {
            $('.projectFilter').val('').trigger('change');
        }
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

    $(document).on('click', '.editDocument', function() {
        console.log("well and good");

        var id = $(this).attr('id');

        var url = "{{ route('editDocument') }}";
        var form = $('<form action="' + url + '" method="post">' +
            ' {{ csrf_field() }} <input type="hidden" name="id" value="' + id + '" />' +
            '</form>');
        $('body').append(form);
        form.submit();
    });


    function openCity(evt, cityName) {
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tablinks");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }
        document.getElementById(cityName).style.display = "block";
        evt.currentTarget.className += " active";
    }
    $(function() {

        for (i = 0; i <= 10; i++) {
            $(".main_document" + i).hide();
            $(".auxillary_document" + i).hide();
        }
    });


    $(function() {
        $('.multi-field-wrapper').each(function() {
            var $wrapper = $('.multi-fields', this);

            $(".add-field", $(this)).click(function(e) {
                var length = $(".multi-field").length;
                if (length <= 11) {
                    $('.multi-field:first-child', $wrapper).clone(true).appendTo($wrapper).find(
                        'input').val('').focus();
                }
            });


            $('.multi-field .remove-field', $wrapper).click(function() {
                if ($('.multi-field', $wrapper).length > 1)
                    $(this).parent('.multi-field').remove();
            });
        });
    });


    function get_document_workflow(document_type_id) {
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
                $(".workflow_edit").prepend("<option value=''>Select</option>").val('');
                $.each(data, function(key, value) {
                    var option = '<option value="' + value.id + '">' + value.workflow_name +
                        '</option>';
                    $('.workflow_edit').append(option);
                });
            },
            error: function(error) {
                console.log(error);
            }
        });
    }



    function get_workflow_type(workflow_id) {
        $.ajax({
            url: "{{ url('getWorkflowById') }}",
            type: 'ajax',
            method: 'post',
            data: {
                "_token": "{{ csrf_token() }}",
                workflow_id: workflow_id,
            },
            success: function(result) {
                var data = JSON.parse(result);
                if (data) {
                    $(".total_levels").val(data.total_levels);
                } else {
                    $(".total_levels").val(0);
                }
            }
        });
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

    $(document).ready(
        function() {

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
        var workflow_id = $(".workflow_id").find(":selected").val();
        if (workflow_id) {
            get_workflow_type(workflow_id);
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
                $(".project_id").prop('disabled', false);
                $(".project_id").val(data.project.id);
                $(".project_name").val(data.project.project_name);
                $(".project_code").val(data.project.project_code);
                $(".start_date").val(data.project.start_date);
                $(".end_date").val(data.project.end_date);
                $(".initiator_id").val(data.project.initiator_id);
                $(".document_type_id").val(data.project.document_type_id);
                // $(".total_levels").val(data.project);
                $(".workflow_id").val(data.project.workflow_id);
                get_workflow_type(data.project.workflow_id);
                get_employee_details(data.project.initiator_id);
                $(".multi-fields").html("");
                $.each(data.milestone, function(key, val) {
                    $(".multi-fields").append(
                        '<div class="multi-field"><div class="row"><div class="col-md-4 fv-row"><label class="required fs-6 fw-semibold mb-2">Mile Stone</label><input type="text" class="form-control" name="milestone[]" value="' +
                        val.milestone +
                        '"></div><div class="col-md-4 fv-row"><label class="required fs-6 fw-semibold mb-2">Planned Date</label><input type="date" class="form-control" name="planned_date[]" value="' +
                        val.planned_date +
                        '"></div><div class="col-md-4 fv-row"><label class="required fs-6 fw-semibold mb-2">Level To Be Crossed</label><select class="form-control levels_to_be_crossed" name="level_to_be_crosssed[]"><option value="">Select</option>@for ($i = 1; $i <= 11; $i++)<option <?php echo "'+val.levels_to_be_crossed+'=={{$i}}" ? 'selected' : ''; ?> value="{{ $i }}">{{ $i }}</option>@endfor</select></div></div><br><button type="button" class="btn btn-sm btn-danger remove-field1" onclick="remove_more();">Remove</button><button type="button" class="btn btn-sm btn-success add-field1" onclick="append_more();">Add field</button></div>'
                    );
                });
                $.each(data.levels, function(key, val1) {
                    $(".project_level" + key).val(val1.project_level);
                    $(".due_date" + key).val(val1.due_date);
                    $(".priority" + val1.priority + key).attr('checked', 'checked');
                    $(".staff" + key).val(val1.staff);
                    $(".hod" + key).val(val1.hod);
                    $(".main_document" + key).attr("href", "{{ URL::to('/') }}/main_document/" +
                        val1.main_document);
                    $(".auxillary_document" + key).attr("href",
                        "{{ URL::to('/') }}/auxillary_document/" + val1.auxillary_document);
                    $(".main_document" + key).show();
                    $(".auxillary_document" + key).show();
                });
            }
        });
    }

    function append_more() {
        $('<div class="multi-field"><div class="row"><div class="col-md-4 fv-row"><label class="required fs-6 fw-semibold mb-2">Mile Stone</label><input type="text" class="form-control" name="milestone[]"></div><div class="col-md-4 fv-row"><label class="required fs-6 fw-semibold mb-2">Planned Date</label><input type="date" class="form-control" name="planned_date[]"></div><div class="col-md-4 fv-row"><label class="required fs-6 fw-semibold mb-2">Level To Be Crossed</label><select class="form-control levels_to_be_crossed" name="level_to_be_crosssed[]"><option value="">Select</option>@for ($i = 1; $i <= 11; $i++)<option value="{{ $i }}">{{ $i }}</option>@endfor</select></div></div><br><button type="button" class="btn btn-sm btn-danger remove-field1" onclick="remove_more();">Remove</button><button type="button" class="btn btn-sm btn-success add-field1" onclick="append_more();">Add field</button></div>')
            .appendTo(".multi-fields").find('input').val('').end()
        focus();
    }

    function remove_more() {
        $(".multi-fields").children("div[class=multi-field]:last").remove()
        // $(".multi-fields .multi-field:last-child").remove();
    }

    function reset() {
        location.reload();
        $('.doclistFilter').val("").trigger('change');
        $("input[type=date]").val("");
    }
</script>
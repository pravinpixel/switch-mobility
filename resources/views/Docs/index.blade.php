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
                                <!--begin::Col-->
                                <div class="col-md-4">
                                    <label class="fs-6 form-label fw-bold text-dark "> Ticket No. </label>
                                    <select class="form-select form-select-solid filterDeptAndDes doclistFilter" name="ticket_no" data-kt-select2="true" data-placeholder="Ticket No" data-allow-clear="true" id="ticketno">
                                        <option></option>
                                        @foreach($projects as $project)
                                        <option name="ticket_no" value="{{$project['ticket_no']}}">{{$project['ticket_no']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <!--end::Col-->

                                <!--begin::Col-->
                                <div class="col-md-4">
                                    <label class="fs-6 form-label fw-bold text-dark ">Project Code / Name </label>
                                    <select class="form-select form-select-solid filterDeptAndDes doclistFilter" name="project_code_name" data-kt-select2="true" data-placeholder="Project Code / Name" data-allow-clear="true" id="projectCode">
                                        <option></option>
                                        @foreach($projects as $project)
                                        <option value="{{$project['project_code']}}">{{$project['project_code']}} {{$project['project_name']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="fs-6 form-label fw-bold text-dark "> WorkFlow Code/Name </label>
                                    <!--begin::Select-->
                                    <select class="form-select form-select-solid filterDeptAndDes doclistFilter" name="workflow_code_name" data-kt-select2="true" data-placeholder="WorkFlow Code/Name" data-allow-clear="true" id="workflow">
                                        <option></option>
                                        @foreach ($workflow as $wf)
                                        <option value="{{ $wf['workflow_code'] }}"> {{ $wf['workflow_code'] }} {{ $wf['workflow_name'] }}
                                        </option>
                                        @endforeach
                                    </select>
                                    <!--end::Select-->
                                </div>
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
                                    <input type="date" class="form-control" id="startDate" name="start_date" placeholder="Enter Start Date">
                                </div>
                                <div class="col-sm-2">
                                    <label class="fs-6 form-label fw-bold text-dark">End Date</label>
                                    <input type="date" class="form-control doclistFilter" id="endDate" name="end_date" placeholder="Enter End Date">
                                </div>
                                <!--end::Col-->
                                <div class="col-lg-4">

                                    <span class="svg-icon svg-icon-1 position-absolute ms-4">
                                        <svg width="20" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor" />
                                            <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="currentColor" />
                                        </svg>
                                    </span>
                                    <input type="text" id="searchInput" data-kt-user-table-filter="search" class="form-control form-control-solid ps-14" placeholder="Search" />
                                </div>

                                {{-- <div class="col-lg-4 mt-5">
                                    <label class="fs-6 form-label fw-bold text-dark "></label>
                                    <button type="submit" class="form-control btn btn-primary" data-kt-users-modal-action="submit">Search</button>
                                    </div>   

                            </div> --}}
                                <!--end::Row-->

                        </form>


                        <hr>
                        <table class="table align-middle table-row-dashed fs-6 gy-5" id="service_table">
                            <!--begin::Table head-->
                            <thead>
                                <!--begin::Table row-->
                                <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">

                                    <th class="min-w-125px">Ticket No</th>
                                    <th class="min-w-125px">Project Code & Name</th>
                                    <th class="min-w-125px">Work Flow Code & Name</th>
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
                                @foreach($order_at as $key=>$d)
                                <?php
                                $WorkFlow = $d->workflow;
                                $initiator = $d->employee;
                                $department = $initiator->department;
                                ?>
                                <tr>
                                    <!--begin::Checkbox-->

                                    <!--end::Checkbox-->
                                    <!--begin::User=-->
                                    <td class="d-flex align-items-center">
                                        {{$d->ticket_no}}
                                    </td>

                                    <td>{{$d->project_name.' '.$d->project_code}}</td>
                                    <td>{{$WorkFlow->workflow_name.' & '.$WorkFlow->workflow_code}}</td>
                                    <td>{{$initiator->first_name.' '.$initiator->last_name}}</td>
                                    <td>{{$department->name}}</td>
                                    <td><a href="{{url('viewDocListing/'.$d->id)}}" title="View Document"><i class="fa-solid fa-eye"></i>View</a>
                                    <a href="{{url('viewProject/'.$d->id)}}" title="Edit Document"><i class="fa-solid fa-pen"></i> Edit</a></td>

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



<!--begin::Modal - Create Campaign-->
<div class="modal fade" id="kt_modal_create_campaign" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-fullscreen p-9">
        <!--begin::Modal content-->
        <div class="modal-content modal-rounded">
            <!--begin::Modal header-->
            <div class="modal-header py-7 d-flex justify-content-between">
                <!--begin::Modal title-->
                <h2>Create Project</h2>
                <!--end::Modal title-->
                <!--begin::Close-->
                <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
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
            <!--begin::Modal header-->
            <!--begin::Modal body-->
            <div class="modal-body scroll-y m-5">
                <!--begin::Stepper-->
                <div class="stepper stepper-links d-flex flex-column" id="kt_modal_create_campaign_stepper">
                    <!--begin::Nav-->
                    <div class="stepper-nav justify-content-center py-2">
                        <!--begin::Step 1-->
                        <div class="stepper-item me-5 me-md-15 current" data-kt-stepper-element="nav">
                            <h3 class="stepper-title">Projects</h3>
                        </div>
                        <!--end::Step 1-->
                        <!--begin::Step 2-->
                        <div class="stepper-item me-5 me-md-15" data-kt-stepper-element="nav">
                            <h3 class="stepper-title">Mile Stone</h3>
                        </div>
                        <!--end::Step 2-->
                        <!--begin::Step 3-->
                        <div class="stepper-item me-5 me-md-15" data-kt-stepper-element="nav">
                            <h3 class="stepper-title">Levels</h3>
                        </div>
                        <!--end::Step 3-->

                    </div>
                    <!--end::Nav-->
                    <!--begin::Form-->

                    <form id="designation_form kt_modal_create_campaign_stepper_form" class="form" method="post" enctype="multipart/form-data" action="{{ url('projects') }}">
                        <!--begin::Step 1-->
                        <div class="current" data-kt-stepper-element="content">
                            <!--begin::Wrapper-->
                            <div class="w-100">
                                <!-- Projects Tab -->

                                @csrf
                                <div class="fv-row mb-7">
                                    <!--begin::Wrapper-->
                                    <div class="d-flex flex-stack">
                                        <!--begin::Label-->
                                        <div class="me-5">
                                            <!--begin::Label-->
                                            <label class="fs-6 fw-semibold">Active</label>
                                            <!--end::Label-->

                                        </div>
                                        <!--end::Label-->
                                        <!--begin::Switch-->
                                        <label class="form-check form-switch form-check-custom form-check-solid">
                                            <!--begin::Input-->
                                            <input class="form-check-input" name="is_active" type="checkbox" value="1" id="kt_modal_add_customer_billing" checked="checked" />
                                            <!--end::Input-->
                                            <!--begin::Label-->
                                            <span class="form-check-label fw-semibold text-muted" for="kt_modal_add_customer_billing">Yes</span>
                                            <!--end::Label-->
                                        </label>
                                        <!--end::Switch-->
                                    </div>
                                    <!--begin::Wrapper-->
                                </div>
                                <!--end::Input group-->

                                <div class="row g-9 mb-7">
                                    <!--begin::Col-->
                                    <div class="col-md-6 fv-row">
                                        <!--begin::Label-->
                                        <label class="required fs-6 fw-semibold mb-2">Project Name</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input type="text" class="form-control form-control-solid project_name" placeholder="Enter Project Name" name="project_name" required />
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Col-->

                                    <!--begin::Col-->
                                    <div class="col-md-6 fv-row">
                                        <!--begin::Label-->
                                        <label class="required fs-6 fw-semibold mb-2">Project Code</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input type="text" class="form-control form-control-solid project_code" placeholder="Enter Project Code" name="project_code" />
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Col-->

                                    <!--begin::Col-->
                                    <div class="col-md-6 fv-row">
                                        <!--begin::Label-->
                                        <label class="required fs-6 fw-semibold mb-2">Start Date</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input type="date" class="form-control form-control-solid start_date" placeholder="Enter Start Date" name="start_date" />
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Col-->


                                    <!--begin::Col-->
                                    <div class="col-md-6 fv-row">
                                        <!--begin::Label-->
                                        <label class="required fs-6 fw-semibold mb-2">End Date</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input type="date" class="form-control form-control-solid end_date" placeholder="Enter End Date" name="end_date" />
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Col-->

                                    <!--begin::Col-->
                                    <div class="col-md-6 fv-row">
                                        <!--begin::Label-->
                                        <label class="required fs-6 fw-semibold mb-2">Initiator</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <select class="form-control form-control-solid initiator_id" name="initiator_id" onchange="get_employee_details(this.value);">
                                            <option value="">Select</option>
                                            @foreach ($employee as $emp)
                                            <option value="<?php echo $emp['id']; ?>"><?php echo $emp['first_name'] . ' ' . $emp['last_name']; ?></option>
                                            @endforeach
                                        </select>
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Col-->

                                    <!--begin::Col-->
                                    <div class="col-md-6 fv-row">
                                        <!--begin::Label-->
                                        <label class="required fs-6 fw-semibold mb-2">SAP-id</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input type="text" class="form-control form-control-solid sap_id" placeholder="Enter SAP-id" name="sap_id" />
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Col-->

                                    <!--begin::Col-->
                                    <div class="col-md-6 fv-row">
                                        <!--begin::Label-->
                                        <label class="required fs-6 fw-semibold mb-2">Department</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input type="text" class="form-control form-control-solid department" placeholder="Enter Department" name="department_id" />
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Col-->

                                    <!--begin::Col-->
                                    <div class="col-md-6 fv-row">
                                        <!--begin::Label-->
                                        <label class="required fs-6 fw-semibold mb-2">Designation</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input type="text" class="form-control form-control-solid designation" placeholder="Enter Designation" name="designation_id" />
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Col-->



                                    <!--begin::Col-->
                                    <div class="col-md-6 fv-row">
                                        <!--begin::Label-->
                                        <label class="required fs-6 fw-semibold mb-2">Document Type</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <select class="form-control document_type_id" name="document_type_id" onchange="get_document_workflow(this.value);" required>
                                            <option value="">Select</option>
                                            @foreach ($document_type as $doc)
                                            <option value="{{ $doc['id'] }}">{{ $doc['name'] }}</option>
                                            @endforeach

                                        </select>
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Col-->

                                    <div class="col-md-6 fv-row">
                                        <!--begin::Label-->
                                        <label class="required fs-6 fw-semibold mb-2">Workflow</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <select class="form-control workflow_id" id="workflow" name="workflow_id" onchange="get_workflow_type(this.value);" required>
                                            <option value="">Select</option>
                                            @foreach ($workflow as $wf)
                                            <option value="{{ $wf['id'] }}">{{ $wf['workflow_name'] }}
                                            </option>
                                            @endforeach

                                        </select>

                                        <!--end::Input-->
                                    </div>

                                    <div class="col-md-6 fv-row">
                                        <!--begin::Label-->
                                        <label class="required fs-6 fw-semibold mb-2">Total .No of levels</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->

                                        <input type="text" class="form-control total_levels" disabled />
                                        <!--end::Input-->
                                    </div>



                                </div>

                                {{-- FORM --}}



                                <!-- End Projects Tab -->
                            </div>
                            <!--end::Wrapper-->
                        </div>
                        <!--end::Step 1-->
                        <!--begin::Step 2-->
                        <div data-kt-stepper-element="content">
                            <!--begin::Wrapper-->
                            <div class="w-100">
                                <!-- MileStones Tab -->
                                <div class="multi-field-wrapper">
                                    <div class="multi-fields">
                                        <div class="multi-field">
                                            <div class="row remove_append">
                                                <div class="col-md-4 fv-row">
                                                    <!--begin::Label-->
                                                    <label class="required fs-6 fw-semibold mb-2">Mile Stone</label>
                                                    <!--end::Label-->
                                                    <!--begin::Input-->

                                                    <input type="text" class="form-control" name="milestone[]" />
                                                    <!--end::Input-->
                                                </div>
                                                <div class="col-md-4 fv-row">
                                                    <!--begin::Label-->
                                                    <label class="required fs-6 fw-semibold mb-2">Planned Date</label>
                                                    <!--end::Label-->
                                                    <!--begin::Input-->

                                                    <input type="date" class="form-control" name="planned_date[]" />
                                                    <!--end::Input-->
                                                </div>
                                                <div class="col-md-4 fv-row">
                                                    <!--begin::Label-->
                                                    <label class="required fs-6 fw-semibold mb-2">Level To Be
                                                        Crossed</label>
                                                    <!--end::Label-->
                                                    <!--begin::Input-->
                                                    <select class="form-control levels_to_be_crossed" name="level_to_be_crosssed[]">
                                                        <option value="">Select</option>
                                                        <option value="1">1</option>
                                                        <option value="2">2</option>
                                                        <option value="3">3</option>
                                                        <option value="4">4</option>
                                                        <option value="5">5</option>
                                                        <option value="6">6</option>
                                                        <option value="7">7</option>
                                                        <option value="8">8</option>
                                                        <option value="9">9</option>
                                                        <option value="10">10</option>
                                                        <option value="11">11</option>
                                                    </select>
                                                    <!-- <input type="text" class="form-control" name="level_to_be_crosssed" /> -->
                                                    <!--end::Input-->
                                                </div>
                                            </div>
                                            <br>
                                            <button type="button" class="btn btn-sm btn-danger remove-field">Remove</button>
                                            <button type="button" class="btn btn-sm btn-success add-field">Add
                                                field</button>
                                        </div>
                                    </div>

                                </div>
                                <!-- MileStones Tab -->
                            </div>
                            <!--end::Wrapper-->
                        </div>
                        <!--end::Step 2-->
                        <!--begin::Step 3-->
                        <div data-kt-stepper-element="content">
                            <!--begin::Wrapper-->
                            <div class="w-100">
                                <!-- Levels Tab -->
                                <div class="tab">
                                    @for ($i = 0; $i <= 10; $i++) <button type="button" class="tablinks" <?php if ($i == 0) {
                                                                                                                echo "id='defaultOpen'";
                                                                                                            } else {
                                                                                                                echo "id='next'";
                                                                                                            } ?> onclick="openCity(event, 'London<?php echo $i; ?>')" id="defaultOpen">Level<?php echo $i + 1; ?></button>
                                        @endfor
                                </div>
                                @for ($i = 0; $i <= 10; $i++) <div id="London<?php echo $i; ?>" class="tabcontent">
                                    <br>
                                    <h4 style="text-align:center;">Level<?php echo $i + 1; ?></h4>
                                    <input type="hidden" class="project_level<?php echo $i; ?>" name="project_level[]" value="<?php echo $i + 1; ?>">
                                    <div class="col-md-12 fv-row">
                                        <!--begin::Label-->
                                        <label class="required fs-6 fw-semibold mb-2">Due Date</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->

                                        <input type="date" class="form-control due_date<?php echo $i; ?>" name="due_date[]" />
                                        <!--end::Input-->
                                    </div>

                                    <div class="col-md-12 fv-row">
                                        <!--begin::Label-->
                                        <label class="required fs-6 fw-semibold mb-2">Priority</label><br>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input id="critical" type="radio" class="priority1<?php echo $i; ?>" name="priority[]" value="1">&nbsp;&nbsp;
                                        <input id="low" type="radio" class="priority2<?php echo $i; ?>" name="priority[]" value="2">&nbsp;&nbsp;
                                        <input id="medium" type="radio" class="priority3<?php echo $i; ?>" name="priority[]" value="3">&nbsp;&nbsp;
                                        <input id="high" type="radio" class="priority4<?php echo $i; ?>" name="priority[]" value="4">
                                        <!--end::Input-->
                                    </div>
                                    <h4>Approvers</h4>
                                    <div class="col-md-12 fv-row">
                                        <!--begin::Label-->
                                        <label class="required fs-6 fw-semibold mb-2">Staff</label><br>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <select name="staff[]" class="form-control staff<?php echo $i; ?>">
                                            <option value="">Select</option>
                                            @foreach ($employee as $emp)
                                            <option value="<?php echo $emp['id']; ?>"><?php echo $emp['first_name'] . ' ' . $emp['last_name']; ?></option>
                                            @endforeach
                                        </select>
                                        <!--end::Input-->
                                    </div>

                                    <div class="col-md-12 fv-row">
                                        <!--begin::Label-->
                                        <label class="required fs-6 fw-semibold mb-2">Hod</label><br>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <select name="hod[]" class="form-control hod<?php echo $i; ?>">
                                            <option value="">Select</option>
                                            @foreach ($employee as $emp)
                                            <option value="<?php echo $emp['id']; ?>"><?php echo $emp['first_name'] . ' ' . $emp['last_name']; ?></option>
                                            @endforeach
                                        </select>
                                        <!--end::Input-->
                                    </div>

                                    <div class="col-md-12 fv-row">
                                        <!--begin::Label-->
                                        <label class="required fs-6 fw-semibold mb-2">Documents</label><br>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input type="file" name="main_document[]" class="form-control">
                                        <a href="javascript:void(0);" target="_blank" class="main_document<?php echo $i; ?>">Click to Open</a>
                                        <!--end::Input-->
                                    </div>

                                    <div class="col-md-12 fv-row">
                                        <!--begin::Label-->
                                        <label class="required fs-6 fw-semibold mb-2">Auxillary
                                            Documents</label><br>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input type="file" name="auxillary_document[]" class="form-control">
                                        <!--end::Input-->
                                        <a href="javascript:void(0);" target="_blank" class="auxillary_document<?php echo $i; ?>">Click to Open</a>
                                    </div>

                            </div>
                            @endfor
                            <input type="hidden" class="project_id" name="project_id" disabled>
                            <!-- Levels Tab -->
                        </div>
                        <!--end::Wrapper-->
                </div>
                <!--end::Step 3-->
                <!--begin::Actions-->
                <div class="d-flex flex-stack pt-10">
                    <!--begin::Wrapper-->
                    <div class="me-2">
                        <button type="button" class="btn btn-lg btn-light-primary me-3" data-kt-stepper-action="previous">
                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr063.svg-->
                            <span class="svg-icon svg-icon-3 me-1">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect opacity="0.5" x="6" y="11" width="13" height="2" rx="1" fill="currentColor" />
                                    <path d="M8.56569 11.4343L12.75 7.25C13.1642 6.83579 13.1642 6.16421 12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75L5.70711 11.2929C5.31658 11.6834 5.31658 12.3166 5.70711 12.7071L11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25C13.1642 17.8358 13.1642 17.1642 12.75 16.75L8.56569 12.5657C8.25327 12.2533 8.25327 11.7467 8.56569 11.4343Z" fill="currentColor" />
                                </svg>
                            </span>
                            <!--end::Svg Icon-->Back
                        </button>
                    </div>
                    <!--end::Wrapper-->
                    <!--begin::Wrapper-->
                    <div>
                        <!-- <button type="submit" class="btn btn-lg btn-primary" data-kt-stepper-action="submit"> -->
                        <button type="submit" class="btn btn-lg btn-primary">
                            <span class="indicator-label">Submit
                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr064.svg-->
                                <span class="svg-icon svg-icon-3 ms-2 me-0">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <rect opacity="0.5" x="18" y="13" width="13" height="2" rx="1" transform="rotate(-180 18 13)" fill="currentColor" />
                                        <path d="M15.4343 12.5657L11.25 16.75C10.8358 17.1642 10.8358 17.8358 11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25L18.2929 12.7071C18.6834 12.3166 18.6834 11.6834 18.2929 11.2929L12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75C10.8358 6.16421 10.8358 6.83579 11.25 7.25L15.4343 11.4343C15.7467 11.7467 15.7467 12.2533 15.4343 12.5657Z" fill="currentColor" />
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->
                            </span>
                            <span class="indicator-progress">Please wait...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                        </button>
                        <button type="button" class="btn btn-lg btn-primary" data-kt-stepper-action="next">Continue
                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr064.svg-->
                            <span class="svg-icon svg-icon-3 ms-1 me-0">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect opacity="0.5" x="18" y="13" width="13" height="2" rx="1" transform="rotate(-180 18 13)" fill="currentColor" />
                                    <path d="M15.4343 12.5657L11.25 16.75C10.8358 17.1642 10.8358 17.8358 11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25L18.2929 12.7071C18.6834 12.3166 18.6834 11.6834 18.2929 11.2929L12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75C10.8358 6.16421 10.8358 6.83579 11.25 7.25L15.4343 11.4343C15.7467 11.7467 15.7467 12.2533 15.4343 12.5657Z" fill="currentColor" />
                                </svg>
                            </span>
                            <!--end::Svg Icon-->
                        </button>
                    </div>
                    <!--end::Wrapper-->
                </div>
                <!--end::Actions-->
                </form>
                <!--end::Form-->
            </div>
            <!--end::Stepper-->
        </div>
        <!--begin::Modal body-->
    </div>
</div>
</div>
<!--end::Modal - Create Campaign-->

@endsection
<script data-require="jquery@*" data-semver="3.0.0" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.js">
</script>
<script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

<script>
    $(document).ready(function() {
        var table = $('#service_table').DataTable({
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ]
        });

        $('.modal').each(function() {
            $(this).on('hidden.bs.modal', function() {
                window.location.reload();
                //fires when evey popup close. Ex. resetModal();
            });
        });
        $('.doclistFilter').on('change', function() {

            var ticketNo = $('#ticketno').val();
            var projectCode = $('#projectCode').val();
            var workflow = $('#workflow').val();
            var user = $('#users').val();
            var deptId = $('#deptId').val();
            var desgId = $('#desgId').val();
            var startdate = $('#startDate').val();
            var enddate = $('#endDate').val();
            $.ajax({
                url: "{{ route('docListingSearch')}}",
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
                  
                        var viewurl = '{{ route("viewProject", ":id") }}';
                        viewurl = viewurl.replace(':id', projectId);

                        var action = '<a href="' + viewurl + '"><i class="fa-solid fa-eye"></i>View</a>'
                        table.row.add([ticketNo, projectCode + projectName, wfCode + wfName, initiator, deptName, action]).draw();
                    });
                    $('.doclistFilter option:selected').prop("selected", false);
                    //   $('.select2-selection__clear').remove();  
                    //   $('span.select2-selection__rendered').empty(); 
                    //   $('.doclistFilter').attr("data-placeholder", "Tricket_No");

                    //     // $('.select2-selection__rendered').prop("selected", false);

                },
                error: function() {
                    $("#otp_error").text("Update Error");
                }
            });
        });
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
        document.getElementById("defaultOpen").click(function(e) {
            e.preventDefault();
        });

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
            confirmButtonColor: '#3085d6',
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
                    $(".multi-fields").append('<div class="multi-field"><div class="row"><div class="col-md-4 fv-row"><label class="required fs-6 fw-semibold mb-2">Mile Stone</label><input type="text" class="form-control" name="milestone[]" value="' + val.milestone + '"></div><div class="col-md-4 fv-row"><label class="required fs-6 fw-semibold mb-2">Planned Date</label><input type="date" class="form-control" name="planned_date[]" value="' + val.planned_date + '"></div><div class="col-md-4 fv-row"><label class="required fs-6 fw-semibold mb-2">Level To Be Crossed</label><select class="form-control levels_to_be_crossed" name="level_to_be_crosssed[]"><option value="">Select</option>@for($i=1; $i<=11; $i++)<option <?php echo "'+val.levels_to_be_crossed+'=={{$i}}" ? "selected" : ''; ?> value="{{$i}}">{{$i}}</option>@endfor</select></div></div><br><button type="button" class="btn btn-sm btn-danger remove-field1" onclick="remove_more();">Remove</button><button type="button" class="btn btn-sm btn-success add-field1" onclick="append_more();">Add field</button></div>');
                });
                $.each(data.levels, function(key, val1) {
                    $(".project_level" + key).val(val1.project_level);
                    $(".due_date" + key).val(val1.due_date);
                    $(".priority" + val1.priority + key).attr('checked', 'checked');
                    $(".staff" + key).val(val1.staff);
                    $(".hod" + key).val(val1.hod);
                    $(".main_document" + key).attr("href", "{{ URL::to('/') }}/main_document/" + val1.main_document);
                    $(".auxillary_document" + key).attr("href", "{{ URL::to('/') }}/auxillary_document/" + val1.auxillary_document);
                    $(".main_document" + key).show();
                    $(".auxillary_document" + key).show();
                });
            }
        });
    }

    function append_more() {
        $('<div class="multi-field"><div class="row"><div class="col-md-4 fv-row"><label class="required fs-6 fw-semibold mb-2">Mile Stone</label><input type="text" class="form-control" name="milestone[]"></div><div class="col-md-4 fv-row"><label class="required fs-6 fw-semibold mb-2">Planned Date</label><input type="date" class="form-control" name="planned_date[]"></div><div class="col-md-4 fv-row"><label class="required fs-6 fw-semibold mb-2">Level To Be Crossed</label><select class="form-control levels_to_be_crossed" name="level_to_be_crosssed[]"><option value="">Select</option>@for($i=1; $i<=11; $i++)<option value="{{$i}}">{{$i}}</option>@endfor</select></div></div><br><button type="button" class="btn btn-sm btn-danger remove-field1" onclick="remove_more();">Remove</button><button type="button" class="btn btn-sm btn-success add-field1" onclick="append_more();">Add field</button></div>').appendTo(".multi-fields").find('input').val('').end()
        focus();
    }

    function remove_more() {
        $(".multi-fields").children("div[class=multi-field]:last").remove()
        // $(".multi-fields .multi-field:last-child").remove();
    }
</script>
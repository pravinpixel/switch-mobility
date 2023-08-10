@extends('layouts.app')

@section('content')
    <style>
        * {
            box-sizing: border-box
        }

        /* Style the tab */
        .tab {
            height: 400px;
            border-radius: 5px;
            overflow-y: auto;
            width: 180px;
            padding: 0 20px;
            background: white;
            box-shadow: rgba(0, 0, 0, 0.1) 0px 1px 2px 0px;
        }

        .LevelTabContent {
            height: 400px;
            border-radius: 5px;
            background: white;
            border: none !important;
            border-top: 5px solid blue !important;
            overflow-y: auto;
            margin-left: 10px;
            box-shadow: rgba(0, 0, 0, 0.1) 0px 1px 2px 0px;
        }

        form:has(.level-container.current) {
            background: transparent;
            padding-top: 0px;
            margin-top: 0px;
            overflow: hidden;

        }

        form:has(.level-container.current) .action-button {
            background: white;
            box-shadow: rgba(0, 0, 0, 0.1) 0px 1px 2px 0px;
            margin-top: 10px;
            padding: 10px !important;
            border-radius: 5px;

        }

        /* Style the buttons inside the tab */
        .tab button {
            display: block;
            background-color: inherit;
            color: black;
            padding: 5px;
            margin: 5px 0;
            width: 100%;
            border: none;
            outline: none;
            text-align: left;
            cursor: pointer;
            transition: 0.3s;
            font-size: 17px;
            text-align: center;
            border-radius: 5px;
        }


        /* Change background color of buttons on hover */
        .tab button:hover {
            background-color: rgba(105, 205, 238, 0.2);
            color: rgb(23, 182, 236);
        }

        /* Create an active/current "tab button" class */
        .tab button.active {
            background-color: rgba(105, 205, 238, 0.2);
            color: rgb(23, 182, 236);
        }

        /* Style the tab content */

        .tabcontent {
            float: left;
            padding: 0px 12px;
            /* border: 1px solid #ccc; */
            width: 100%;
            border-left: none;
            /* height: 1100px; */
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
            width: 50px;
            height: 65px;

        }

        .pdf_delete_btn {
            position: absolute !important;
            top: -5px !important;
            right: -5px !important;
            border-radius: 50%;

        }

        .pdf-view {
            border: 1px solid black;
            padding: 5px;
        }

        .pdf {
            position: relative;
            margin: 0 10px;
            width: 50px;
        }

        .pdf label {
            width: 100%;
        }

        .pdf-view .upload-text {
            margin: 0px auto;
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

        .formStyle {
            padding: 20px;
            margin: 20px;
            background: white;
            border-radius: 5px;
        }

        .error-msg {
            color: red;
        }

        .multi-field:not(:last-child) .add-field {
            display: none !important;
        }

        .multi-field:last-child .remo {
            display: none !important;
        }

        .multi-field:only-child .remove-field {
            display: none !important;
        }

        div[data-kt-stepper-element="content"] {

            overflow-x: hidden;
            overflow-y: hidden;
        }

        .level-container {
            background: transparent;
            display: flex;
            flex-wrap: wrap;

        }
        body{
            overflow-x: hidden
        }
    </style>
    <!--begin::Modal title-->
    <h2 class="text-center m-5">Create Project</h2>


    <!--begin::Modal header-->
    <!--begin::Modal body-->
    <div class="" id="kt_modal_create_campaign" tabindex="-1" aria-hidden="true">
        <!--begin::Stepper-->
        <div class="stepper stepper-links d-flex flex-column" id="kt_modal_create_campaign_stepper">
            <!--begin::Nav-->
            <div class="stepper-nav justify-content-unset py-2" style="margin:0;justify-content:unset;">
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

            <form id="designation_form kt_modal_create_campaign_stepper_form " class="form formStyle " method="post"
                enctype="multipart/form-data" action="{{ url('projects') }}">
                <!--begin::Step 1-->
                <div class="current" data-kt-stepper-element="content">
                    <!--begin::Wrapper-->
                    <div class="w-100">
                        <!-- Projects Tab -->

                        @csrf
                        <div class="fv-row mb-7" style="display:none">
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
                                    <input class="form-check-input" name="is_active" type="checkbox" value="1"
                                        id="kt_modal_add_customer_billing" checked="checked" />
                                    <!--end::Input-->
                                    <!--begin::Label-->
                                    <span class="form-check-label fw-semibold text-muted"
                                        for="kt_modal_add_customer_billing">Yes</span>
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
                                <label class="required fs-6 fw-semibold mb-2">Project Code</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" class="form-control form-control-solid project_code"
                                    placeholder="Enter Project Code" name="project_code" required />
                                <!--end::Input-->
                                <p id="projectCodeAlert" class="notifyAlert1" style="display: none;"></p>
                            </div>
                            <!--begin::Col-->
                            <div class="col-md-6 fv-row">
                                <!--begin::Label-->
                                <label class="required fs-6 fw-semibold mb-2">Initiator</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <select class="form-control form-control-solid initiator_id" name="initiator_id"
                                    onchange="get_employee_details(this.value);" required>
                                    <option value="">Select</option>
                                    @foreach ($employee as $emp)
                                        <option value="<?php echo $emp['id']; ?>"><?php echo $emp['first_name'] . ' ' . $emp['last_name'] . '(' . $emp['sap_id'] . ')'; ?></option>
                                    @endforeach
                                </select>
                                <!--end::Input-->
                            </div>
                            <!--end::Col-->
                            <!--end::Col-->
                            <!--begin::Col-->
                            <div class="col-md-6 fv-row">
                                <!--begin::Label-->
                                <label class="required fs-6 fw-semibold mb-2">Project Name</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" class="form-control form-control-solid project_name"
                                    placeholder="Enter Project Name" name="project_name" required />
                                <!--end::Input-->
                                <p id="projectNameAlert" class="notifyAlert1" style="display: none;"></p>
                            </div>
                            <div class="col-md-6 fv-row">
                                <!--begin::Label-->
                                <label class="required fs-6 fw-semibold mb-2">Department</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" class="form-control form-control-solid department"
                                    placeholder="Enter Department" name="department_id" readonly required />
                                <!--end::Input-->
                            </div>
                            <!--end::Col-->
                            <!--begin::Col-->
                            <!-- <div class="col-md-6 fv-row">
                                      
                                        <label class="required fs-6 fw-semibold mb-2">SAP-id</label>
                                      
                                        <input type="text" class="form-control form-control-solid sap_id" placeholder="Enter SAP-id" name="sap_id" readonly required />
                                      
                                    </div> -->
                            <!--end::Col-->



                            <!--begin::Col-->
                            <div class="col-md-3 fv-row">
                                <!--begin::Label-->
                                <label class="required fs-6 fw-semibold mb-2">Start Date</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="date" class="form-control form-control-solid start_date"
                                    placeholder="Enter Start Date" name="start_date" onchange="set_min(this.value);"
                                    required />
                                <!--end::Input-->
                            </div>
                            <!--end::Col-->


                            <!--begin::Col-->
                            <div class="col-md-3 fv-row">
                                <!--begin::Label-->
                                <label class="required fs-6 fw-semibold mb-2">End Date</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="date" class="form-control form-control-solid end_date"
                                    placeholder="Enter End Date" name="end_date" required  onchange="set_max(this.value);"/>
                                <!--end::Input-->
                            </div>
                            <!--end::Col-->
                            <!--begin::Col-->
                            <div class="col-md-6 fv-row">
                                <!--begin::Label-->
                                <label class="required fs-6 fw-semibold mb-2">Designation</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" class="form-control form-control-solid designation"
                                    placeholder="Enter Designation" name="designation_id" required readonly />
                                <!--end::Input-->
                            </div>
                            <!--end::Col-->
                            <!--begin::Col-->
                            <div class="col-md-6 fv-row">
                                <!--begin::Label-->
                                <label class="required fs-6 fw-semibold mb-2">Document Type</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <select class="form-control document_type_id" name="document_type_id"
                                    onchange="get_document_workflow(this.value);" required>
                                    <option value="">Select</option>
                                    @foreach ($document_type as $doc)
                                        <option value="{{ $doc['id'] }}">{{ $doc['name'] }}</option>
                                    @endforeach

                                </select>
                                <!--end::Input-->
                            </div>
                            <!--end::Col-->

                            <!--begin::Col-->

                            <!--end::Col-->

                            <div class="col-md-6 fv-row">
                                <!--begin::Label-->
                                <label class="required fs-6 fw-semibold mb-2">Workflow</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <select class="form-control workflow_edit workflow_id"
                                    onchange="get_workflow_type(this.value);" required disabled>
                                    <option value="">Select</option>
                                    @foreach ($workflow as $wf)
                                        <option value="{{ $wf['id'] }}">{{ $wf['workflow_name'] }}
                                        </option>
                                    @endforeach

                                </select>

                                <input type="hidden" class="form-control workflow_hidden" id="workflow"
                                    name="workflow_id">

                                <!--end::Input-->
                            </div>
                            <div class="col-md-6 fv-row">
                                <!--begin::Label-->
                                <label class="required fs-6 fw-semibold mb-2">Role In Project</label>
                                <!--end::Label-->
                                <!--begin::Input-->

                                <input type="text" class="form-control role" name="role" required />
                                <!--end::Input-->
                            </div>

                            <div class="col-md-6 fv-row">
                                <!--begin::Label-->
                                <label class="required fs-6 fw-semibold mb-2">Total .No of levels</label>
                                <!--end::Label-->
                                <!--begin::Input-->

                                <input type="text" class="form-control total_levels" disabled required />
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

                                            <input type="text" class="form-control" name="milestone[]"
                                                oninput="set_mile_min_max();" required />
                                            <!--end::Input-->
                                        </div>
                                        <!-- <div class="col-md-4 fv-row">
                                                
                                                    <label class="required fs-6 fw-semibold mb-2">Planned Date</label>
                                                  
                                                    <input type="date" class="form-control planned_date" name="planned_date[]" onclick="set_min_max_value();" required />
                                                  
                                                </div> -->
                                        <!--begin::Col-->
                                        <div class="col-md-2 fv-row">
                                            <!--begin::Label-->
                                            <label class="required fs-6 fw-semibold mb-2 ">Start Date</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input type="date" class="form-control form-control-solid mile_start_date"
                                                placeholder="Enter Start Date" name="mile_start_date[]" required onchange="mileStone_min_date(this)" />
                                            <!--end::Input-->
                                        </div>
                                        <!--end::Col-->


                                        <!--begin::Col-->
                                        <div class="col-md-2 fv-row">
                                            <!--begin::Label-->
                                            <label class="required fs-6 fw-semibold mb-2">End Date</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input type="date" class="form-control form-control-solid mile_end_date"
                                                placeholder="Enter End Date" name="mile_end_date[]" required />
                                            <!--end::Input-->
                                        </div>
                                        <!--end::Col-->
                                        <div class="col-md-4 fv-row">
                                            <!--begin::Label-->
                                            <label class="required fs-6 fw-semibold mb-2">Level To Be Crossed</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <select class="form-control levels_to_be_crossed"
                                                name="level_to_be_crosssed[]" required>
                                                <option value="">Select</option>

                                            </select>
                                            <!-- <input type="text" class="form-control" name="level_to_be_crosssed" /> -->
                                            <!--end::Input-->
                                        </div>
                                    </div>
                                    <br>
                                    <button type="button" class="btn btn-sm btn-icon btn-light-danger remove-field">
                                        <span class="svg-icon svg-icon-1"> <svg width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <rect opacity="0.5" x="7.05025" y="15.5356" width="12"
                                                    height="2" rx="1" transform="rotate(-45 7.05025 15.5356)"
                                                    fill="currentColor"></rect>
                                                <rect x="8.46447" y="7.05029" width="12" height="2"
                                                    rx="1" transform="rotate(45 8.46447 7.05029)"
                                                    fill="currentColor"></rect>
                                            </svg> </span>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-icon btn-light-success add-field">
                                        <span class="svg-icon svg-icon-1">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <rect opacity="0.5" x="11.364" y="20.364" width="16"
                                                    height="2" rx="1" transform="rotate(-90 11.364 20.364)"
                                                    fill="currentColor"></rect>
                                                <rect x="4.36396" y="11.364" width="16" height="2"
                                                    rx="1" fill="currentColor"></rect>
                                            </svg></span></button>
                                </div>
                            </div>

                        </div>
                        <!-- MileStones Tab -->
                    </div>
                    <!--end::Wrapper-->
                </div>
                <!--end::Step 2-->
                <!--begin::Step 3-->
                <div data-kt-stepper-element="content" class="level-container">
                    <!--begin::Wrapper-->
                    <div class="row" style="width: 100%;">
                        <div class="col-md-6 fv-row">
                            <label class="fs-6 fw-semibold mb-2 required">Main Document </label><br>
                            <div class="col-md-12 p-3 pdf_container input-group">
                                <label class="row col-12 m-2 pdf-view row " for="pdf1">
                                    <div class="upload-text"><i class="fa fa-cloud-upload"></i><span>Drag &amp; Drop files
                                            here or click to browse</span></div>
                                </label> <input type="file" name="main_document[]" id="pdf1"
                                    class="form-control border-0" onchange="pdfPreview(this)" style="display:none;"
                                    accept=".csv,.pdf,.xlsx,.xls,.doc,.docx">
                            </div>
                        </div>
                        <div class="col-md-6 fv-row">
                            <label class="fs-6 fw-semibold mb-2">Auxilary Document</label><br>
                            <div class="col-md-12 p-3 pdf_container input-group">
                                <label class="row col-12 m-2 pdf-view row " for="pdf2">
                                    <div class="upload-text"><i class="fa fa-cloud-upload"></i><span>Drag &amp; Drop files
                                            here or click to browse</span></div>
                                </label> <input type="file" name="auxillary_document[]" id="pdf2"
                                    class="form-control border-0" onchange="pdfPreview(this)" style="display:none;"
                                    accept=".csv,.pdf,.xlsx,.xls,.doc,.docx">
                            </div>
                        </div>
                    </div>
                    <!-- Levels Tab -->
                    <div class="tab ">

                    </div>
                    <div class="LevelTabContent" style="width:calc(100% - 200px)">

                    </div>

                    <input type="hidden" class="project_id" name="project_id" disabled>
                    <div class="project_level_edit"></div>
                    <!-- Levels Tab -->

                    <!--end::Wrapper-->
                </div>
                <!--end::Step 3-->
                <!--begin::Actions-->
                <div class="d-flex flex-stack p-10 action-button">
                    <!--begin::Wrapper-->
                    <div class="me-2">
                        <button type="button" class="btn btn-lg btn-light-primary me-3"
                            data-kt-stepper-action="previous">
                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr063.svg-->
                            <span class="svg-icon svg-icon-3 me-1">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <rect opacity="0.5" x="6" y="11" width="13" height="2"
                                        rx="1" fill="currentColor" />
                                    <path
                                        d="M8.56569 11.4343L12.75 7.25C13.1642 6.83579 13.1642 6.16421 12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75L5.70711 11.2929C5.31658 11.6834 5.31658 12.3166 5.70711 12.7071L11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25C13.1642 17.8358 13.1642 17.1642 12.75 16.75L8.56569 12.5657C8.25327 12.2533 8.25327 11.7467 8.56569 11.4343Z"
                                        fill="currentColor" />
                                </svg>
                            </span>
                            <!--end::Svg Icon-->Back
                        </button>
                    </div>
                    <!--end::Wrapper-->
                    <!--begin::Wrapper-->
                    <div>
                        <!-- <button type="submit" class="btn btn-lg switchPrimaryBtn " data-kt-stepper-action="submit"> -->
                        <button type="button" class="btn btn-lg switchPrimaryBtn  nextlevel"
                            data-kt-stepper-action="submit" onclick="nextLevel(this)">
                            <span class="indicator-label  ">Next
                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr064.svg-->

                                <!--end::Svg Icon-->
                            </span>

                        </button>
                        <button type="button" class="btn btn-lg switchPrimaryBtn  btn-tab-switch"
                            data-kt-stepper-action="next" validate="need">Continue
                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr064.svg-->
                            <span class="svg-icon svg-icon-3 ms-1 me-0">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <rect opacity="0.5" x="18" y="13" width="13" height="2"
                                        rx="1" transform="rotate(-180 18 13)" fill="currentColor" />
                                    <path
                                        d="M15.4343 12.5657L11.25 16.75C10.8358 17.1642 10.8358 17.8358 11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25L18.2929 12.7071C18.6834 12.3166 18.6834 11.6834 18.2929 11.2929L12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75C10.8358 6.16421 10.8358 6.83579 11.25 7.25L15.4343 11.4343C15.7467 11.7467 15.7467 12.2533 15.4343 12.5657Z"
                                        fill="currentColor" />
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

    <script>
        function nextLevel(get) {

            var actTab = $(".tablinks.active");
            let event = actTab.next(".tablinks");
            let l = actTab.next(".tablinks").attr("l");

            let lo = "London" + l;
            if ($(".tablinks.active").is(":last-child")) {
                $(".nextlevel").html(
                    '<span class="indicator-label  ">Submit <!--begin::Svg Icon | path: icons/duotune/arrows/arr064.svg--> <!--end::Svg Icon--> </span>'
                )
            } else {
                openCity(event, lo, l);
            }
            // actTab.next(".tablinks").addClass("active");
            // actTab.removeClass("active");

        }

        function getCurrentDate() {
            var today = new Date();
            var dd = today.getDate();
            var mm = today.getMonth() + 1; //January is 0!
            var yyyy = today.getFullYear();
            if (dd < 10) {
                dd = '0' + dd;
            }
            if (mm < 10) {
                mm = '0' + mm;
            }
            var currentDate = yyyy + '-' + mm + '-' + dd;
            return currentDate;
        }



        document.getElementsByName("start_date")[0].value = getCurrentDate();
        set_min(getCurrentDate());

        function getEndDate() {
            var today = new Date();
            var futureDate = new Date(today.getTime() + (30 * 24 * 60 * 60 * 1000)); // Add 30 days to current date
            var dd = futureDate.getDate();
            var mm = futureDate.getMonth() + 1; //January is 0!
            var yyyy = futureDate.getFullYear();
            if (dd < 10) {
                dd = '0' + dd;
            }
            if (mm < 10) {
                mm = '0' + mm;
            }
            var endDate = yyyy + '-' + mm + '-' + dd;
            return endDate;
        }
        $(".end_date").val(getEndDate());
        set_max(getEndDate());
        // alert(getEndDate());

        $(document).on('change', '.end_date', function() {
            var startDate = $('.start_date').val().trim();
            var endDate = $('.end_date').val().trim();

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

                    $('.end_date').val('');

                }
            }
        });
        $(document).on('change click', '.start_date', function() {
            console.log("Start Date");
            var startDate = $('.start_date').val().trim();
            var endDate = $('.end_date').val().trim();

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
                    $('.end_date').val('');

                }
            }
        });

        $(document).on('blur', '.project_code', function() {
            console.log("$(this).val()");
            $.ajax({
                url: "{{ route('projectCodeValidation') }}",
                type: 'ajax',
                async: false,
                method: 'post',
                data: {
                    "_token": "{{ csrf_token() }}",
                    code: $('.project_code').val(),
                    id: $('.project_id').val(),
                },
                success: function(data) {
                    console.log(data);
                    var alertName = 'projectCodeAlert';
                    console.log(data.response);
                    console.log(alertName);
                    if (data.response == false) {
                        document.getElementById(alertName).style.display = "block";
                        document.getElementById(alertName).style.color = "red";
                        document.getElementById(alertName).innerHTML = 'Code Is Exists*';

                    } else {
                        document.getElementById(alertName).style.display = "none";
                    }



                },


            });

        });

        $(document).on('blur', '.project_name', function() {
            console.log("$(this).val()");
            $.ajax({
                url: "{{ route('projectNameValidation') }}",
                type: 'ajax',
                async: false,
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
                    document.getElementById(alertName).style.display = "none";
                    if (data.response == false) {


                        document.getElementById(alertName).style.display = "block";
                        document.getElementById(alertName).style.color = "red";
                        document.getElementById(alertName).innerHTML = 'Name Is Exists*';

                    }




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
                            $(inputAppend).parent().append(
                                `<p class="notifyAlert" style="display: block; color: red;">` +
                                identity + ` Is Mandatory*</p> `);
                        }

                    });
                    if ($(".notifyAlert").length == 0) {
                        if (length <= 11) {
                            $('.multi-field:first-child', $wrapper).clone(true).appendTo($wrapper)
                                .find(
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
        $(document).ready(function() {
            $(".tablinks:first-child").addClass("active");
        });
    </script>
@endsection
<script data-require="jquery@*" data-semver="3.0.0" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.js">
</script>
<script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $(".initiator_id").select2();

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

    function set_min(start_date) {
        // alert("ok");
        $('.end_date').attr('min', start_date);
        $(".mile_start_date").val("");
        $(".mile_end_date").val("");
        $(".mile_start_date").attr('min', start_date);
        $(".mile_end_date").attr('min', start_date);
    }
    function set_max(end_date) {
        // alert("ok");
        $('.start_date').attr('max', end_date);
        $(".mile_end_date").val("");
        $(".mile_start_date").val("");
        $(".mile_start_date").attr('max', end_date);
        $(".mile_end_date").attr('max', end_date);
    }
function mileStone_min_date(mStartDate) {
    const closestMileEndDate = $(mStartDate).parent().next().find(".mile_end_date");
    console.log(closestMileEndDate);
    const startDateValue = $(mStartDate).val();

    closestMileEndDate.attr("min", startDateValue);
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
        $(".error-msg").remove();
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tabcontent");
        var $Blocktab = $(tabcontent).filter(function() {
            return $(this).css("display") === "block";
        });
        let nextL = $(".tablinks.active").next(".tablinks").attr("l");
        let currentL = $(".tablinks.active").attr("l");

        if ($Blocktab.length) {
            var validation = true;
            $Blocktab.find("input[required]").each(function() {
                // alert({{ auth()->user()->is_super_admin }});
                if ($(this).val().trim() === "") {
                    $(".error-msg").remove();
                    let name = $(this).prev().text();

                    if (level > currentL) {
                        $(this).after("<span class='error-msg'>" + name + " field is required.</span>");
                        validation = false;
                    }

                } else if (nextL != level && nextL < level && $("#London" + nextL).find("input[required]")
                    .val() == "") {
                    swal.fire({
                        title: "Oops!",
                        text: "Please proceed to the next level. Remember, you can't skip any levels!",
                        icon: "info",
                        confirmButtonText: "Got it",
                    });
                    validation = false;
                }
            });
            if (validation == true) {
                for (i = 0; i < tabcontent.length; i++) {
                    tabcontent[i].style.display = "none";
                }
                tablinks = document.getElementsByClassName("tablinks");
                for (i = 0; i < tablinks.length; i++) {
                    tablinks[i].className = tablinks[i].className.replace(" active", "");
                }
                document.getElementById("London" + level).style.display = "block";

                if ($(evt).hasClass("tablinks")) {
                    $(evt).addClass("active");
                } else {
                    evt.currentTarget.className += " active";
                }


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
                                    var option = '<option value="' + value.id + '">' + value
                                        .first_name + " " + value.last_name +
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
                                    var attachment = '<a href="' + file +
                                        '" target="_blank" class="main_document" style="">Click to Open</a>&nbsp;<a href="javascript:void(0);" onclick="delete_document(' +
                                        value2.id +
                                        ');"><i style="color: red;" class="fas fa-trash"></i></a><br>';
                                    $(".main_document" + n).append(attachment);
                                }
                            });
                            console.log(data.aux_documents);

                            $.each(data.aux_documents, function(key3, value3) {
                                var n = level - 1;
                                $(".auxillary_document" + n).empty();
                                if (value3.document) {
                                    var file = "{{ URL::to('/') }}" + value3.document;
                                    var attachment = '<a href="' + file +
                                        '" target="_blank" class="main_document" style="">Click to Open</a>&nbsp;<a href="javascript:void(0);" onclick="delete_document(' +
                                        value3.id +
                                        ');"><i style="color: red;" class="fas fa-trash"></i></a><br>';
                                    $(".auxillary_document" + n).append(attachment);
                                }
                            });
                        }
                    });
                }
                if ($(".tablinks.active").is(":last-child")) {
                    // Disable the button after form submission

                    $(".nextlevel").attr("onclick", "$(this).attr('type','submit')");
                    $(".nextlevel").html('<span class="indicator-label">Submit</span>');


                }
            }
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
        if (document_type_id != "") {
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
                        var option = '<option selected value="' + value.id + '">' + value
                            .workflow_name +
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
    }


    function get_workflow_type(workflow_id) {
        console.log(workflow_id);
        if (workflow_id != "") {
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
                    console.log("levelCount" + WFLevelBtn.length);
                    if (WFLevelBtn.length == 1) {
                        $('.nextLevel').attr('type', 'submit');
                        $(".nextlevel").html(
                            '<span class="indicator-label  ">Submit <!--begin::Svg Icon | path: icons/duotune/arrows/arr064.svg--> <!--end::Svg Icon--> </span>'
                        );
                    }
                    var SelectId = [];
                    if (WFLevelBtn) {

                        for (var wfl = 0; wfl < WFLevelBtn.length; wfl++) {
                            let className = "";
                            if (wfl == 0) {
                                className = "active";
                            }
                            console.log(WFLevelBtn[wfl].levelId);
                            console.log(WFLevelBtn[wfl].designationId);
                            var levelDesignation = WFLevelBtn[wfl].designationId;

                            var levelBtnRow = '<button type="button" class="tablinks ' + className +
                                '"  onclick="openCity(event, London' + WFLevelBtn[wfl].levelId + ',' +
                                WFLevelBtn[wfl].levelId + ')" id="defaultOpen" l="' + WFLevelBtn[wfl]
                                .levelId + '" >Level' + WFLevelBtn[wfl].levelId + '</button>';
                            $('.tab').append(levelBtnRow);
                            var contentshow = "";
                            if (wfl != 0) {
                                contentshow = "style='display:none'";
                            }


                            var levelTabContentData = '<div id="London' + WFLevelBtn[wfl].levelId +
                                '" class="tabcontent" ' + contentshow + '>';
                            levelTabContentData += '<br><h4 style="text-align:center;">Level' + WFLevelBtn[
                                wfl].levelId + '</h4>';

                            levelTabContentData += '<input type="hidden" class="project_level' + WFLevelBtn[
                                    wfl].levelId + '" name="project_level[]" value="' + WFLevelBtn[wfl]
                                .levelId + '">';

                            levelTabContentData += '<div class="col-md-12 fv-row">';
                            levelTabContentData +=
                                '<label class="{{ auth()->user()->is_super_admin != 1 ? 'required' : '' }} fs-6 fw-semibold mb-2">Due Date</label>';
                            levelTabContentData +=
                                '<input type="date" {{ auth()->user()->is_super_admin != 1 ? 'required' : '' }} class="form-control w-50 duedate due_date' +
                                WFLevelBtn[wfl].levelId +
                                '" name="due_date[]" onclick="set_min_max_value_due_date();" />';
                            levelTabContentData += '</div><br><br>';
                            levelTabContentData +=
                                '<div class="col-md-12 fv-row"><label class="required fs-6 fw-semibold mb-2">Priority</label><br>';

                            levelTabContentData +=
                                ' <input id="critical" type="checkbox" class="priority priority1' +
                                WFLevelBtn[wfl].levelId + ' getPriority' + WFLevelBtn[wfl].levelId +
                                '" name="priority[]" value="1" data-getLevel="' + WFLevelBtn[wfl].levelId +
                                '"> Important &nbsp;&nbsp;';
                            levelTabContentData +=
                                ' <input id="low" type="checkbox" class="priority priority2' + WFLevelBtn[
                                    wfl].levelId + ' getPriority' + WFLevelBtn[wfl].levelId +
                                '" name="priority[]" value="2" data-getLevel="' + WFLevelBtn[wfl].levelId +
                                '"> Medium &nbsp;&nbsp;';
                            levelTabContentData +=
                                ' <input id="medium" type="checkbox" class="priority priority3' +
                                WFLevelBtn[wfl].levelId + ' getPriority' + WFLevelBtn[wfl].levelId +
                                '" name="priority[]" value="3" data-getLevel="' + WFLevelBtn[wfl].levelId +
                                '"> Low &nbsp;&nbsp;';
                            levelTabContentData +=
                                ' <input id="high" type="checkbox" class="priority priority4' + WFLevelBtn[
                                    wfl].levelId + ' getPriority' + WFLevelBtn[wfl].levelId +
                                '" name="priority[]" value="4" checked data-getLevel="' + WFLevelBtn[wfl]
                                .levelId + '"> High';

                            levelTabContentData += '</div><br><br>';
                            levelTabContentData += '<h4>Approvers</h4>';
                            levelTabContentData += ' <div class="col-md-6 fv-row pe-none">';
                            var uniqueId = "SelectLevel" + wfl;
                            var uniqueApproverName = "approver_" + WFLevelBtn[wfl].levelId;
                            SelectId.push(uniqueId);
                            levelTabContentData += '<select name = "' + uniqueApproverName +
                                '[]" class="form-select w-100 form-select-solid" id="' + uniqueId +
                                '" data-control="select2" data-placeholder="Select an option" data-allow-clear="true" multiple="multiple">';
                            levelTabContentData += '<option></option>';
                            for (var lvldesc = 0; lvldesc < levelDesignation.length; lvldesc++) {
                                var optionId = levelDesignation[lvldesc].id;
                                var optionData = levelDesignation[lvldesc].first_name + levelDesignation[
                                        lvldesc].last_name + "(" + levelDesignation[lvldesc].sap_id + ")" +
                                    "-(" + levelDesignation[lvldesc].designation_name + ")";

                                // levelTabContentData += '<br><br><h4>' + levelDesignation[lvldesc].desName + '</h4>';
                                // var uniqueId = "SelectLevel" + wfl + lvldesc;
                                // var uniqueApproverName = "approver_" + WFLevelBtn[wfl].levelId + "_" + lvldesc;
                                // console.log("uniqueApproverName >" + uniqueApproverName);
                                // SelectId.push(uniqueId);
                                // levelTabContentData += '<select name = "' + uniqueApproverName + '[]" class="form-select w-50 form-select-solid" id="' + uniqueId + '" data-control="select2" data-placeholder="Select an option" data-allow-clear="true" multiple="multiple">';
                                // levelTabContentData += '<option></option>';
                                //  for (var lvlApvrs = 0; lvlApvrs < levelApprovers.length; lvlApvrs++) {

                                levelTabContentData += '<option value="' + optionId + '" selected>' +
                                    optionData + '</option>';

                                //}
                                //levelTabContentData += '</select>';

                            }
                            levelTabContentData += '</select>';
                            levelTabContentData += '</div><br><br>';

                            // levelTabContentData += '<div class="col-md-12 fv-row">';
                            // levelTabContentData += '<label class="fs-6 fw-semibold mb-2">Documents</label><br>';
                            // levelTabContentData += ' <div class="col-md-12 p-3 pdf_container input-group">  <label class="row col-12 m-2 pdf-view row " for="pdf' + WFLevelBtn[wfl].levelId + '"> <div class="upload-text"><i class="fa fa-cloud-upload"></i><span>Drag &amp; Drop files here or click to browse</span></div> </label> <input type="file" name="main_document' + WFLevelBtn[wfl].levelId + '[]" id="pdf' + WFLevelBtn[wfl].levelId + '" class="form-control border-0" onchange="pdfPreview(this)" style="display:none;" accept=".csv,.pdf,.xlsx,.xls,.doc,.docx"> </div>';
                            // levelTabContentData += '</div';

                            // levelTabContentData += '<br><br><div class="col-md-12 fv-row">';
                            // levelTabContentData += '<label class="fs-6 fw-semibold mb-2">Auxillary Documents</label><br>';
                            // levelTabContentData += '<div class="col-md-12 p-3 pdf_container input-group">  <label class="row col-12 m-2 pdf-view row " for="pdfa1a2' + WFLevelBtn[wfl].levelId + '"> <div class="upload-text"><i class="fa fa-cloud-upload"></i><span>Drag &amp; Drop files here or click to browse</span></div> </label> <input type="file" name="auxillary_document' + WFLevelBtn[wfl].levelId + '[]" id="pdfa1a2' + WFLevelBtn[wfl].levelId + '"class="form-control border-0" onchange="pdfPreview(this)" style="display:none;" accept=".csv,.pdf,.xlsx,.xls,.doc,.docx"> </div>';
                            // levelTabContentData += '</div';

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
                            var option = '<option selected value="' + +WFLevelBtn[i].levelId + '">Level -' +
                                +WFLevelBtn[i].levelId +
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
                                var option = '<option value="' + value1.id + '">' + value1
                                    .first_name + " " + value1.last_name +
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
                console.log("levelCount" + WFLevelBtn.length);
                var SelectId = [];
                if (WFLevelBtn) {

                    for (var wfl = 0; wfl < WFLevelBtn.length; wfl++) {

                        var levelDesignation = WFLevelBtn[wfl].designationId;

                        var masterData = WFLevelBtn[wfl].projectMasterData;
                        var projectApprovers = WFLevelBtn[wfl].projectApprovers;

                        var priority = masterData.priority;
                        var due_date = masterData.due_date;
                        console.log(projectApprovers);

                        var levelBtnRow =
                            '<button type="button" class="tablinks"  onclick="openCity(event, London' +
                            WFLevelBtn[wfl].levelId + ',' + WFLevelBtn[wfl].levelId +
                            ')" id="defaultOpen" >Level' + WFLevelBtn[wfl].levelId + '</button>';
                        $('.tab').append(levelBtnRow);
                        var contentshow = "";
                        if (wfl != 0) {
                            contentshow = "style='display:none'";
                        }

                        var levelTabContentData = '<div id="London' + WFLevelBtn[wfl].levelId +
                            '" class="tabcontent" ' + contentshow + '>';
                        levelTabContentData += '<br><h4 style="text-align:center;">Level' + WFLevelBtn[wfl]
                            .levelId + '</h4>';

                        levelTabContentData += '<input type="hidden" class="project_level' + WFLevelBtn[wfl]
                            .levelId + '" name="project_level[]" value="' + WFLevelBtn[wfl].levelId + '">';

                        levelTabContentData += '<div class="col-md-12 fv-row">';
                        levelTabContentData +=
                            '<label class=" {{ auth()->user()->is_super_admin != 1 ? 'required' : '' }} fs-6 fw-semibold mb-2">Due Date</label>';

                        levelTabContentData +=
                            '<input type="date" {{ auth()->user()->is_super_admin != 1 ? 'required' : '' }} class="form-control w-50 duedate due_date' +
                            WFLevelBtn[wfl].levelId +
                            '" name="due_date[]" onclick="set_min_max_value_due_date();" value="' +
                            due_date + '"/>';
                        levelTabContentData += '</div><br><br>';
                        levelTabContentData +=
                            '<div class="col-md-12 fv-row"><label class="required fs-6 fw-semibold mb-2">Priority</label><br>';
                        var check1 = (priority == 1) ? "checked" : "";
                        var check2 = (priority == 2) ? "checked" : "";
                        var check3 = (priority == 3) ? "checked" : "";
                        var check4 = (priority == 4) ? "checked" : "";

                        levelTabContentData +=
                            '<input id="critical" type="checkbox" class="priority priority1' + WFLevelBtn[
                                wfl].levelId + '" name="priority[]" value="1" ' + check1 +
                            '> Important &nbsp;&nbsp;';
                        levelTabContentData +=
                            ' <input id="low" type="checkbox" class="priority priority2' + WFLevelBtn[wfl]
                            .levelId + '" name="priority[]" value="2" ' + check2 + '> Medium &nbsp;&nbsp;';
                        levelTabContentData +=
                            ' <input id="medium" type="checkbox" class="priority priority3' + WFLevelBtn[
                                wfl].levelId + '" name="priority[]" value="3" ' + check3 +
                            '> Low &nbsp;&nbsp;';
                        levelTabContentData +=
                            '<input id="high" type="checkbox" class="priority priority4' + WFLevelBtn[wfl]
                            .levelId + '" name="priority[]" value="4" ' + check4 + '> HIGH';

                        levelTabContentData += '</div><br><br>';
                        levelTabContentData += '<h4>Approvers</h4>';
                        levelTabContentData += ' <div class="col-md-12 fv-row">';
                        for (var lvldesc = 0; lvldesc < levelDesignation.length; lvldesc++) {
                            var levelApprovers = levelDesignation[lvldesc].desEmployee;

                            levelTabContentData += '<br><br><h4>' + levelDesignation[lvldesc].desName +
                                '</h4>';
                            var uniqueId = "SelectLevel" + wfl + lvldesc;
                            var uniqueApproverName = "approver_" + WFLevelBtn[wfl].levelId + "_" + lvldesc;
                            console.log("uniqueApproverName >" + uniqueApproverName);
                            SelectId.push(uniqueId);
                            levelTabContentData += '<select name = "' + uniqueApproverName +
                                '[]" class="form-select w-100 form-select-solid" id="' + uniqueId +
                                '" data-control="select2" data-placeholder="Select an option" data-allow-clear="true" multiple="multiple">';
                            levelTabContentData += '<option></option>';
                            for (var lvlApvrs = 0; lvlApvrs < levelApprovers.length; lvlApvrs++) {
                                var selectedStatus = (projectApprovers.includes(levelApprovers[lvlApvrs]
                                    .id)) ? "selected" : "";
                                levelTabContentData += '<option value="' + levelApprovers[lvlApvrs].id +
                                    '" ' + selectedStatus + '>' + levelApprovers[lvlApvrs].first_name +
                                    '</option>';

                            }
                            levelTabContentData += '</select>';

                        }
                        levelTabContentData += '</div><br><br>';

                        // levelTabContentData += '<div class="col-md-12 fv-row">';
                        // levelTabContentData += '<label class="fs-6 fw-semibold mb-2">Documents</label><br>';
                        // levelTabContentData += ' <div class="col-md-12 p-3 pdf_container input-group">  <label class="row col-12 m-2 pdf-view row " for="pdf' + WFLevelBtn[wfl].levelId + '"> <div class="upload-text"><i class="fa fa-cloud-upload"></i><span>Drag &amp; Drop files here or click to browse</span></div> </label> <input type="file" name="main_document' + WFLevelBtn[wfl].levelId + '[]" id="pdf' + WFLevelBtn[wfl].levelId + '" class="form-control border-0" onchange="pdfPreview(this)" style="display:none;" accept=".csv,.pdf,.xlsx,.xls,.doc,.docx"> </div>';
                        // levelTabContentData += '</div';

                        // levelTabContentData += '<br><br><div class="col-md-12 fv-row">';
                        // levelTabContentData += '<label class="fs-6 fw-semibold mb-2">Auxillary Documents</label><br>';
                        // levelTabContentData += '<div class="col-md-12 p-3 pdf_container input-group">  <label class="row col-12 m-2 pdf-view row " for="pdfa1a2' + WFLevelBtn[wfl].levelId + '"> <div class="upload-text"><i class="fa fa-cloud-upload"></i><span>Drag &amp; Drop files here or click to browse</span></div> </label> <input type="file" name="auxillary_document' + WFLevelBtn[wfl].levelId + '[]" id="pdfa1a2' + WFLevelBtn[wfl].levelId + '"class="form-control border-0" onchange="pdfPreview(this)" style="display:none;" accept=".csv,.pdf,.xlsx,.xls,.doc,.docx"> </div>';
                        // levelTabContentData += '</div';

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
                        var option = '<option selected value="' + +WFLevelBtn[i].levelId + '">Level -' + +
                            WFLevelBtn[i].levelId +
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
                            var option = '<option value="' + value1.id + '">' + value1.first_name +
                                " " + value1.last_name +
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

    $(document).ready(
        function() {
            $('#service_table').DataTable({
                "lengthMenu": [
                    [10, 25, 50, -1],
                    [10, 25, 50, "All"]
                ]
            });

        });

    $(document).on('change', '.priority', function() {
        var levelId = $(this).attr('data-getlevel');
        //    $('input[name="priority'+levelId+'"]').not(this).prop('checked', false);
        $('.getPriority' + levelId).not(this).prop('checked', false);
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
                    $(".multi-fields").append(
                        '<div class="multi-field"><div class="row"><div class="col-md-4 fv-row"><label class="required fs-6 fw-semibold mb-2">Mile Stone</label><input type="text" class="form-control" name="milestone[]" value="' +
                        val.milestone +
                        '"></div><div class="col-md-2 fv-row"><label class="required fs-6 fw-semibold mb-2">Start Date</label><input type="date" class="form-control form-control-solid mile_start_date" placeholder="Enter Start Date" name="mile_start_date[]" value="' +
                        val.mile_start_date +
                        '" required></div><div class="col-md-2 fv-row"><label class="required fs-6 fw-semibold mb-2">End Date</label><input type="date" class="form-control form-control-solid mile_end_date" placeholder="Enter End Date" name="mile_end_date[]" value="' +
                        val.mile_end_date +
                        '" required></div><div class="col-md-4 fv-row"><label class="required fs-6 fw-semibold mb-2">Level To Be Crossed</label><select class="form-control levels_to_be_crossed" name="level_to_be_crosssed[]"><option value="">Select</option>@for ($i = 1; $i <= 11; $i++)<option <?php echo "'+val.levels_to_be_crossed+'=={{$i}}" ? 'selected' : ''; ?> value="{{ $i }}">Level -{{ $i }}</option>@endfor</select></div></div><br><button type="button" class="btn btn-sm btn-danger remove-field1" onclick="remove_more();">Remove</button><button type="button" class="btn btn-sm btn-success add-field1" onclick="append_more();"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1" transform="rotate(-90 11.364 20.364)" fill="currentColor"></rect><rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="currentColor"></rect> </svg></button></div>'
                    );
                });

                $.each(data.levels, function(key, val1) {
                    var input = '<input type="hidden" name=project_level_edit[] value="' + val1
                        .project_level + '">';
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
                        var option = '<option ' + selected + ' value="' + value1.id + '">' +
                            value1.first_name + " " + value1.last_name +
                            '</option>';
                        $('.staff' + key).append(option);
                    });



                    $(".project_level" + key).val(val1.project_level);
                    $(".due_date" + key).val(val1.due_date);
                    $(".priority" + val1.priority + key).attr('checked', 'checked');
                    // $(".staff" + key).val(val1.staff);

                    $(".auxillary_document" + key).attr("href",
                        "{{ URL::to('/') }}/auxillary_document/" + val1.auxillary_document);
                    $(".main_document" + key).show();
                    $(".auxillary_document" + key).show();
                });
                $(".main_document0").empty();
                $.each(data.main_documents, function(key2, value2) {
                    if (value2.document) {
                        var file = "{{ URL::to('/') }}" + value2.document;
                        var attachment = '<a href="' + file +
                            '" target="_blank" class="main_document" style="">Click to Open</a>&nbsp;<a href="javascript:void(0);" onclick="delete_document(' +
                            value2.id +
                            ');"><i style="color: red;" class="fas fa-trash"></i></a><br>';
                        $(".main_document0").append(attachment);
                    }
                });
                console.log(data.aux_documents);
                $(".auxillary_document0").empty();
                $.each(data.aux_documents, function(key3, value3) {
                    if (value3.document) {
                        var file = "{{ URL::to('/') }}" + value3.document;
                        var attachment = '<a href="' + file +
                            '" target="_blank" class="main_document" style="">Click to Open</a>&nbsp;<a href="javascript:void(0);" onclick="delete_document(' +
                            value3.id +
                            ');"><i style="color: red;" class="fas fa-trash"></i></a><br>';
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
                    url: "{{ route('deleteDocument') }}",
                    method: "post",
                    data: {
                        id: id,
                        "_token": "{{ csrf_token() }}",
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
                        'Document has been deleted.',
                        'success'
                    );
                }
            }
        });
    }

    function append_more() {

        $('<div class="multi-field"><div class="row"><div class="col-md-4 fv-row"><label class="required fs-6 fw-semibold mb-2">Mile Stone</label><input type="text" class="form-control" name="milestone[]"></div><div class="col-md-2 fv-row"><label class="required fs-6 fw-semibold mb-2">Start Date</label><input type="date" class="form-control form-control-solid mile_start_date" placeholder="Enter Start Date" name="mile_start_date[]" required></div><div class="col-md-2 fv-row"><label class="required fs-6 fw-semibold mb-2">End Date</label><input type="date" class="form-control form-control-solid mile_end_date" placeholder="Enter End Date" name="mile_end_date[]" required></div><div class="col-md-4 fv-row"><label class="required fs-6 fw-semibold mb-2">Level To Be Crossed</label><select class="form-control levels_to_be_crossed" name="level_to_be_crosssed[]"><option value="">Select</option>@for ($i = 1; $i <= 11; $i++)<option value="{{ $i }}">Level -{{ $i }}</option>@endfor</select></div></div><br><button type="button" class="btn btn-sm btn-danger remove-field1" onclick="remove_more();">Remove</button><button type="button" class="btn btn-sm btn-success add-field1" onclick="append_more();"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"> <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1" transform="rotate(-90 11.364 20.364)" fill="currentColor"></rect> <rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="currentColor"></rect> </svg></button></div>')
            .appendTo(".multi-fields").find('input').val('').end()
        focus();
    }

    function remove_more() {
        $(".multi-fields").children("div[class=multi-field]:last").remove()
        // $(".multi-fields .multi-field:last-child").remove();
    }

    function deletepdf(event) {

        var connect = $(event).prev().attr('connect_id');
        var connectName = $("input").filter("[connect_id='" + connect + "']").attr("name");
        if (connectName === 'main_document[]') {
            $("input").filter("[connect_id='" + connect + "']").next().prop("disabled", false);
        }

        $("input").filter("[connect_id='" + connect + "']").remove();
        $("iframe , img").filter("[connect_id='" + connect + "']").parent().remove();

    }





    function pdfPreview(file) {

        var pdfFile = file.files[0];
        var uniqueNumber = "in-if" + Date.now() + Math.random();
        file.setAttribute('connect_id', uniqueNumber);
        var disableCheck = ($(file).attr("name") == "main_document[]") ? "disabled" : "";

        if (pdfFile["name"].endsWith(".pdf")) {
            var objectURL = URL.createObjectURL(pdfFile);
            var FileParent = $(file).parent();
            $(FileParent).find(".pdf-view").append('<div class="pdf" onclick="event.preventDefault()" ><iframe src="' +
                objectURL + '"  class="pdf-iframe " connect_id="' + uniqueNumber +
                '" scrolling="no"></iframe><button class="btn btn-icon w-30px h-30px btn-danger btn-sm pdf_delete_btn  " onclick="deletepdf(this)"><span class="svg-icon svg-icon-3"> <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"> <path d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z" fill="currentColor"></path> <path opacity="0.5" d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z" fill="currentColor"></path> <path opacity="0.5" d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z" fill="currentColor"></path> </svg> </span></button></div>'
            );
            $(FileParent).append('<input type="file" name="' + $(file).attr("name") + '" id="' + uniqueNumber +
                '" accept=".csv,.pdf,.xlsx,.xls,.doc,.docx" class="form-control border-0" onchange="pdfPreview(this)" style="display:none;" ' +
                disableCheck + ' >'
            );
            $(FileParent).find(".pdf-view").attr("for", uniqueNumber);
        } else if (pdfFile["name"].endsWith(".doc") || pdfFile["name"].endsWith(".docx")) {
            var objectURL =
                " https://upload.wikimedia.org/wikipedia/commons/thumb/f/fd/Microsoft_Office_Word_%282019%E2%80%93present%29.svg/1101px-Microsoft_Office_Word_%282019%E2%80%93present%29.svg.png";
            var FileParent = $(file).parent();
            $(FileParent).find(".pdf-view").append('<div class="pdf" onclick="event.preventDefault()" ><img src="' +
                objectURL + '"  class="pdf-iframe " connect_id="' + uniqueNumber +
                '" scrolling="no"></img><button class="btn btn-danger btn-icon w-30px h-30px btn-sm pdf_delete_btn  " onclick="deletepdf(this)"><span class="svg-icon svg-icon-3"> <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"> <path d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z" fill="currentColor"></path> <path opacity="0.5" d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z" fill="currentColor"></path> <path opacity="0.5" d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z" fill="currentColor"></path> </svg> </span></button></div>'
            );
            $(FileParent).append('<input type="file" name="' + $(file).attr("name") + '" id="' + uniqueNumber +
                '" accept=".csv,.pdf,.xlsx,.xls,.doc,.docx" class="form-control border-0" onchange="pdfPreview(this)" style="display:none;" ' +
                disableCheck + '>'
            );
            $(FileParent).find(".pdf-view").attr("for", uniqueNumber);
        } else if (pdfFile["name"].endsWith(".csv") || pdfFile["name"].endsWith(".xlsx") || pdfFile["name"].endsWith(
                ".xls")) {
            var objectURL = " https://download.logo.wine/logo/Microsoft_Excel/Microsoft_Excel-Logo.wine.png";
            var FileParent = $(file).parent();
            $(FileParent).find(".pdf-view").append('<div class="pdf" onclick="event.preventDefault()" ><img src="' +
                objectURL + '"  class="pdf-iframe " connect_id="' + uniqueNumber +
                '" scrolling="no"></img><button class="btn btn-danger btn-icon w-30px h-30px btn-sm pdf_delete_btn  " onclick="deletepdf(this)"><span class="svg-icon svg-icon-3"> <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"> <path d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z" fill="currentColor"></path> <path opacity="0.5" d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z" fill="currentColor"></path> <path opacity="0.5" d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z" fill="currentColor"></path> </svg> </span></button></div>'
            );
            $(FileParent).append('<input type="file" name="' + $(file).attr("name") + '" id="' + uniqueNumber +
                '" accept=".csv,.pdf,.xlsx,.xls,.doc,.docx" class="form-control border-0" onchange="pdfPreview(this)" style="display:none;" ' +
                disableCheck + '>'
            );
            $(FileParent).find(".pdf-view").attr("for", uniqueNumber);
        }



    }

    
    

    
</script>

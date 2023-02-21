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
                    <div class="card-header border-0 pt-6">

                        <div class="card-title">

                        </div>

                        <div class="card-toolbar">
                            <!--begin::Toolbar-->
                            <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                                <!--begin::Filter-->
                                @if(auth()->user()->is_super_admin ==1 ||auth()->user()->can('project-create'))
                                <!--begin::Add user-->
                                <button type="button" onclick="clear_form();" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_create_campaign">
                                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr075.svg-->
                                    <span class="svg-icon svg-icon-2">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1" transform="rotate(-90 11.364 20.364)" fill="currentColor" />
                                            <rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="currentColor" />
                                        </svg>
                                    </span>
                                    <!--end::Svg Icon-->Add
                                </button>
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
                    <div class="card-body py-4">
                        <div class="card-title">
                            <!--begin::Search-->
                            <div class="d-flex align-items-center position-relative my-1">
                                <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                                <span class="svg-icon svg-icon-1 position-absolute ms-6">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor" />
                                        <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="currentColor" />
                                    </svg>
                                </span>
                                
                                <!--end::Svg Icon-->
                                <input type="text" id="searchInput" data-kt-user-table-filter="search" class="form-control form-control-solid w-250px ps-14" placeholder="Search" />
                              <!--begin::Actions-->
                              <div class="d-flex align-items-center gap-2 gap-lg-3" >
                                    <!--begin::Filter menu-->
                                    <div class="m-0">
                                        <!--begin::Menu toggle-->
                                        <a  href="#" style="background-color:black" class="btn btn-sm btn-flex bg-body btn-color-gray-700 btn-active-color-primary fw-bold" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                            <!--begin::Svg Icon | path: icons/duotune/general/gen031.svg-->
                                            <span class="svg-icon svg-icon-6 svg-icon-muted me-1">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M19.0759 3H4.72777C3.95892 3 3.47768 3.83148 3.86067 4.49814L8.56967 12.6949C9.17923 13.7559 9.5 14.9582 9.5 16.1819V19.5072C9.5 20.2189 10.2223 20.7028 10.8805 20.432L13.8805 19.1977C14.2553 19.0435 14.5 18.6783 14.5 18.273V13.8372C14.5 12.8089 14.8171 11.8056 15.408 10.964L19.8943 4.57465C20.3596 3.912 19.8856 3 19.0759 3Z" fill="currentColor" />
                                                </svg>
                                            </span>
                                            <!--end::Svg Icon-->Filter</a>
                                        <!--end::Menu toggle-->
                                        <!--begin::Menu 1-->
                                        <div class="menu menu-sub menu-sub-dropdown w-250px w-md-300px" data-kt-menu="true" id="kt_menu_637dc78d8451e">
                                            <!--begin::Header-->
                                            <div class="px-7 py-5">
                                                <div class="fs-5 text-dark fw-bold">Filter Options</div>
                                            </div>
                                            <!--end::Header-->
                                            <!--begin::Menu separator-->
                                            <div class="separator border-gray-200"></div>
                                            <!--end::Menu separator-->
                                            <!--begin::Form-->
                                            <div class="px-7 py-5">
                                                <!--begin::Input group-->
                                                <div class="mb-10">
                                                    <!--begin::Label-->
                                                    <label class="form-label fw-semibold">Status:</label>
                                                    <!--end::Label-->
                                                    <!--begin::Input-->
                                                    <div>
                                                        <select class="form-select form-select-solid" data-kt-select2="true" data-placeholder="Select option" data-dropdown-parent="#kt_menu_637dc78d8451e" data-allow-clear="true">
                                                            <option></option>
                                                            <option value="1">Approved</option>
                                                            <option value="2">Pending</option>
                                                            <option value="2">In Process</option>
                                                            <option value="2">Rejected</option>
                                                        </select>
                                                    </div>
                                                    <!--end::Input-->
                                                </div>
                                                <!--end::Input group-->
                                                <!--begin::Input group-->
                                                <div class="mb-10">
                                                    <!--begin::Label-->
                                                    <label class="form-label fw-semibold">Member Type:</label>
                                                    <!--end::Label-->
                                                    <!--begin::Options-->
                                                    <div class="d-flex">
                                                        <!--begin::Options-->
                                                        <label class="form-check form-check-sm form-check-custom form-check-solid me-5">
                                                            <input class="form-check-input" type="checkbox" value="1" />
                                                            <span class="form-check-label">Author</span>
                                                        </label>
                                                        <!--end::Options-->
                                                        <!--begin::Options-->
                                                        <label class="form-check form-check-sm form-check-custom form-check-solid">
                                                            <input class="form-check-input" type="checkbox" value="2" checked="checked" />
                                                            <span class="form-check-label">Customer</span>
                                                        </label>
                                                        <!--end::Options-->
                                                    </div>
                                                    <!--end::Options-->
                                                </div>
                                                <!--end::Input group-->
                                                <!--begin::Input group-->
                                                <div class="mb-10">
                                                    <!--begin::Label-->
                                                    <label class="form-label fw-semibold">Notifications:</label>
                                                    <!--end::Label-->
                                                    <!--begin::Switch-->
                                                    <div class="form-check form-switch form-switch-sm form-check-custom form-check-solid">
                                                        <input class="form-check-input" type="checkbox" value="" name="notifications" checked="checked" />
                                                        <label class="form-check-label">Enabled</label>
                                                    </div>
                                                    <!--end::Switch-->
                                                </div>
                                                <!--end::Input group-->
                                                <!--begin::Actions-->
                                                <div class="d-flex justify-content-end">
                                                    <button type="reset" class="btn btn-sm btn-light btn-active-light-primary me-2" data-kt-menu-dismiss="true">Reset</button>
                                                    <button type="submit" class="btn btn-sm btn-primary" data-kt-menu-dismiss="true">Apply</button>
                                                </div>
                                                <!--end::Actions-->
                                            </div>
                                            <!--end::Form-->
                                        </div>
                                        <!--end::Menu 1-->
                                    </div>
                                    <!--end::Filter menu-->                               
                                </div>
                                <!--end::Actions-->
                            </div>
                            
                            <!--end::Search-->
                        </div>
                        <!--begin::Table-->
                        <table class="table align-middle table-row-dashed fs-6 gy-5" id="service_table">
                            <!--begin::Table head-->
                            <thead>
                                <!--begin::Table row-->
                                <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                    <th class="min-w-125px">S.no</th>
                                    <th class="min-w-125px">Project Code</th>
                                    <th class="min-w-125px">Project Name</th>
                                    <th class="min-w-125px">Start Date</th>
                                    <th class="min-w-125px">End Date</th>
                                    <th class="min-w-125px">Project Initiator</th>
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
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $d->project_code }}</td>
                                    <td>{{ $d->project_name }}</td>
                                    <td>{{ date('d-m-Y', strtotime($d->start_date)) }}</td>
                                    <td>{{ date('d-m-Y', strtotime($d->end_date)) }}</td>
                                    <td>{{ $d->first_name }} {{ $d->last_name }}</td>
                                    <!-- <td></td>
                                    <td></td> -->
                                    <td class="text-end">
                                        <a href="#" class="btn btn-light btn-active-light-primary btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions

                                            <span class="svg-icon svg-icon-5 m-0">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="currentColor" />
                                                </svg>
                                            </span>
                                        </a>
                                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                                            @if(auth()->user()->is_super_admin ==1 ||auth()->user()->can('project-edit'))
                                            <div class="menu-item px-3">
                                                <a href="#" class="menu-link px-3" data-bs-toggle="modal" data-bs-target="#kt_modal_create_campaign" onclick="get_edit_details(<?php echo $d->project_id; ?>)">Edit</a>
                                            </div>
                                            @endif
                                            @if(auth()->user()->is_super_admin ==1 ||auth()->user()->can('project-delete'))
                                            <div class="menu-item px-3">
                                                <a href="javascript:void(0);" class="menu-link px-3" onclick="delete_item(<?php echo $d->project_id; ?>);">Delete</a>
                                            </div>
                                            @endif
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
            <div class="modal-body  m-5">
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
                        <div class="stepper-item me-5 me-md-15" data-kt-stepper-element="nav" >
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
                        <div class="current" data-kt-stepper-element="content" style=" max-height: 370px;overflow-y: scroll;">
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
                                        <label class="required fs-6 fw-semibold mb-2">Project Code</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input type="text" class="form-control form-control-solid project_code" placeholder="Enter Project Code" name="project_code" required />
                                        <!--end::Input-->
                                    </div>
                                    <!--begin::Col-->
                                    <div class="col-md-6 fv-row">
                                        <!--begin::Label-->
                                        <label class="required fs-6 fw-semibold mb-2">Initiator</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <select class="form-control form-control-solid initiator_id" name="initiator_id" onchange="get_employee_details(this.value);" required>
                                            <option value="">Select</option>
                                            @foreach ($employee as $emp)
                                            <option value="<?php echo $emp['id']; ?>"><?php echo $emp['first_name'] . ' ' . $emp['last_name'].'('.$emp['sap_id'].')'; ?></option>
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
                                        <input type="text" class="form-control form-control-solid project_name" placeholder="Enter Project Name" name="project_name" required />
                                        <!--end::Input-->
                                    </div>

                                    <!--end::Col-->
                                    <!--begin::Col-->
                                    <div class="col-md-6 fv-row">
                                        <!--begin::Label-->
                                        <label class="required fs-6 fw-semibold mb-2">SAP-id</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input type="text" class="form-control form-control-solid sap_id" placeholder="Enter SAP-id" name="sap_id" readonly  required/>
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Col-->



                                    <!--begin::Col-->
                                    <div class="col-md-3 fv-row">
                                        <!--begin::Label-->
                                        <label class="required fs-6 fw-semibold mb-2">Start Date</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input type="date" class="form-control form-control-solid start_date" placeholder="Enter Start Date" name="start_date" onchange="set_min(this.value);" required />
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Col-->


                                    <!--begin::Col-->
                                    <div class="col-md-3 fv-row">
                                        <!--begin::Label-->
                                        <label class="required fs-6 fw-semibold mb-2">End Date</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input type="date" class="form-control form-control-solid end_date" placeholder="Enter End Date" name="end_date" required />
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Col-->
                                    <!--begin::Col-->
                                    <div class="col-md-6 fv-row">
                                        <!--begin::Label-->
                                        <label class="required fs-6 fw-semibold mb-2">Department</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input type="text" class="form-control form-control-solid department" placeholder="Enter Department" name="department_id" readonly required />
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

                                    <!--begin::Col-->
                                    <div class="col-md-6 fv-row">
                                        <!--begin::Label-->
                                        <label class="required fs-6 fw-semibold mb-2">Designation</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input type="text" class="form-control form-control-solid designation" placeholder="Enter Designation" name="designation_id" required readonly />
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Col-->









                                    <div class="col-md-6 fv-row">
                                        <!--begin::Label-->
                                        <label class="required fs-6 fw-semibold mb-2">Workflow</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <select class="form-control workflow_edit workflow_id" onchange="get_workflow_type(this.value);" required disabled>
                                            <option value="">Select</option>
                                            @foreach ($workflow as $wf)
                                            <option value="{{ $wf['id'] }}">{{ $wf['workflow_name'] }}
                                            </option>
                                            @endforeach

                                        </select>

                                        <input type="hidden" class="form-control workflow_hidden" id="workflow" name="workflow_id">

                                        <!--end::Input-->
                                    </div>
                                    <div class="col-md-6 fv-row">
                                        <!--begin::Label-->
                                        <label class="required fs-6 fw-semibold mb-2">Role In Project</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->

                                        <input type="text" class="form-control role" name="role" required/>
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

                                                    <input type="text" class="form-control" name="milestone[]" oninput="set_mile_min_max();" required />
                                                    <!--end::Input-->
                                                </div>
                                                <!-- <div class="col-md-4 fv-row">
                                                
                                                    <label class="required fs-6 fw-semibold mb-2">Planned Date</label>
                                                  
                                                    <input type="date" class="form-control planned_date" name="planned_date[]" onclick="set_min_max_value();" required />
                                                  
                                                </div> -->
                                                <!--begin::Col-->
                                                <div class="col-md-2 fv-row">
                                                    <!--begin::Label-->
                                                    <label class="required fs-6 fw-semibold mb-2">Start Date</label>
                                                    <!--end::Label-->
                                                    <!--begin::Input-->
                                                    <input type="date" class="form-control form-control-solid mile_start_date" placeholder="Enter Start Date" name="mile_start_date[]" required />
                                                    <!--end::Input-->
                                                </div>
                                                <!--end::Col-->


                                                <!--begin::Col-->
                                                <div class="col-md-2 fv-row">
                                                    <!--begin::Label-->
                                                    <label class="required fs-6 fw-semibold mb-2">End Date</label>
                                                    <!--end::Label-->
                                                    <!--begin::Input-->
                                                    <input type="date" class="form-control form-control-solid mile_end_date" placeholder="Enter End Date" name="mile_end_date[]" required />
                                                    <!--end::Input-->
                                                </div>
                                                <!--end::Col-->
                                                <div class="col-md-4 fv-row">
                                                    <!--begin::Label-->
                                                    <label class="required fs-6 fw-semibold mb-2">Level To Be Crossed</label>
                                                    <!--end::Label-->
                                                    <!--begin::Input-->
                                                    <select class="form-control levels_to_be_crossed" name="level_to_be_crosssed[]" required>
                                                        <option value="">Select</option>

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
                        <div data-kt-stepper-element="content" style=" max-height: 370px;overflow-y: scroll;">
                            <!--begin::Wrapper-->
                            <div class="w-100">
                                <!-- Levels Tab -->
                                <div class="tab">
                                    @for ($i = 0; $i <= 10; $i++) <button type="button" class="tablinks" <?php if ($i == 0) {
                                                                                                                echo "id='defaultOpen'";
                                                                                                            } else {
                                                                                                                echo "id='next'";
                                                                                                            } ?> onclick="openCity(event, 'London<?php echo $i; ?>',<?php echo $i + 1; ?>)" id="defaultOpen">Level<?php echo $i + 1; ?></button>
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

                                        <input type="date" class="form-control duedate due_date<?php echo $i; ?>" name="due_date[]" onclick="set_min_max_value_due_date();" />
                                        <!--end::Input-->
                                    </div>

                                    <div class="col-md-12 fv-row">
                                        <!--begin::Label-->
                                        <label class="required fs-6 fw-semibold mb-2">Priority</label><br>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input id="critical" type="checkbox" class="priority1<?php echo $i; ?>" name="priority[]" value="1">&nbsp;&nbsp;
                                        <input id="low" type="checkbox" class="priority2<?php echo $i; ?>" name="priority[]" value="2">&nbsp;&nbsp;
                                        <input id="medium" type="checkbox" class="priority3<?php echo $i; ?>" name="priority[]" value="3">&nbsp;&nbsp;
                                        <input id="high" type="checkbox" class="priority4<?php echo $i; ?>" name="priority[]" value="4">
                                        <!--end::Input-->
                                    </div>
                                    <h4>Approvers</h4>
                                    <div class="col-md-12 fv-row">
                                        <!--begin::Label-->
                                        <label class="required fs-6 fw-semibold mb-2 staff_label">Staff</label><br>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <select  name="staff<?php echo $i; ?>[]" class="form-select mb-2 employee_append<?php echo $i + 1; ?> form-control staff<?php echo $i; ?>" data-control="select2" data-placeholder="Select an option" data-allow-clear="true" multiple="multiple">
                                            <option></option>
                                            @foreach ($employee as $emp)
                                            <option value="<?php echo $emp['id']; ?>"><?php echo $emp['first_name'] . ' ' . $emp['last_name']; ?></option>
                                            @endforeach
                                        </select>
                                     
                                        <!--end::Input-->
                                    </div>

                                    {{-- <div class="col-md-12 fv-row">
                                        <!--begin::Label-->
                                        <label class="required fs-6 fw-semibold mb-2">Hod</label><br>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <select name="hod[]" class="employee_append<?php echo $i + 1; ?> form-control hod<?php echo $i; ?>">
                                            <option value="">Select</option>
                                            @foreach ($employee as $emp)
                                            <option value="<?php echo $emp['id']; ?>"><?php echo $emp['first_name'] . ' ' . $emp['last_name']; ?></option>
                                            @endforeach
                                        </select>
                                        <!--end::Input-->
                                    </div> --}}

                                    <div class="col-md-12 fv-row">
                                        <!--begin::Label-->
                                        <label class="fs-6 fw-semibold mb-2">Documents</label><br>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input type="file" name="main_document<?php echo $i; ?>[]" class="form-control" multiple accept=".csv,.pdf, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                                        <div class="main_document<?php echo $i; ?>"></div>
                                        {{-- <a href="javascript:void(0);" target="_blank" class="main_document<?php echo $i; ?>">Click to Open</a> --}}
                                        <!--end::Input-->
                                    </div>

                                    <div class="col-md-12 fv-row">
                                        <!--begin::Label-->
                                        <label class="fs-6 fw-semibold mb-2">Auxillary
                                            Documents</label><br>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input type="file" name="auxillary_document<?php echo $i; ?>[]" class="form-control" multiple accept=".csv,.pdf, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                                        <div class="auxillary_document<?php echo $i; ?>"></div>
                                        <!--end::Input-->
                                        <!-- <a href="javascript:void(0);" target="_blank" class="auxillary_document<?php echo $i; ?>">Click to Open</a> -->
                                    </div>

                            </div>
                            @endfor
                            <input type="hidden" class="project_id" name="project_id" disabled>
                            <div class="project_level_edit"></div>
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
                        <button type="submit" class="btn btn-lg btn-primary " data-kt-stepper-action="submit">
                            <span class="indicator-label  ">Submit
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
                        <button type="button" class="btn btn-lg btn-primary btn-tab-switch" data-kt-stepper-action="next" validate="need">Continue
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

    $(document).ready(function() {
        $('.modal').each(function() {
            $(this).on('hidden.bs.modal', function() {
                window.location.reload();
                //fires when evey popup close. Ex. resetModal();
            });
        });
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
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tablinks");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }
        document.getElementById(cityName).style.display = "block";
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
        }else{
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
                    var n=level-1;
                    $(".main_document"+n).empty();
                    if(value2.document){
                        var file="{{ URL::to('/') }}"+value2.document;
                        var attachment='<a href="'+file+'" target="_blank" class="main_document" style="">Click to Open</a>&nbsp;<a href="javascript:void(0);" onclick="delete_document('+value2.id+');"><i style="color: red;" class="fas fa-trash"></i></a><br>';
                        $(".main_document"+n).append(attachment);   
                    }
                    });
                    console.log(data.aux_documents);
               
                    $.each(data.aux_documents, function(key3, value3) {
                        var n=level-1;
                        $(".auxillary_document"+n).empty();
                    if(value3.document){
                        var file="{{ URL::to('/') }}"+value3.document;
                        var attachment='<a href="'+file+'" target="_blank" class="main_document" style="">Click to Open</a>&nbsp;<a href="javascript:void(0);" onclick="delete_document('+value3.id+');"><i style="color: red;" class="fas fa-trash"></i></a><br>';
                        $(".auxillary_document"+n).append(attachment);   
                    }
                    });
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


    $(function() {
        $('.multi-field-wrapper').each(function() {
            var $wrapper = $('.multi-fields', this);

            $(".add-field", $(this)).click(function(e) {
            
                var length = $(".multi-field").length;
                var inputAppends=$(".multi-field input[required]");
                let identity;
                $(".notifyAlert").remove();

                $.each(inputAppends, function(index, inputAppend) {
                            var inputValue = inputAppend.value;
                            // Do something with the input value in each iteration, such as calling a function
                           if (inputValue=="") {
                             identity = $(inputAppend).prev().html();
                            $(inputAppend).parent().append(`<p class="notifyAlert" style="display: block; color: red;">`+identity+` Is Mandatory*</p> `);
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
                    $('.levels_to_be_crossed')
                        .find('option')
                        .remove();
                    for (var i = 1; i <= data.total_levels; i++) {
                        var option = '<option selected value="' + i + '">' + i +
                            '</option>';
                        $('.levels_to_be_crossed').append(option);
                    }


                    $(".total_levels").val(data.total_levels);
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
        var workflow_id = $(".workflow_edit").find(":selected").val();
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
                console.log(data);
                $(".project_id").prop('disabled', false);
                $(".project_id").val(data.project.id);
                $(".project_name").val(data.project.project_name);
                $(".project_code").val(data.project.project_code);
                $(".start_date").val(data.project.start_date);
                $(".end_date").val(data.project.end_date);
                $(".role").val(data.project.role);
                $(".initiator_id").val(data.project.initiator_id);
                $(".document_type_id").val(data.project.document_type_id);
                // $(".total_levels").val(data.project);
                get_document_workflow(data.project.document_type_id);
                $(".workflow_id").val(data.project.workflow_id).prop("selected", true);
                $(".workflow_hidden").val(data.project.workflow_id);
                set_min(data.project.start_date);
                get_workflow_type(data.project.workflow_id);
                get_employee_details(data.project.initiator_id);

                $(".multi-fields").html("");
                $.each(data.milestone, function(key, val) {
                    $(".multi-fields").append('<div class="multi-field"><div class="row"><div class="col-md-4 fv-row"><label class="required fs-6 fw-semibold mb-2">Mile Stone</label><input type="text" class="form-control" name="milestone[]" value="' + val.milestone + '"></div><div class="col-md-2 fv-row"><label class="required fs-6 fw-semibold mb-2">Start Date</label><input type="date" class="form-control form-control-solid mile_start_date" placeholder="Enter Start Date" name="mile_start_date[]" value="' + val.mile_start_date + '" required></div><div class="col-md-2 fv-row"><label class="required fs-6 fw-semibold mb-2">End Date</label><input type="date" class="form-control form-control-solid mile_end_date" placeholder="Enter End Date" name="mile_end_date[]" value="' + val.mile_end_date + '" required></div><div class="col-md-4 fv-row"><label class="required fs-6 fw-semibold mb-2">Level To Be Crossed</label><select class="form-control levels_to_be_crossed" name="level_to_be_crosssed[]"><option value="">Select</option>@for($i=1; $i<=11; $i++)<option <?php echo "'+val.levels_to_be_crossed+'=={{$i}}" ? "selected" : ''; ?> value="{{$i}}">{{$i}}</option>@endfor</select></div></div><br><button type="button" class="btn btn-sm btn-danger remove-field1" onclick="remove_more();">Remove</button><button type="button" class="btn btn-sm btn-success add-field1" onclick="append_more();">Add field</button></div>');
                });
                
                $.each(data.levels, function(key, val1) {
                    var input = '<input type="hidden" name=project_level_edit[] value="'+val1.project_level+'">';
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
                    if(value2.document){
                        var file="{{ URL::to('/') }}"+value2.document;
                        var attachment='<a href="'+file+'" target="_blank" class="main_document" style="">Click to Open</a>&nbsp;<a href="javascript:void(0);" onclick="delete_document('+value2.id+');"><i style="color: red;" class="fas fa-trash"></i></a><br>';
                        $(".main_document0").append(attachment);   
                    }
                    });
                    console.log(data.aux_documents);
                    $(".auxillary_document0").empty();
                    $.each(data.aux_documents, function(key3, value3) {
                    if(value3.document){
                        var file="{{ URL::to('/') }}"+value3.document;
                        var attachment='<a href="'+file+'" target="_blank" class="main_document" style="">Click to Open</a>&nbsp;<a href="javascript:void(0);" onclick="delete_document('+value3.id+');"><i style="color: red;" class="fas fa-trash"></i></a><br>';
                        $(".auxillary_document0").append(attachment);   
                    }
                    });

            }
        });
    }

    function delete_document(id){
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
                    url: "{{ route('deleteDocument') }}",
                    method:"post",
                    data:{
                        id:id,
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
       
        $('<div class="multi-field"><div class="row"><div class="col-md-4 fv-row"><label class="required fs-6 fw-semibold mb-2">Mile Stone</label><input type="text" class="form-control" name="milestone[]"></div><div class="col-md-2 fv-row"><label class="required fs-6 fw-semibold mb-2">Start Date</label><input type="date" class="form-control form-control-solid mile_start_date" placeholder="Enter Start Date" name="mile_start_date[]" required></div><div class="col-md-2 fv-row"><label class="required fs-6 fw-semibold mb-2">End Date</label><input type="date" class="form-control form-control-solid mile_end_date" placeholder="Enter End Date" name="mile_end_date[]" required></div><div class="col-md-4 fv-row"><label class="required fs-6 fw-semibold mb-2">Level To Be Crossed</label><select class="form-control levels_to_be_crossed" name="level_to_be_crosssed[]"><option value="">Select</option>@for($i=1; $i<=11; $i++)<option value="{{$i}}">{{$i}}</option>@endfor</select></div></div><br><button type="button" class="btn btn-sm btn-danger remove-field1" onclick="remove_more();">Remove</button><button type="button" class="btn btn-sm btn-success add-field1" onclick="append_more();">Add field</button></div>').appendTo(".multi-fields").find('input').val('').end()
        focus();
    }

    function remove_more() {
        $(".multi-fields").children("div[class=multi-field]:last").remove()
        // $(".multi-fields .multi-field:last-child").remove();
    }

</script>
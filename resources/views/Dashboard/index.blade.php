@extends('layouts.app')

@section('content')
<style>
    .card.st {
        background-color: #f9f3f3;
    }
</style>
<div class="app-main flex-column flex-row-fluid" id="kt_app_main">
    <!--begin::Content wrapper-->
    <div class="d-flex flex-column flex-column-fluid">
        <!--begin::Toolbar-->
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">

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

                        <!-- Team -->
                        <section id="team" class="pb-5">
                            <div class="container">
                                <h5 class="section-title h1">Overview</h5>
                                <div class="row">
                                    <div class="col-2" >
                                        <!--begin::Items-->
                                        <div class="bg-gray-100 bg-opacity-70 rounded-2 px-6 py-5"style="border: none;border-top:5px solid coral">
                                            <!--begin::Symbol-->
                                           
                                            <!--end::Symbol-->
                                            <!--begin::Stats-->
                                            <div class="m-0">
                                                <!--begin::Number-->
                                                <span class="text-gray-700 fw-bolder d-block fs-2qx lh-1 ls-n1 mb-1"><?php echo count($project); ?></span>
                                                <!--end::Number-->
                                                <!--begin::Desc-->
                                                <span class="text-gray-500 fw-semibold fs-6">Total Number Of Projects</span>
                                                <!--end::Desc-->
                                            </div>
                                            <!--end::Stats-->
                                        </div>
                                        <!--end::Items-->
                                    </div>
                                    <!-- Team member -->

                                    <!-- ./Team member -->
                                    <!-- Team member -->
                                    <div class="col-2">
                                        <!--begin::Items-->
                                        <div class="bg-gray-100 bg-opacity-70 rounded-2 px-6 py-5" style="border: none;border-top:5px solid #bd7ffa">
                                            <!--begin::Symbol-->
                                          
                                            <!--end::Symbol-->
                                            <!--begin::Stats-->
                                            <div class="m-0">
                                                <!--begin::Number-->
                                                <span class="text-gray-700 fw-bolder d-block fs-2qx lh-1 ls-n1 mb-1"><?php echo count($project); ?></span>
                                                <!--end::Number-->
                                                <!--begin::Desc-->
                                                <span class="text-gray-500 fw-semibold fs-6">Total Number Of Documents</span>
                                                <!--end::Desc-->
                                            </div>
                                            <!--end::Stats-->
                                        </div>
                                        <!--end::Items-->
                                    </div>
                                    <!-- ./Team member -->

                                    <!-- Team member -->
                                    <div class="col-2">
                                        <!--begin::Items-->
                                        <div class="bg-gray-100 bg-opacity-70 rounded-2 px-6 py-5" style="border: none;border-top:5px solid #38eb7a">
                                            <!--begin::Symbol-->
                                          
                                            <!--end::Symbol-->
                                            <!--begin::Stats-->
                                            <div class="m-0">
                                                <!--begin::Number-->
                                                <span class="text-gray-700 fw-bolder d-block fs-2qx lh-1 ls-n1 mb-1"><?php echo count($approved_project_document); ?></span>
                                                <!--end::Number-->
                                                <!--begin::Desc-->
                                                <span class="text-gray-500 fw-semibold fs-6">No.of Documents Approved</span>
                                                <!--end::Desc-->
                                            </div>
                                            <!--end::Stats-->
                                        </div>
                                        <!--end::Items-->
                                    </div>
                                    <!-- ./Team member -->

                                    <!-- Team member -->
                                    <div class="col-2">
                                        <!--begin::Items-->
                                        <div class="bg-gray-100 bg-opacity-70 rounded-2 px-6 py-5" style="border: none;border-top:5px solid #f02b45">
                                            <!--begin::Symbol-->
                                        
                                            <!--end::Symbol-->
                                            <!--begin::Stats-->
                                            <div class="m-0">
                                                <!--begin::Number-->
                                                <span class="text-gray-700 fw-bolder d-block fs-2qx lh-1 ls-n1 mb-1"><?php echo count($pending_project_document); ?></span>
                                                <!--end::Number-->
                                                <!--begin::Desc-->
                                                <span class="text-gray-500 fw-semibold fs-6">No.of Documents Pending</span>
                                                <!--end::Desc-->
                                            </div>
                                            <!--end::Stats-->
                                        </div>
                                        <!--end::Items-->
                                    </div>
                                    <!-- ./Team member -->

                                    <!-- Team member -->
                                    <div class="col-2">
                                        <!--begin::Items-->
                                        <div class="bg-gray-100 bg-opacity-70 rounded-2 px-6 py-5" style="border: none;border-top:5px solid #e6b410">
                                            <!--begin::Symbol-->
                                          
                                            <!--end::Symbol-->
                                            <!--begin::Stats-->
                                            <div class="m-0">
                                                <!--begin::Number-->
                                                <span class="text-gray-700 fw-bolder d-block fs-2qx lh-1 ls-n1 mb-1"><?php echo count($project); ?></span>
                                                <!--end::Number-->
                                                <!--begin::Desc-->
                                                <span class="text-gray-500 fw-semibold fs-6">Declined Documents</span>
                                                <!--end::Desc-->
                                            </div>
                                            <!--end::Stats-->
                                        </div>
                                        <!--end::Items-->
                                    </div>
                                    <div class="col-2">
                                        <!--begin::Items-->
                                        <div class="bg-gray-100 bg-opacity-70 rounded-2 px-6 py-5" style="border: none;border-top:5px solid #8c05ab">
                                            <!--begin::Symbol-->
                                          
                                            <!--end::Symbol-->
                                            <!--begin::Stats-->
                                            <div class="m-0">
                                                <!--begin::Number-->
                                                <span class="text-gray-700 fw-bolder d-block fs-2qx lh-1 ls-n1 mb-1"><?php echo count($project); ?></span>
                                                <!--end::Number-->
                                                <!--begin::Desc-->
                                                <span class="text-gray-500 fw-semibold fs-6">Documents Overdue</span>
                                                <!--end::Desc-->
                                            </div>
                                            <!--end::Stats-->
                                        </div>
                                        <!--end::Items-->
                                    </div>
                                    <!-- ./Team member -->

                                </div>                              
                                <br>
                                <div class="row">

                                    <h5 class="section-title h1">Recently Uploaded Documents</h5>
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
                                                <th class="text-end min-w-100px">Actions</th>
                                            </tr>
                                            <!--end::Table row-->
                                        </thead>
                                        <!--end::Table head-->
                                        <!--begin::Table body-->
                                        <tbody class="text-gray-600 fw-semibold">
                                            <!--begin::Table row-->
                                            @foreach ($order_at as $key => $d)

                                            <tr>
                                                <!--begin::Checkbox-->

                                                <!--end::Checkbox-->
                                                <!--begin::User=-->
                                                <td class="d-flex align-items-center">
                                                    {{ $d->id }}
                                                </td>

                                                <td>{{ $d->project_name . ' ' . $d->project_code }}</td>
                                                <td>{{ $d->workflow_name . ' ' . $d->workflow_code }}</td>
                                                <td>{{ $d->first_name . ' ' . $d->last_name }}</td>
                                                <td></td>
                                                <td class="text-end">
                                                    <a href="#" class="btn btn-light btn-active-light-primary btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions

                                                        <span class="svg-icon svg-icon-5 m-0">
                                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="currentColor" />
                                                            </svg>
                                                        </span>
                                                    </a>
                                                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                                                        <div class="menu-item px-3">
                                                            <a href="{{ url('viewProject/' . $d->id) }}" class="menu-link px-3">View</a>
                                                        </div>
                                                        <div class="menu-item px-3">
                                                            <a href="#" class="menu-link px-3" data-bs-toggle="modal" data-bs-target="#kt_modal_create_campaign" onclick="get_edit_details(<?php echo $d->id; ?>)">Edit</a>
                                                        </div>
                                                        <div class="menu-item px-3">
                                                            <a href="javascript:void(0);" class="menu-link px-3" onclick="delete_item(<?php echo $d->id; ?>);">Delete</a>
                                                        </div>
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


    </div>
</div>
</section>
<!-- Team -->
@endsection
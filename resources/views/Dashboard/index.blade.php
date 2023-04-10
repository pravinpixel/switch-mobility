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
                                    <div class="col-2">
                                        <!--begin::Items-->
                                        <div class="bg-gray-100 bg-opacity-70 rounded-2 px-6 py-5" style="border: none;border-top:5px solid coral">
                                            <!--begin::Symbol-->

                                            <!--end::Symbol-->
                                            <!--begin::Stats-->
                                            <div class="m-0">
                                                @if(auth()->user()->is_super_admin ==1 ||auth()->user()->can('project-view'))
                                                <a href="{{url('projects')}}">
                                                    @endif
                                                    <!--begin::Number-->
                                                    <span class="text-gray-700 fw-bolder d-block fs-2qx lh-1 ls-n1 mb-1">{{$totProject}}</span>
                                                    <!--end::Number-->
                                                    <!--begin::Desc-->
                                                    <span class="text-gray-500 fw-semibold fs-6">Total Number Of Projects</span>
                                                    @if(auth()->user()->is_super_admin ==1 ||auth()->user()->can('project-view')) <!--end::Desc-->
                                                </a>
                                                @endif
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
                                                @if(auth()->user()->is_super_admin ==1 ||auth()->user()->can('document-listing-view'))
                                                <a href="{{url('doclisting')}}">
                                                    @endif
                                                    <!--begin::Number-->
                                                    <span class="text-gray-700 fw-bolder d-block fs-2qx lh-1 ls-n1 mb-1"><?php echo $totDocs; ?></span>
                                                    <!--end::Number-->
                                                    <!--begin::Desc-->
                                                    <span class="text-gray-500 fw-semibold fs-6">Total Number Of Documents</span>
                                                    <!--end::Desc-->
                                            </div>
                                            @if(auth()->user()->is_super_admin ==1 ||auth()->user()->can('project-view')) <!--end::Desc-->
                                            </a>
                                            @endif
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
                                                @if(auth()->user()->is_super_admin ==1 ||auth()->user()->can('document-listing-view'))
                                                <a href="{{url('doclistingIndex/approved')}}">
                                                    @endif
                                                    <!--begin::Number-->
                                                    <span class="text-gray-700 fw-bolder d-block fs-2qx lh-1 ls-n1 mb-1"><?php echo $totApprovedDocs; ?></span>
                                                    <!--end::Number-->
                                                    <!--begin::Desc-->
                                                    <span class="text-gray-500 fw-semibold fs-6">No.of Documents Approved</span>
                                                    <!--end::Desc-->
                                                    @if(auth()->user()->is_super_admin ==1 ||auth()->user()->can('document-listing-view'))
                                                </a>
                                                @endif
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
                                                @if(auth()->user()->is_super_admin ==1 ||auth()->user()->can('document-listing-view'))
                                                <a href="{{url('doclistingIndex/pending')}}">
                                                    @endif
                                                    <!--begin::Number-->
                                                    <span class="text-gray-700 fw-bolder d-block fs-2qx lh-1 ls-n1 mb-1"><?php echo $totPendingDocs ?></span>
                                                    <!--end::Number-->
                                                    <!--begin::Desc-->
                                                    <span class="text-gray-500 fw-semibold fs-6">No.of Documents Pending</span>
                                                    <!--end::Desc-->
                                                    @if(auth()->user()->is_super_admin ==1 ||auth()->user()->can('document-listing-view'))
                                                </a>
                                                @endif
                                            </div>
                                            <!--end::Stats-->
                                        </div>
                                        <!--end::Items-->
                                    </div>
                                    <!-- ./Team member -->

                                    <!-- Team member -->
                                    <div class="col-2" style="">
                                        <!--begin::Items-->
                                        <div class="bg-gray-100 bg-opacity-70 rounded-2 px-6 py-5" style="border: none;border-top:5px solid #e6b410">
                                            <!--begin::Symbol-->

                                            <!--end::Symbol-->
                                            <!--begin::Stats-->
                                            <div class="m-0">
                                                @if(auth()->user()->is_super_admin ==1 ||auth()->user()->can('document-listing-view'))
                                                <a href="{{url('doclistingIndex/declined')}}">
                                                    @endif
                                                    <!--begin::Number-->
                                                    <span class="text-gray-700 fw-bolder d-block fs-2qx lh-1 ls-n1 mb-1"><?php echo  $totDeclinedDocs ?></span>
                                                    <!--end::Number-->
                                                    <!--begin::Desc-->
                                                    <span class="text-gray-500 fw-semibold fs-6">Declined Documents</span>
                                                    <!--end::Desc-->
                                                    @if(auth()->user()->is_super_admin ==1 ||auth()->user()->can('document-listing-view'))
                                                </a>
                                                @endif
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
                                                @if(auth()->user()->is_super_admin ==1 ||auth()->user()->can('document-listing-view'))
                                                <a href="{{url('doclistingIndex')}}">
                                                    @endif
                                                    <!--begin::Number-->
                                                    <span class="text-gray-700 fw-bolder d-block fs-2qx lh-1 ls-n1 mb-1"><?php echo count($project); ?></span>
                                                    <!--end::Number-->
                                                    <!--begin::Desc-->
                                                    <span class="text-gray-500 fw-semibold fs-6">Documents Overdue</span>
                                                    <!--end::Desc-->
                                                    @if(auth()->user()->is_super_admin ==1 ||auth()->user()->can('document-listing-view'))
                                                </a>
                                                @endif
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
                                    <table class="table align-middle table-row-bordered fs-6 gy-5" id="service_table">
                                        <!--begin::Table head-->
                                        <thead>
                                            <!--begin::Table row-->
                                            <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">

                                                <th class="min-w-125px">Ticket No</th>
                                                <th class="min-w-125px">Project Code & Name</th>
                                                <th class="min-w-125px">Work Flow Code & Name</th>
                                                <th class="min-w-125px">Initiator</th>
                                                <th class="min-w-125px">Department</th>

                                            </tr>
                                            <!--end::Table row-->
                                        </thead>
                                        <!--end::Table head-->
                                        <!--begin::Table body-->
                                        <tbody class="text-gray-600 fw-semibold">
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

                                            <td>{{ $d->project_name . ' ' . $d->project_code }}</td>
                                            <td>{{ $WorkFlow->workflow_name . ' & ' . $WorkFlow->workflow_code }}</td>
                                            <td>{{ $initiator->first_name . ' ' . $initiator->last_name }}</td>
                                            <td>{{ $department->name }}</td>

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
<script>
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
</script>
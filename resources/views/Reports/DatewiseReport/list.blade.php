@extends('layouts.app')

@section('content')

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
                    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Datewise Report</h1>
                    <!--end::Title-->
                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">
                            <a href="#" class="text-muted text-hover-primary">Reports</a>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-400 w-5px h-2px"></span>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">Datewise Report</li>
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
                            <div class="row">
                                <div class="col-md-5" style="display:inline;">
                                    <!--begin::Label-->
                                    <label class="required fs-6 fw-semibold mb-2">Start Date</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="date" class="form-control startDate" value="" name="startDate" autocomplete="off" />


                                </div>

                                <div class="col-md-5" style="display:inline;">
                                    <!--begin::Label-->
                                    <label class="required fs-6 fw-semibold mb-2">End Date</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="date" class="form-control endDate" value="" name="endDate" autocomplete="off" />


                                </div>
                                <div class="col-md-2">
                                    <label class="fs-6 fw-semibold mb-2">&nbsp;</label>
                                    <button class="btn btn-success badge badge-secondary h1" onclick="exportData()">Export to Excel</button>
                                </div>
                            </div>
                        </div>



                    </div>
                    <!--end::Card header-->
                    <!--begin::Card body-->
                    <div class="card-body py-4">
                        <!--begin::Card title-->
                        <div class="card-title">
                            <!--begin::Search-->
                            <div class="d-flex align-items-center position-relative my-1" style="display: none;">
                                <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                                <!-- <span class="svg-icon svg-icon-1 position-absolute ms-6">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor" />
                                        <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="currentColor" />
                                    </svg>
                                </span> -->
                                <!--end::Svg Icon-->
                                <input type="text" style="display: none;" class="form-control form-control-solid w-250px ps-14 deptSearch" placeholder="Search" />
                            </div>
                            <!--end::Search-->
                        </div>
                        <!--begin::Card title-->
                        <!--begin::Table-->
                        <table class="table align-middle table-row-bordered fs-6 gy-5" id="service_table">
                            <!--begin::Table head-->
                            <thead>
                                <!--begin::Table row-->
                                <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">

                                 
                                    <th>Project Code</th>
                                    <th>Project Name</th>
                                    <th>Workflow Name</th>
                                    <th>Workflow Code</th>
                                    <th>Initiator</th>
                                    <th>Department</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                                <!--end::Table row-->
                            </thead>
                            <!--end::Table head-->
                            <!--begin::Table body-->
                            <tbody class="text-gray-600 fw-semibold" id="tableContent">


                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>





<script>
    $(document).ready(
        function() {


            var todayDate = new Date();
            var today = todayDate.toISOString().substr(0, 10);



            todayDate.setDate(todayDate.getDate() - 6); //number  of days to add, e.x. 15 days
            var nextSixDay = todayDate.toISOString().substr(0, 10);

            $('.startDate').val(nextSixDay);
            $('.endDate').val(today);
            filterData();

            $('.startDate').on('change', function() {
                filterData();
            });

            $(".endDate").change(function() {
                var startDate = $('.startDate').val();
                var endDate = $('.endDate').val();


                if (startDate > endDate) {
                    Swal.fire(
                        'Warning!',
                        'End date should be greater than Start date.',
                        'error'
                    );

                    $('.endDate').val('');
                } else {
                    filterData();
                }
            });




            function filterData() {
                console.log("well");
                var startDate = $('.startDate').val();
                var endDate = $('.endDate').val();
                if (startDate && endDate) {
                    $.ajax({
                        url: "{{ route('dateWiseReportSearchFilter') }}",
                        type: 'ajax',
                        method: 'post',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            startDate: startDate,
                            endDate: endDate,
                        },
                        success: function(data) {
                            var entities = data.entities;
                            var table = $('#service_table').DataTable();
                            table.clear().draw();

                            $.each(entities, function(key, val) {
                                var sNo = key + 1;
                                var projectCode = val.projectCode;
                                var projectName = val.projectName;
                                var workflowName = val.workflowName;
                                var workflowCode = val.workflowCode;
                                var initiater = val.initiater;
                                var department = val.department;
                                var projectId = val.projectId;
                                var activeStatus = "";

                                var editurl = '{{ route("viewDocListing", ":id") }}';
                                editurl = editurl.replace(':id', projectId);
                                var viewBtn = '<div id=' + projectId + ' class="btn switchPrimaryBtn  viewDocs">View</div>';


                                table.row.add([projectCode, projectName, workflowName, workflowCode, initiater, department, activeStatus, viewBtn]).draw();
                            });
                        },
                        error: function() {
                            $("#otp_error").text("Update Error");
                        }

                    });
                }
            }
        });
    $(document).on('click', '.viewDocs', function() {
        console.log("well and good");
        var id = $(this).attr('id');


        var url = "{{route('viewDocListing')}}";
        var form = $('<form action="' + url + '" method="post">' +
            ' {{ csrf_field() }} <input type="hidden" name="id" value="' + id + '" />' +
            '</form>');
        $('body').append(form);
        form.submit();
    });

    function exportData() {
        /* Get the HTML data using Element by Id */
        var table = document.getElementById("service_table");

        /* Declaring array variable */
        var rows = [];

        //iterate through rows of table
        for (var i = 0, row; row = table.rows[i]; i++) {
            //rows would be accessed using the "row" variable assigned in the for loop
            //Get each cell value/column from the row
            column1 = row.cells[0].innerText;
            column2 = row.cells[1].innerText;
            column3 = row.cells[2].innerText;
            column4 = row.cells[3].innerText;
            column5 = row.cells[4].innerText;
            column6 = row.cells[5].innerText;
            column7 = row.cells[6].innerText;
            /* add a new records in the array */
            rows.push(
                [
                    column1,
                    column2,
                    column3,
                    column4,
                    column5,
                    column6,
                    column7,
                ]
            );

        }
        csvContent = "data:text/csv;charset=utf-8,";

        /* add the column delimiter as comma(,) and each row splitted by new line character (\n) */
        rows.forEach(function(rowArray) {
            row = rowArray.join(",");
            csvContent += row + "\r\n";
        });
        var encodedUri = encodeURI(csvContent);
        var link = document.createElement("a");
        link.setAttribute("href", encodedUri);
        link.setAttribute("download", "DatewiseReports.csv");
        document.body.appendChild(link);
        link.click();
    }
</script>
@endsection
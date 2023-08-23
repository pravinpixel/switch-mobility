@extends('layouts.app')

@section('content')
<style>
    .toAllowType-container {
        display: flex;
        align-items: center;
        margin-bottom: 10px;
    }

    .main-label {
        margin-right: 10px;
    }

    .radio-labels {
        display: flex;
        align-items: center;
    }

    .radio-labels label {
        margin-right: 10px;
    }

    .table-container {
        max-height: 300px;
        /* Adjust this value as needed */
        overflow-y: auto;
        border: 1px solid #ccc;
    }

    /* Increase the size of the radio button */
    input[type="radio"] {
        width: 20px;
        height: 20px;
        margin-right: 5px;
        /* Adjust spacing */
    }

    /* Style the radio button appearance */
    input[type="radio"]::before {
        content: "";
        display: inline-block;
        width: 20px;
        height: 20px;
        border: 2px solid black;
        /* Change border color */
        border-radius: 50%;
        /* Make it circular */
        background-color: white;
        /* Background color inside the radio button */
        vertical-align: middle;
    }

    /* Style when the radio button is checked */
    input[type="radio"]:checked::before {
        background-color: #3565ed;
        /* Change the background color when checked */
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
                        Employee</h1>
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
                        <li class="breadcrumb-item text-muted">Employee</li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-400 w-5px h-2px"></span>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">Reassign Employee</li>
                        <!--end::Item-->
                    </ul>
                    <!--end::Breadcrumb-->
                </div>
                <!--end::Page title-->

            </div>
        </div>
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <div id="kt_app_content_container" class="app-container container-xxl">
                <div class="card" style="width:700px;margin:auto;">
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
                    <!--begin::Card body-->
                    <div class="card-body py-5">
                        <table class="table align-middle table-row-bordered fs-6 gy-5 table-container" id="service_table">
                            <!--begin::Table head-->
                            <thead>
                                <!--begin::Table row-->
                                <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">

                                    <th>S.No</th>
                                    <th>Workflow Name</th>
                                    <th>Project Name</th>
                                    <th>level</th>
                                    <th>type</th>
                                </tr>
                                <!--end::Table row-->
                            </thead>
                            <!--end::Table head-->
                            <!--begin::Table body-->
                            <tbody class="text-gray-600 fw-semibold">
                                @foreach($responseDatas as $responseData)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$responseData['wfName']}}</td>
                                    <td>{{$responseData['projectName']}}</td>
                                    <td>{{$responseData['level']}}</td>
                                    <td>{{$responseData['type']}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <hr>
                        <form class="form" method="post" action="{{url('reAssignEmployeeUpdate')}}">
                            @csrf

                            <!--end::Input group-->

                            <div class="row g-10 mb-8">
                                <!--begin::Col-->
                                <div class="col-md-8 fv-row" style="display: flex;">
                                    <!--begin::Label-->
                                    <label class="required  fw-semibold mb-2"> Reassign To</label>
                                    <select class="form-select reAssignEmployeeId" name="reAssignEmployeeId" data-kt-select2="true">
                                        <option value="">Select</option>
                                        @foreach ($employeeDatas as $employeeData)
                                        <option value="{{ $employeeData['id'] }}">
                                            {{ $employeeData['name'] }}
                                        </option>
                                        @endforeach
                                    </select>
                                    <p id="nameAlert" class="notifyAlert"></p>
                                </div>
                            </div>
                            <input type="hidden" name="empId" value="{{$empId}}">
                            <input type="hidden" name="actionType" value="{{$actionType}}">
                            <div class="row g-9 mb-7">
                                <!--end::Col-->
                                <!--begin::Col-->
                                <div class="col-md-12 fv-row">
                                    <div class="toAllowType-container">
                                        <label class="main-label fs-6 fw-semibold mb-2">To Allow:</label>
                                        <div class="radio-labels">
                                            <label>
                                                <input type="radio" name="toAllowType" value="1">
                                                Only Upcoming Levels
                                            </label>
                                            <label>
                                                <input type="radio" name="toAllowType" value="2" checked>
                                                All Levels
                                            </label>

                                        </div>
                                    </div>

                                    <!--end::Input-->
                                </div>
                                <!--end::Col-->
                            </div>

                            {{-- FORM --}}
                            <div class="text-center pt-15">

                                <a href="{{route('employees.index')}}">
                                    <button type="button" class="btn btn-light-danger me-3">Cancel</button></a>
                                <button type="button" class="btn switchPrimaryBtn submitBtn" onclick="deptValidation();" data-kt-users-modal-action="submit">
                                    <span class="indicator-label">Save and Exit</span>
                                    <span class="indicator-progress">Please wait...
                                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
<script data-require="jquery@*" data-semver="3.0.0" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.js">
</script>
<script>
    $(document).ready(function() {

        $('.submitBtn').attr('disabled', 'true');
        if ($('.id').val()) {
            $('.submitBtn').removeAttr('disabled');
            $('.reset').css('display', 'none');
        }
        $('.reset').on('click', function() {
            $('.submitBtn').attr('disabled', 'true');
        });


        $(document).on('change', '.reAssignEmployeeId', function() {
            var id = $(this).val();
            console.log(id);
            if (id) {
                $('.submitBtn').removeAttr('disabled');
            } else {
                $('.submitBtn').attr('disabled', 'true');
            }
        });
    });

    function deptValidation() {



        var reAssignEmployeeId = $('.reAssignEmployeeId').val();
        var alertName = 'nameAlert';
        if (reAssignEmployeeId) {
            document.getElementById(alertName).style.display = "none";
            $('.submitBtn').removeAttr('disabled');
            Swal.fire({
                title: 'Change Status',
                text: "Are you sure want to change?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3565ed',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Change it!'
            }).then(isConfirmed => {
                if (isConfirmed.value) {
                    $(".form").submit();
                    return true;
                }
            });

        } else {
            $('.submitBtn').attr('disabled', true);

            document.getElementById(alertName).style.display = "block";
            document.getElementById(alertName).style.color = "red";
            document.getElementById(alertName).innerHTML = 'Reassign Employee is Mandatory*';
            return false;
        }
    }
</script>
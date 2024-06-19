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
                    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                        Department</h1>
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
                        <li class="breadcrumb-item text-muted">Departments</li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-400 w-5px h-2px"></span>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">{{ $model ? 'Edit' : 'Add' }}</li>
                        <!--end::Item-->
                    </ul>
                    <!--end::Breadcrumb-->
                </div>
                <!--end::Page title-->
            </div>
        </div>
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <div id="kt_app_content_container" class="app-container container-xxl">
                <div class="card" style="width:500px;margin:auto;">
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

                    <!--begin::Card body-->
                    <div class="card-body py-4">
                        <!--begin::Card title-->
                        <form class="form" method="post" action="{{url('department')}}">
                            @csrf
                            <input type="hidden" value="{{ $model ? $model->id : '' }}" name='id' class="id">
                            <!--end::Input group-->

                            <div class="row g-9 mb-7">
                                <!--begin::Col-->
                                <div class="col-md-12 fv-row">
                                    <!--begin::Label-->
                                    <label class="required fs-6 fw-semibold mb-2">Department</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input class="form-control form-control-solid department" value="{{ $model ? $model->name : '' }}" placeholder="Enter Department" name="name" required autocomplete="off" />
                                    <!--end::Input-->
                                    <p id="nameAlert" class="notifyAlert"></p>
                                </div>
                            </div>
                            <div class="row g-9 mb-7">
                                <!--end::Col-->
                                <!--begin::Col-->
                                <div class="col-md-12 fv-row">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-semibold mb-2">Description</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <textarea class="form-control form-control-solid" name="description" rows="4" cols="50">{{ $model ? $model->description : '' }}</textarea>
                                    <!--end::Input-->
                                </div>
                                <!--end::Col-->
                            </div>

                            <div class="text-center pt-15">
                                <button type="reset" class="btn btn-light me-3 reset ">Reset</button>
                                <a href="{{route('department.index')}}">
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
    });

    $(document).on('input', '.department', function() {
        var name = $(this).val().trim();
        if (name) {
            $('.submitBtn').removeAttr('disabled');
        } else {
            $('.submitBtn').attr('disabled', 'true');
        }
    });

    function deptValidation() {
        $('.submitBtn').attr('disabled', true);
        var name = $('.department').val().trim();
        var id = $('.id').val();
        if (name) {
            $.ajax({
                url: "{{url('departmentValidation')}}",
                type: 'ajax',
                method: 'post',
                data: {
                    "_token": "{{ csrf_token() }}",
                    name: name,
                    id: id
                },
                success: function(result) {
                    var alertName = 'nameAlert';
                    if (result.response == false) {
                        $('.submitBtn').attr('disabled', true);
                        $('#' + alertName).text('Name is already exists*').css('color', 'red').show();
                        return false;
                    }
                    $('#' + alertName).hide();
                    $(".form").submit();
                    return true;
                }
            });
        }
    }
</script>

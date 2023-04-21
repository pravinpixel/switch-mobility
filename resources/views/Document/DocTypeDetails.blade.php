@extends('layouts.app')

@section('content')

<style>
    th.tdStyle {
        min-width: 150px;
        display: inline-block;
        border-radius: 18px;
        /* background-color: #fce6cc; */
        color: black;
        border: 2px solid #fce6cc;
        margin: 5px !important;
        text-align: center !important;

    }

    .work_levels {
        display: none;
    }

    td.tdStyle {
        /* min-width: 150px; */
        display: inline-block;
        border-radius: 18px;
        /* background-color: #fce6cc; */
        color: black;
        border: 2px solid #fce6cc;
        margin-left: 5px;
        margin-right: 5px;
        margin-top: 5px;
        text-align: center;
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
                    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Document Type</h1>
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
                        <li class="breadcrumb-item text-muted">DocumentType</li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-400 w-5px h-2px"></span>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted"><?php echo ($model) ? "Edit" : "Add"; ?></li>
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

                    <!--end::Card header-->
                    <!--begin::Card body-->
                    <div class="card-body py-4">
                        <!--begin::Card title-->

                        <!--begin::Card title-->
                        <!--begin::Table-->
                        <form class="form" method="post" action="{{url('documentType')}}">
                            @csrf
                            <input type="hidden" value="<?php echo ($model) ? $model->id : "" ?>" name='id' class="id">
                            <!--end::Input group-->

                            <div class="row g-9 mb-7">
                                <!--begin::Col-->
                                <div class="col-md-12 fv-row">
                                    <!--begin::Label-->
                                    <label class="required fs-6 fw-semibold mb-2">Document Type</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input class="form-control form-control-solid name" value="<?php echo ($model) ? $model->name : "" ?>" placeholder="Enter Document type" name="name" required autocomplete="off" />
                                    <!--end::Input-->
                                    <p id="nameAlert" class="notifyAlert"></p>
                                </div>
                            </div>
                            <div class="row g-9 mb-7">
                                <!--end::Col-->
                                <!--begin::Col-->
                                <div class="col-md-12 fv-row">
                                    <label class="required fs-6 fw-semibold mb-2">Workflow</label>
                                    <select class="form-control workflow_id" name="workflow_id" onchange="get_work_flow_levels(this.value);" required>
                                        <option value="">Select</option>
                                        @foreach($workflow as $wf)

                                        <?php
                                        $wfId = ($model) ? $model->workflow_id : "";
                                        $selectedRow = ($wfId == $wf['id']) ? "selected" : "";

                                        ?>
                                        <option value="{{$wf['id']}}" <?php echo  $selectedRow; ?>>{{$wf['workflow_name']}}</option>
                                        @endforeach
                                    </select>
                                    <p id="workflowAlert" class="notifyAlert"></p>
                                </div>
                                <!--end::Col-->
                            </div>
                            <br>
                            <div style="display:none">
                            <table class="table custom_table table-info"  id="custom_table">
                                <thead>
                                    <tr>
                                        <th>A</th>
                                        <th>B</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>2</td>
                                    </tr>
                                </tbody>
                            </table>
                            </div>
                            <div class="row g-9 mb-7 work_levels">
                                <table class="table custom_table" id="custom_table">
                                    <thead style="width:100%!important">
                                        <tr>
                                            <th class="">
                                                Level
                                            </th>
                                            <th class="">
                                                Designation
                                            </th>
                                        </tr>
                                    </thead>

                                    <tbody class="append_div_partial">

                                    </tbody>
                                </table>
                            </div>

                            {{-- FORM --}}
                            <div class="text-center pt-15">
                                <button type="reset" class="btn btn-light me-3 reset " onclick=" document.location.reload();">Reset</button>
                                <a href="{{route('documentType.index')}}">
                                    <button type="button" class="btn btn-light-danger me-3">Cancel</button></a>
                                <button onclick="validation();" type="button" class="btn switchPrimaryBtn submitBtn" data-kt-users-modal-action="submit">
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
<script data-require="jquery@*" data-semver="3.0.0" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.js"></script>
<script>
    $(document).ready(function() {
        console.log($('.id').val());

        var wfid = $('.workflow_id').val();
        if (wfid) {
            get_work_flow_levels(wfid)
        }
        $('.submitBtn').attr('disabled', 'true');
        if ($('.id').val()) {
            $('.submitBtn').removeAttr('disabled');
            $('.reset').css('display', 'none');
        }

    });
    if ($('.id').val()) {
        $('.submitBtn').removeAttr('disabled');
        $('.reset').css('display', 'none');
    }
    $(document).on('input', '.name', function() {
        if ($(this).val()) {
            $('.submitBtn').removeAttr('disabled');
        } else {
            $('.submitBtn').attr('disabled', 'true');
        }
    });
    $(document).on('change', '.workflow_id', function() {
        if ($(this).val()) {
            $('.submitBtn').removeAttr('disabled');
            document.getElementById('workflowAlert').style.display = "none";
        }
    });

    function get_work_flow_levels(workflow_id) {
        $.ajax({
            url: "{{url('getWorkflowLevels')}}",
            type: 'ajax',
            method: 'post',
            data: {
                "_token": "{{ csrf_token() }}",
                workflow_id: workflow_id,
            },
            success: function(data) {
                document.getElementById('custom_table').style.display = 'block'
                if (data) {
                    var allData = data;
                    console.log(allData);
                    var levels = allData.entities;
                    $(".work_levels").show();
                    $(".append_div_partial").empty();
                    $.each(levels, function(key, val) {
                        var designationData = val.designationId;

                        $(".append_div_partial").append('<tr style="border: 0.8px solid black;border-collapse: collapse;"><td class="" ><label>Level-<span class="level_name1">' + val.levelId + '</span></label></td><td class="">' + designationData + '</td></tr>');
                    });
                }
            }
        });
    }

    function validation() {

        //  Swal.fire('Any fool can use a computer');
        var name = $('.name').val().length;
        console.log(name);
        var id = $('.id').val();
        var workflow_id = $('.workflow_id').val();
        if (!workflow_id) {
            $('.submitBtn').attr('disabled', true);

            document.getElementById('workflowAlert').style.display = "block";
            document.getElementById('workflowAlert').style.color = "red";
            document.getElementById('workflowAlert').innerHTML = 'Workflow is Required*';
            return false;
        }
        if (!name) {
            $('.submitBtn').attr('disabled', true);

            document.getElementById('nameAlert').style.display = "block";
            document.getElementById('nameAlert').style.color = "red";
            document.getElementById('nameAlert').innerHTML = 'Name is Required*';
            return false;
        }



        $.ajax({
            url: "{{url('documentTypeValidation')}}",
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

                    document.getElementById(alertName).style.display = "block";
                    document.getElementById(alertName).style.color = "red";
                    document.getElementById(alertName).innerHTML = 'Document Type is Exists*';
                    return false;
                }
                document.getElementById(alertName).style.display = "none";
                $('.submitBtn').removeAttr('disabled');
                $(".form").submit();
                return true;
            }
        });


    }
</script>


@endsection
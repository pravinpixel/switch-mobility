@extends('layouts.app')

@section('content')
<style>
    * {
        box-sizing: border-box
    }

    /* Style the tab */
    .tab {

        border-radius: 5px;
        overflow-y: auto;
        width: 180px;
        padding: 0 20px;
        background: white;
        box-shadow: rgba(0, 0, 0, 0.1) 0px 1px 2px 0px;
    }

    .LevelTabContent {
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
    }

    form:has(.level-container.current) .action-button {
        background: white;
        box-shadow: rgba(0, 0, 0, 0.1) 0px 1px 2px 0px;
        margin-top: 10px;
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
        border: 1px solid #ccc;
        width: 100%;
        border-left: none;
        height: 1100px;
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
        width: 100px;
        height: 100px;

    }

    .pdf_delete_btn {
        width: 100px !important;
    }

    .pdf-view {
        border: 1px solid black;
        padding: 5px;
    }

    .pdf {
        margin: 0 10px;
        width: 100px;
    }

    .pdf label {
        width: 100%;
    }

    .pdf-view .upload-text {
        margin: 40px auto;
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
        min-height: 400px !important;
        max-height: 400px !important;
        overflow-x: hidden;
        overflow-y: auto;
    }

    .level-container {
        background: transparent;
        display: flex;
        flex-wrap: wrap;

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
                        Employee Bulk Data Upload</h1>
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
                        <li class="breadcrumb-item text-muted">Bulk Data Upload</li>
                        <!--end::Item-->
                    </ul>
                    <!--end::Breadcrumb-->
                </div>
                <!--end::Page title-->

            </div>
        </div>
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <div id="kt_app_content_container" class="app-container container-xxl">
                <div class="card col-12" style="margin;:auto;">
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
                        <form id="basic-form" method="post" action="">
                            @csrf

                            <div class="row">
                                <!--begin::Col-->
                                <div class="col-md-3 fv-row">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-semibold mb-2"></label>
                                    <a class="btn btn-warning btn-sm" href="{{ asset('/bulk1.xlsx') }}" target="_blank" download title="download">Sample Format <i class="las la-download"></i></a>

                                    <!--end::Input-->
                                </div>
                                <div class="col-md-3 fv-row">
                                    <!--begin::Label-->
                                    <label class="required fs-6 fw-semibold mb-2">File(Only Excel File)</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="file" class="form-control form-control-solid" name="bulkupload" id="" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                                    <p id="fileAlert" class="notifyAlert"></p>
                                </div> <!--end::Col-->
                            </div>
                            <br>
                            <div class="row col-md-6 errorDiv alert alert-warning" style="display: none;">

                            </div>
                            <div class="text-center pt-15">
                                <a href="{{ route('employees.index') }}">
                                    <button type="button" class="btn btn-light-danger me-3">Cancel</button></a>
                                <button type="submit" class="btn switchPrimaryBtn  submit" value="Save">save</button>
                            </div>


                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>



<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script>
    $(document).ready(function() {
        console.log("well");
        $('#basic-form').submit(function(e) {
            e.preventDefault();
            document.getElementById('fileAlert').style.display = "none";

            var file = $('input[type=file]').prop('files')[0];

            if (!file) {

                document.getElementById('fileAlert').style.display = "block";
                document.getElementById('fileAlert').style.color = "red";
                document.getElementById('fileAlert').innerHTML = 'File Is Mandatory*';

                event.preventDefault();
                return false;
            } else {
                document.getElementById('fileAlert').style.display = "none";
            }

            var mime = file.type;
            console.log(mime);

            if (mime != 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet') {
                document.getElementById('fileAlert').style.display = "block";
                document.getElementById('fileAlert').style.color = "red";
                document.getElementById('fileAlert').innerHTML = 'File Only Allowed Excel Format*';

                event.preventDefault();
                return false;
            } else {
                document.getElementById('fileAlert').style.display = "none";
                $(":submit").attr("disabled", true);
            }

            var formData = new FormData($('#basic-form')[0]);
            console.log(formData);
            $.ajax({
                url: "{{ route('bulkUploadStore') }}",
                type: 'ajax',
                method: 'post',
                data: formData,
                processData: false,
                contentType: false,
                success: function(data) {
                    $(":submit").removeAttr("disabled");
                    $('.errorDiv').css('display','none');
                    var errorArray = data.data;
                    console.log(errorArray.length);
                    $('.errorDiv').html('');
                    if (data.result == 'failed') {
                        $('.errorDiv').css('display','block');
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Some Issues Occured In Employee Bulk Upload!'

                        });

                        $.each(errorArray, function(key, value) {
                            console.log(value);

                            $('.errorDiv').append('<span style="color:red">' + value + '</span><br>');
                        });
                    } else {
                        Swal.fire({
                            icon: 'success',
                            title: 'Done',
                            text: 'All Datas Uploaded Successfully!'

                        });
                    }
                },
                error: function() {

                }

            });

        });



    });
</script>

@endsection
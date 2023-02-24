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
                        <li class="breadcrumb-item text-muted"><?php echo $model ? 'Edit' : 'Add'; ?></li>
                        <!--end::Item-->
                    </ul>
                    <!--end::Breadcrumb-->
                </div>
                <!--end::Page title-->

            </div>
        </div>
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <div id="kt_app_content_container" class="app-container container-xxl">
                <div class="card" style="width:900px;margin:auto;">
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
                        <form name="createForm" id="form" class="form" method="post" enctype="multipart/form-data" action="{{ url('employees') }}" pkey="">
                            @csrf
                            <input type="hidden" value="<?php echo $model ? $model->id : ''; ?>" name='id' class="id">
                            <!--end::Input group-->

                            <div class="row g-9 mb-7">
                                <!--begin::Col-->
                                <div class="col-md-6 fv-row">
                                    <!--begin::Label-->
                                    <label class="required fs-6 fw-semibold mb-2">First
                                        Name</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" class="form-control form-control-solid" value="<?php echo $model ? $model->first_name : ''; ?>" placeholder="Enter First Name" name="first_name" autocomplete="off" />
                                    <p id="firstNameAlert" class="notifyAlert"></p>
                                    <!--end::Input-->
                                </div>
                                <!--end::Col-->

                                <!--begin::Col-->
                                <div class="col-md-6 fv-row">
                                    <!--begin::Label-->
                                    <label class="required fs-6 fw-semibold mb-2">Last Name</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" class="form-control form-control-solid" placeholder="Enter Last Name" value="<?php echo $model ? $model->last_name : ''; ?>" name="last_name" autocomplete="off" />

                                    <p id="lastNameAlert" class="notifyAlert"></p>
                                    <!--end::Input-->
                                </div>
                                <!--end::Col-->

                                <!--begin::Col-->
                                <div class="col-md-6 fv-row">
                                    <!--begin::Label-->
                                    <label class="required fs-6 fw-semibold mb-2">Email</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="email" class="form-control form-control-solid email" placeholder="Enter Email" name="email" value="<?php echo $model ? $model->email : ''; ?>" autocomplete="off" />
                                    <p id="emailAlert" class="notifyAlert"></p>
                                    <!--end::Input-->
                                </div>
                                <!--end::Col-->


                                <!--begin::Col-->
                                <div class="col-md-6 fv-row">
                                    <!--begin::Label-->
                                    <label class="required fs-6 fw-semibold mb-2">Mobile</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="number" pattern="/^-?\d+\.?\d*$/" onKeyPress="if(this.value.length==10) return false;" value="<?php echo $model ? $model->mobile : ''; ?>" class="form-control form-control-solid mobile" placeholder="Enter Mobile" name="mobile" autocomplete="off" maxlength="10" />
                                    <p id="mobileAlert" class="notifyAlert"></p>
                                    <!--end::Input-->
                                </div>
                                <!--end::Col-->


                                <!--begin::Col-->
                                <div class="col-md-6 fv-row">
                                    <!--begin::Label-->
                                    <label class="required fs-6 fw-semibold mb-2">Department</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <select class="form-control form-control-solid department" name="department_id">
                                        <option value="">Select</option>
                                        @foreach ($departments as $dept)
                                        <?php
                                        $selectedDept = "";
                                        if ($model) {
                                            $selectedDept = ($model->department_id == $dept['id']) ? "selected" : "";
                                        }
                                        ?>
                                        <option value="<?php echo $dept['id']; ?>" <?php echo $selectedDept; ?>><?php echo $dept['name']; ?>
                                        </option>
                                        @endforeach
                                    </select>
                                    <p id="departmentAlert" class="notifyAlert"></p>
                                    <!--end::Input-->
                                </div>
                                <!--end::Col-->

                                <!--begin::Col-->
                                <div class="col-md-6 fv-row">
                                    <!--begin::Label-->
                                    <label class="required fs-6 fw-semibold mb-2">Designation</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <select class="form-control form-control-solid designation_id" name="designation_id">
                                        <option value="">Select</option>
                                        @foreach ($designation as $des)
                                        <?php
                                        $selectedDesi = "";
                                        if ($model) {
                                            $selectedDesi = ($model->designation_id == $des['id']) ? "selected" : "";
                                        }
                                        ?>
                                        <option value="<?php echo $des['id']; ?>" <?php echo $selectedDesi; ?>>
                                            <?php echo $des['name']; ?>
                                        </option>
                                        @endforeach
                                    </select>
                                    <p id="designationAlert" class="notifyAlert"></p>
                                    <!--end::Input-->
                                </div>
                                <!--end::Col-->

                                <!--begin::Col-->
                                <div class="col-md-6 fv-row">
                                    <!--begin::Label-->
                                    <label class="required fs-6 fw-semibold mb-2">SAP-ID</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" class="form-control form-control-solid sapId" value="<?php echo $model ? $model->sap_id : ''; ?>" placeholder="Enter SAP-ID" name="sap_id" autocomplete="off" />
                                    <p id="sapIdAlert" class="notifyAlert"></p>
                                    <!--end::Input-->
                                </div>
                                <!--end::Col-->

                                <!--begin::Col-->
                                <div class="col-md-3 fv-row">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-semibold mb-2">Profile</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="file" class="form-control form-control-solid" name="profile_image" id="imgShow2" onchange="document.getElementById('blahnew').src = window.URL.createObjectURL(this.files[0])" />
                                    <img id="blahnew" class="picture2" style="display:none;" width="100" height="100" />
                                    <span class="btnAdded1"></span>
                                    <?php
                                    $noImage = 'noimage.png';
                                   
                                    $image = isset($model['profile_image']) ? $model['profile_image'] : $noImage;
                                    ?>
                                    <img src="{{ asset('images/Employee/' . $image) }}" alt="wellone" class="editPic1" width="50" height="50" class="w-50" />

                                    <!--end::Input-->
                                </div>
                                <!--end::Col-->
                                <!--begin::Col-->
                                <div class="col-md-3 fv-row">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-semibold mb-2">Signature</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="file" class="form-control form-control-solid" name="sign_image" id="imgShow" onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])" />
                                    <img id="blah" class="picture" style="display:none;" width="100" height="100" />
                                    <span class="btnAdded"></span>
                                    <?php
                                    $noImage = 'noimage.png';
                                    $image = isset($model['sign_image']) ? $model['sign_image'] : $noImage;
                                    ?>
                                    <img src="{{ asset('images/Employee/' . $image) }}" alt="wellone" class="editPic" width="50" height="50" class="w-50" />
                                    <!--end::Input-->
                                </div>
                                <!--end::Col-->


                                <!--begin::Col-->
                                <div class="col-md-12 fv-row">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-semibold mb-2">Address</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <textarea class="form-control form-control-solid" name="address" rows="4" cols="50"><?php echo $model ? $model->address : ''; ?></textarea>

                                    <!--end::Input-->
                                </div>
                                <!--end::Col-->
                            </div>
                            <div class="text-center pt-15">
                                <button type="reset" class="btn btn-light me-3 reset" data-kt-users-modal-action="cancel" onclick=" document.location.reload();">Reset</button>
                                <a href="{{ route('employees.index') }}">
                                    <button type="button" class="btn btn-light-danger me-3">Cancel</button></a>
                                <button type="button" class="btn btn-primary submit" data-kt-users-modal-action="submit">
                                    <span class="indicator-label" onclick="finalValidation();">Save and Exit</span>
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





<script data-require="jquery@*" data-semver="3.0.0" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.js">
</script>
<script>
    $(document).ready(function() {
        $(".designation_id").select2({
            dropdownParent: $("#form")
        });
        $(".department").select2({
            dropdownParent: $("#form")
        });

        if ($('.id').val()) {
           
            $('.reset').css('display', 'none');
        }
        $("#imgShow").change(function() {
            $('.picture').empty();
            $('#field').remove();
            $('#imgShow').empty();
            $('.picture').removeAttr('style');
            $('.editPic').remove();
            $(".btnAdded").append("<button type='button' id='field'>Remove</button>");
            $("#field").click(function() {
                $('.picture').hide();
                $('#imgShow').empty();
                $('#field').remove();
            });
        });

        $("#imgShow2").change(function() {

            $('.picture2').empty();
            $('#field1').remove();
            $('#imgShow2').empty();
            $('.picture2').removeAttr('style');
            $('.editPic1').remove();
            $(".btnAdded1").append("<button type='button' id='field1'>Remove</button>");
            $("#field1").click(function() {

                $('.picture2').hide();
                $('#imgShow2').empty();
                $('#field1').remove();
            });

        });
        // $('.submitBtn').attr('disabled', 'true');
        // if ($('.id').val()) {
        //     $('.submitBtn').removeAttr('disabled');
        // }

        $(".email").on('input', function() {
            var pkey = $('.id').val();


            var email = $(this).val();
            $('.submit').prop('disabled', true);

            if (email) {
                getValidationResult('email', email, pkey);
            }
        });
        $(".mobile").on('input', function() {
            var mobile = $(this).val();
            var pkey = $('.id').val();
            $('.submit').prop('disabled', true);

            if (mobile) {
                getValidationResult('mobile', mobile, pkey);
            }
        });
        $(".sapId").on('input', function() {
            var sapId = $(this).val();
            var pkey = $('.id').val();
            $('.submit').prop('disabled', true);

            if (sapId) {
                getValidationResult('sapId', sapId, pkey);
            }
        });
    });

    function finalValidation1() {

        // to each unchecked checkbox          
        return validateFormCreate();
        console.log("damn");
        $(this).find('input[type=checkbox]:not(:checked)').prop('checked', true).val(0);
    }

    function getValidationResult(fieldname, fieldData, pkey) {

        $.ajax({
            url: "{{ route('getEmployeeDetailByParams') }}",
            type: 'ajax',
            method: 'post',
            data: {
                "_token": "{{ csrf_token() }}",
                fieldname: fieldname,
                fieldData: fieldData,
                pkey: pkey,
            },
            success: function(result) {
                var data = JSON.parse(result);
                console.log(data);
                if (data) {
                    if (data) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'This ' + fieldname + ' AllReady In Employee!'

                        });
                        $('.submit').prop('disabled', true);
                        $("." + fieldname + "").val("");
                    }
                } else {
                    $('.submit').prop('disabled', false);
                }
            }
        });
    }
    $(document).on('input', '.department', function() {
        if ($(this).val()) {
            $('.submitBtn').removeAttr('disabled');
        } else {
            $('.submitBtn').attr('disabled', 'true');
        }
    });

    function finalValidation() {
        var firstname = document.createForm.first_name;
        var lastname = document.createForm.last_name;
        var email = document.createForm.email;
        var mobile = document.createForm.mobile;
        var department_id = document.createForm.department_id;
        var designation_id = document.createForm.designation_id;
        var sap_id = document.createForm.sap_id;

        var firstNameError = validateField('firstNameAlert', 'First Name', firstname.value);
        var lastNameError = validateField('lastNameAlert', 'Last Name', lastname.value);
        var emailError = validateField('emailAlert', 'Email', email.value);
        var mobileError = validateField('mobileAlert', 'Mobile', mobile.value);
        var departmentError = validateField('departmentAlert', 'Department', department_id.value);
        var designationError = validateField('designationAlert', 'Designation', designation_id.value);

        var sapidError = validateField('sapIdAlert', 'Sap Id', sap_id.value);


        console.log(firstNameError);
        console.log(lastNameError);
        console.log(emailError);
        console.log(mobileError);
        console.log(departmentError);
        console.log(designationError);
        console.log(sapidError);



        if (firstNameError && lastNameError && emailError && mobileError && departmentError && designationError &&
            sapidError) {

            $(".form").submit();
            return true;
        } else {
            console.log("Not well");
            return false;
        }
        return false;
    }

    function validateField(alertName, fieldname, fieldValue) {

        if (fieldValue == "" || fieldValue == null) {
            document.getElementById(alertName).style.display = "block";
            document.getElementById(alertName).style.color = "red";
            document.getElementById(alertName).innerHTML = fieldname + ' Is Mandatory*';
            return false;
        }
        if (fieldname == "Mobile") {
            if (fieldValue != "" || fieldValue != null) {
                if (fieldValue.length < 8) {
                    document.getElementById(alertName).style.display = "block";
                    document.getElementById(alertName).style.color = "red";
                    document.getElementById(alertName).innerHTML = fieldname + ' Is Minimum 8 Digit*';
                    return false;
                }

            }
        }
        document.getElementById(alertName).style.display = "none";
        return true;
    }

    function deptValidation() {

        //  Swal.fire('Any fool can use a computer');
        var name = $('.department').val();
        var id = $('.id').val();
        $.ajax({
            url: "{{ url('departmentValidation') }}",
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
                    document.getElementById(alertName).innerHTML = 'Name is Allready Exists*';
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
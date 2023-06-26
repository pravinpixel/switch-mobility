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
                        <form name="createForm" id="form" class="form" method="post" enctype="multipart/form-data">
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
                                    <input type="text" class="form-control form-control-solid first_name" value="<?php echo $model ? $model->first_name : ''; ?>" placeholder="Enter First Name" name="first_name" autocomplete="off" />
                                    <p id="firstNameAlert" class="notifyAlert"></p>
                                    <!--end::Input-->
                                </div>
                                <!--end::Col-->

                                <!--begin::Col-->
                                <div class="col-md-3 fv-row">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-semibold mb-2">Middle Name</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" class="form-control form-control-solid middle_name" placeholder="Enter Middle Name" value="<?php echo $model ? $model->middle_name : ''; ?>" name="middle_name" autocomplete="off" />


                                    <!--end::Input-->
                                </div>
                                <!--end::Col-->
                                <!--begin::Col-->
                                <div class="col-md-3 fv-row">
                                    <!--begin::Label-->
                                    <label class="required fs-6 fw-semibold mb-2">Last Name</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" class="form-control form-control-solid last_name" placeholder="Enter Last Name" value="<?php echo $model ? $model->last_name : ''; ?>" name="last_name" autocomplete="off" />

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
                                    <p id="emailAlert" class="notifyAlert emailAlert" dataAdded=""></p>
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
                                    <p id="mobileAlert" class="notifyAlert mobileAlert"></p>
                                    <!--end::Input-->
                                </div>
                                <!--end::Col-->


                                <!--begin::Col-->
                                <div class="col-md-6 fv-row">
                                    <!--begin::Label-->
                                    <label class="required fs-6 fw-semibold mb-2">Department</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <select class="form-control form-control-solid department deptAndDesg" name="department_id">
                                        <option value="">Select</option>
                                        @foreach ($departments as $dept)
                                        <?php
                                        $selectedDept = '';
                                        if ($model) {
                                            $selectedDept = $model->department_id == $dept['id'] ? 'selected' : '';
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
                                    <select class="form-control form-control-solid designation_id deptAndDesg" name="designation_id">
                                        <option value="">Select</option>
                                        @foreach ($designation as $des)
                                        <?php
                                        $selectedDesi = '';
                                        if ($model) {
                                            $selectedDesi = $model->designation_id == $des['id'] ? 'selected' : '';
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
                                    <p id="sapIdAlert" class="notifyAlert sapIdAlert"></p>
                                    <!--end::Input-->
                                </div>
                                <!--end::Col-->

                                <!--begin::Col-->
                                <div class="col-md-3 fv-row">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-semibold mb-2">Profile Photo</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="file" class="form-control form-control-solid" name="profile_image" id="imageShow" onchange="document.getElementById('blahnew').src = window.URL.createObjectURL(this.files[0])" />
                                    <img id="blahnew" class="profilePic" style="display:none;" width="100" height="100" />
                                    <span class="removebtn"></span>
                                    <?php
                                    if ($model) {
                                        $noPic = 'noimage.png';
                                        $profilePic = isset($model['profile_image']) ? $model['profile_image'] : $noPic;

                                        $updatePic = '<img src="/images/Employee/' . $profilePic . '" class="editPic1" width="50" height="50" class="w-50" />';
                                    } else {
                                        $profilePic = "";
                                        $updatePic = '<img src="" style="display:none;" class="editPic1" width="50" height="50" class="w-50" />';
                                    }

                                    ?>
                                    <img src="{{ asset('images') . '/Employee/' . $profilePic }}" class="editPic1" width="50" height="50" class="w-50">
                                    <!--end::Input-->
                                </div>
                                <!--end::Col-->
                                <!--begin::Col-->
                                <div class="col-md-3 fv-row">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-semibold mb-2">Signature Photo</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="file" class="form-control form-control-solid" name="sign_image" id="imgShow" onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])" />
                                    <img id="blah" class="picture" style="display:none;" width="100" height="100" />
                                    <span class="btnAdded"></span>
                                    <?php
                                    if ($model) {
                                        $noImage = 'noimage.png';
                                        $image = isset($model['sign_image']) ? $model['sign_image'] : $noImage;
                                        $pic = $image;
                                    } else {
                                        $pic = '';
                                    }

                                    ?>
                                    <img src="{{ asset('images') . '/Employee/' . $pic }}" class="editPic" width="50" height="50" class="w-50">
                                    <!--end::Input-->
                                </div>
                                <!--end::Col-->


                                <!--begin::Col-->
                                <div class="col-md-12 fv-row">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-semibold mb-2">Official Communication Address</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <textarea class="form-control form-control-solid" name="address" rows="4" cols="50"><?php echo $model ? $model->address : ''; ?></textarea>

                                    <!--end::Input-->
                                </div>
                                <!--end::Col-->
                            </div>
                            <div class="text-center pt-15">
                                <button type="reset" class="btn btn-light me-3 reset" data-kt-users-modal-action="cancel">Reset</button>
                                <a href="{{ route('employees.index') }}">
                                    <button type="button" class="btn btn-light-danger me-3">Cancel</button></a>
                                <button type="submit" class="btn switchPrimaryBtn  submit" data-kt-users-modal-action="submit">
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





<script data-require="jquery@*" data-semver="3.0.0" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.js">
</script>
<script>
    $(document).ready(function() {
        $('.form').submit(function(e) {
            e.preventDefault(); // Prevent normal form submission

            // Serialize form data
            var formData = $(this).serialize();
            var formresult = finalValidation();
            console.log(formresult);

            // Send Ajax request
            if (formresult == true) {
                $.ajax({
                    url: '{{ route("employees.store") }}', // Replace with your Laravel route URL
                    method: 'POST',
                    data: formData,
                    success: function(response) {
                       
                        if (response.status == "success") {
                            let url = "{{ url('employees') }}";
                            document.location.href = url;
                        } else {
                            var datas = response.errors;
                            // Handle the response from the server
                            console.log(datas);
                            for (var i = 0; i < datas.length; i++) {
                                console.log("resDatas " + datas[i].alertField);
                                raiseAlert(datas[i].alertField, datas[i].name, datas[i].type);
                            }
                        }
                    },
                    error: function(error) {
                        // Handle any errors that occur during the Ajax request
                        console.log(error);
                    }
                });
            }
        });
    });

    function formValidation() {
        var firstName = $('.first_name').val();
        var lastName = $('.last_name').val();
        var email = $('.email').val();
        var mobile = $('.mobile').val();
        var department = $('.department').val();
        var designation = $('.designation_id').val();
        var sapId = $('.sapId').val();

console.log("formvalidation");
        if (!firstName) {

            raiseAlert('firstNameAlert', 'First Name', 'Mandate');

        } else {
            document.getElementById('firstNameAlert').style.display = "none";
        }

        if (!lastName) {

            raiseAlert('lastNameAlert', 'Last Name', 'Mandate');

        } else {
            document.getElementById('lastNameAlert').style.display = "none";
        }

        document.getElementById('emailAlert').style.display = "none";
        var regex = /^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/;
        var res = regex.test(email);
        if (!email) {

            raiseAlert('emailAlert', 'Email', 'Mandate');

        } else if (!res) {
            raiseAlert('emailAlert', 'Email', 'Incorrect');
        } else {
            document.getElementById('emailAlert').style.display = "none";
        }

        if (!mobile) {

            raiseAlert('mobileAlert', 'Mobile Name', 'Mandate');

        } else if (mobile.length < 10) {
            document.getElementById('mobileAlert').style.display = "block";
            document.getElementById('mobileAlert').style.color = "red";
            document.getElementById('mobileAlert').innerHTML = 'Mobile No Is Minimum 10 Digit*';
        } else {
            document.getElementById('mobileAlert').style.display = "none";
        }

        if (!department) {

            raiseAlert('departmentAlert', 'Department', 'Mandate');

        } else {
            document.getElementById('departmentAlert').style.display = "none";
        }
        if (!designation) {


            raiseAlert('designationAlert', 'Designation', 'Mandate');

        } else {
            document.getElementById('designationAlert').style.display = "none";
        }
        if (!sapId) {

            raiseAlert('sapIdAlert', 'SapId', 'Mandate');

        } else {
            document.getElementById('sapIdAlert').style.display = "none";
        }


        if (firstName && lastName && email && mobile && department && designation && sapId) {
            console.log("true");
            return true;
        } else {
            console.log("false");
            return false;
        }


    }
    $(document).ready(function() {


        $(".designation_id").select2({
            dropdownParent: $("#form")
        });
        $(".department").select2({
            dropdownParent: $("#form")
        });
        $('.reset').on('click', function() {
            $('.deptAndDesg').val("").trigger('change');
            document.getElementById("form").reset();

            $('.profilePic').hide();
            $('#imageShow').val('');
            $('#closeBtn').remove();
            $('.picture').hide();

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
                $('#imgShow').val('');
                $('#field').remove();
            });
        });

        $("#imageShow").change(function() {

            $('.profilePic').empty();
            $('#closeBtn').remove();
            $('#imageShow').empty();
            $('.profilePic').removeAttr('style');
            $('.editPic1').remove();
            $(".removebtn").append("<button type='button' id='closeBtn'>Remove</button>");
            $("#closeBtn").click(function() {

                $('.profilePic').hide();
                $('#imageShow').val('');
                $('#closeBtn').remove();
            });

        });
        // $('.submitBtn').attr('disabled', 'true');
        // if ($('.id').val()) {
        //     $('.submitBtn').removeAttr('disabled');
        // }

        $(".email").on('input', function() {
            var pkey = $('.id').val();


            var email = $(this).val();

            var regex = /^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/;
            var res = regex.test(email);

            if (res) {
                getValidationResult('email', email);
            }
        });
        $(".mobile").on('input', function() {
            var mobile = $(this).val();
            var pkey = $('.id').val();


            if (mobile) {
                getValidationResult('mobile', mobile);
            }
        });
        $(".sapId1").on('input', function() {
            var sapId1 = $(this).val();
            sapIdChecking(sapId1);
        });
    });

    function sapIdChecking(sapId1) {
        var pkey = $('.id').val();
        $('.submit').prop('disabled', true);

        if (sapId1) {
            getValidationResult('sapId', sapId1);
        }
    }

    function finalValidation1() {
        // to each unchecked checkbox          
        return validateFormCreate();
        console.log("damn");
        $(this).find('input[type=checkbox]:not(:checked)').prop('checked', true).val(0);
    }

    function getValidationResult(fieldname, fieldData) {
        var pkey = $('.id').val();
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

                    return 1;

                    // if (data) {
                    //     Swal.fire({
                    //         icon: 'error',
                    //         title: 'Oops...',
                    //         text: 'This ' + fieldname + ' Already In Employee!'

                    //     });
                    //     $('.submit').prop('disabled', true);
                    //     if (fieldname == 'sapId') {
                    //         $("." + fieldname + "").val("");
                    //     }
                    // }
                } else {
                    // $('.submit').prop('disabled', false);
                    return 0;
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



    function nameValidation() {
        var firstName = $('.first_name').val();
        var lastName = $('.last_name').val();
        var email = $('.email').val();
        var mobile = $('.mobile').val();
        var department = $('.department').val();
        var designation = $('.designation_id').val();
        var sapId = $('.sapId').val();


        if (!firstName) {

            raiseAlert('firstNameAlert', 'First Name', 'Mandate');

        } else {
            document.getElementById('firstNameAlert').style.display = "none";
        }

        if (!lastName) {

            raiseAlert('lastNameAlert', 'Last Name', 'Mandate');

        } else {
            document.getElementById('lastNameAlert').style.display = "none";
        }

        if (!email) {

            raiseAlert('emailAlert', 'Email', 'Mandate');

        } else {
            document.getElementById('emailAlert').style.display = "none";
        }

        if (!mobile) {

            raiseAlert('mobileAlert', 'Mobile Name', 'Mandate');

        } else {
            document.getElementById('mobileAlert').style.display = "none";
        }

        if (!department) {

            raiseAlert('departmentAlert', 'Department', 'Mandate');

        } else {
            document.getElementById('departmentAlert').style.display = "none";
        }
        if (!designation) {


            raiseAlert('designationAlert', 'Designation', 'Mandate');

        } else {
            document.getElementById('designationAlert').style.display = "none";
        }
        if (!sapId) {

            raiseAlert('sapIdAlert', 'SapId', 'Mandate');

        } else {
            document.getElementById('sapIdAlert').style.display = "none";
        }


        if (firstName && lastName && email && mobile && department && designation && sapId) {
            console.log("true");
            return true;
        } else {
            console.log("false");
            return false;
        }


    }

    function deptAndDescValidation() {
        var department = $('.department').val();
        var designation = $('.designation_id').val();

        if (!department) {

            raiseAlert('departmentAlert', 'Department', 'Mandate');

        } else {
            document.getElementById('departmentAlert').style.display = "none";
        }
        if (!designation) {


            raiseAlert('designationAlert', 'Designation', 'Mandate');

        } else {
            document.getElementById('designationAlert').style.display = "none";
        }
        if (department && designation) {
            return 1;
        } else {
            return 0;
        }


    }

    function sapidValidation() {
        var sapId = $('.sapId').val();
console.log("well");
        document.getElementById('sapIdAlert').style.display = "none";
        if (!sapId) {

            raiseAlert('sapIdAlert', 'SapId', 'Mandate');
        } else {
            console.log('Correct Format');

            $.ajax({
                url: "{{ route('getEmployeeDetailByParams') }}",
                type: 'ajax',
                method: 'post',
                data: {
                    "_token": "{{ csrf_token() }}",
                    fieldname: 'sapId',
                    fieldData: sapId,
                    pkey: $('.id').val(),
                },
                success: function(result) {
                    var data = JSON.parse(result);
                    console.log(data);

                    if (data) {
                        raiseAlert('sapIdAlert', 'SapId', '');
                    } else {
                        document.getElementById('sapIdAlert').style.display = "none";
                    }
                }
            });


        }

        // Get the element with the desired class
        var element = document.querySelector('.sapIdAlert');
        console.log("element" + element);

        // Get the computed style of the element
        var computedStyle = window.getComputedStyle(element);

        // Check the display status
        var displayStatus = computedStyle.getPropertyValue('display');
        console.log("displayStatus" + displayStatus);
        // Check if the element is visible or hidden
        if (displayStatus == 'none') {
            console.log('The element is hidden.');
            return 1;
        } else {
            console.log('The element is visible.');
            return 0;
        }
    }

    function emailValidation() {
        var email = $('.email').val();
        console.log(email);
        document.getElementById('emailAlert').style.display = "none";
        var regex = /^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/;
        var res = regex.test(email);

        if (!email) {
            console.log('Email Empty');
            raiseAlert('emailAlert', 'Email', 'Mandate');
            $('#emailAlert').attr('dataAdded', "error");
        } else if (!res) {
            raiseAlert('emailAlert', 'Email', 'Incorrect');
            $('#emailAlert').attr('dataAdded', "error");
            console.log('In-Correct Format');
        } else {
            console.log('Correct Format');

            $.ajax({
                url: "{{ route('getEmployeeDetailByParams') }}",
                type: 'ajax',
                method: 'post',
                data: {
                    "_token": "{{ csrf_token() }}",
                    fieldname: 'email',
                    fieldData: email,
                    pkey: $('.id').val(),
                },
                success: function(result) {
                    var data = JSON.parse(result);
                    console.log(data);

                    if (data) {
                        raiseAlert('emailAlert', 'Email', '');
                        $('#emailAlert').attr('dataAdded', "error");
                    } else {
                        document.getElementById('emailAlert').style.display = "none";
                        $('#emailAlert').attr('dataAdded', "");
                    }
                    // var des = checkresult();
                }
            });


        }
        console.log($('#emailAlert').attr('dataAdded'));
        // // Get the element with the desired class
        // var element = document.querySelector('.emailAlert');
        // console.log("element" + element);

        // // Get the computed style of the element
        // var computedStyle = window.getComputedStyle(element);

        // // Check the display status
        // var displayStatus = computedStyle.getPropertyValue('display');
        // console.log("displayStatus" + displayStatus);
        // // Check if the element is visible or hidden
        // if (displayStatus == 'none') {
        //     console.log('The element is hidden.');
        //     return 1;
        // } else {
        //     console.log('The element is visible.');
        //     return 0;
        // }
        if ($('#emailAlert').is(':visible')) {
            console.log('The element with class "your-class" is currently visible.');
        } else {
            console.log('The element with class "your-class" is currently hidden.');
        }
        // var des = checkresult();
    }

    function checkresult() {
        console.log("emailAlert " + $('#emailAlert').attr('dataAdded'));
    }

    function mobileValidation() {
        var mobile = $('.mobile').val();
        document.getElementById('mobileAlert').style.display = "none";
        if (!mobile) {
            raiseAlert('mobileAlert', 'Mobile', 'Mandate');
        } else if (mobile.length < 10) {
            document.getElementById('mobileAlert').style.display = "block";
            document.getElementById('mobileAlert').style.color = "red";
            document.getElementById('mobileAlert').innerHTML = fieldname + ' Is Minimum 10 Digit*';
        } else {
            $.ajax({
                url: "{{ route('getEmployeeDetailByParams') }}",
                type: 'ajax',
                method: 'post',
                data: {
                    "_token": "{{ csrf_token() }}",
                    fieldname: 'mobile',
                    fieldData: mobile,
                    pkey: $('.id').val(),
                },
                success: function(result) {
                    var data = JSON.parse(result);
                    console.log(data);

                    if (data) {
                        raiseAlert('mobileAlert', 'Mobile', '');
                    } else {
                        document.getElementById('mobileAlert').style.display = "none";
                    }
                }
            });

        }

        // Get the element with the desired class
        var element = document.querySelector('.mobileAlert');
        console.log("element" + element);

        // Get the computed style of the element
        var computedStyle = window.getComputedStyle(element);

        // Check the display status
        var displayStatus = computedStyle.getPropertyValue('display');
        console.log("displayStatus" + displayStatus);
        // Check if the element is visible or hidden
        if (displayStatus == 'none') {
            console.log('The element is hidden.');
            return 1;
        } else {
            console.log('The element is visible.');
            return 0;
        }
    }

    function getValidationResult(fieldname, fieldData) {
        var pkey = $('.id').val();
        var result = "";
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

                    result = 1;
                    console.log("if check");
                    // if (data) {
                    //     Swal.fire({
                    //         icon: 'error',
                    //         title: 'Oops...',
                    //         text: 'This ' + fieldname + ' Already In Employee!'

                    //     });
                    //     $('.submit').prop('disabled', true);
                    //     if (fieldname == 'sapId') {
                    //         $("." + fieldname + "").val("");
                    //     }
                    // }
                } else {
                    // $('.submit').prop('disabled', false);
                    result = 0;
                    console.log("else check");
                }
            }
        });
        console.log("final res check");
        console.log(result);
        return result;
    }

    function raiseAlert(alertfieldIdName, alertField, alertType) {
        document.getElementById(alertfieldIdName).style.display = "block";
        document.getElementById(alertfieldIdName).style.color = "red";
        if (alertType == "Mandate") {
            document.getElementById(alertfieldIdName).innerHTML = alertField + ' Is Mandatory*';
        } else if (alertType == "Incorrect") {
            document.getElementById(alertfieldIdName).innerHTML = alertField + ' Is Incorrect Format*';
        } else {
            document.getElementById(alertfieldIdName).innerHTML = alertField + ' Is Exist*';
        }


    }

    function finalValidation() {

        console.log("well");
        var namevalidation = nameValidation();
        var emailvalidation = emailValidation();
        var mobilevalidation = mobileValidation();
        var deptAndDescvalidation = deptAndDescValidation();
        var sapIdvalidation = sapidValidation();
        // console.log("checkresult");
        // console.log(checkresult());
        if (namevalidation && emailvalidation && mobilevalidation && deptAndDescvalidation && sapIdvalidation) {

            $(".form").submit();
            $('.submit').prop('disabled', true);

            return true;
        }

        console.log(namevalidation);
        console.log(emailvalidation);
        console.log(mobilevalidation);
        console.log(deptAndDescvalidation);
        console.log(sapIdvalidation);
    }

    function finalValidation1() {

        var firstname = document.createForm.first_name;
        var lastname = document.createForm.last_name;
        var email = document.createForm.email;
        var mobile = document.createForm.mobile;
        var department_id = document.createForm.department_id;
        var designation_id = document.createForm.designation_id;
        var sap_id = document.createForm.sap_id;
        sapIdChecking(sap_id);
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
            $('.submit').prop('disabled', true);

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
                if (fieldValue.length < 10) {
                    document.getElementById(alertName).style.display = "block";
                    document.getElementById(alertName).style.color = "red";
                    document.getElementById(alertName).innerHTML = fieldname + ' Is Minimum 10 Digit*';
                    return false;
                }

            }
        }

        if (fieldname == "Email") {
            var regex = /^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/;
            var res = regex.test(fieldValue);

            if (!res) {
                document.getElementById(alertName).style.display = "block";
                document.getElementById(alertName).style.color = "red";
                document.getElementById(alertName).innerHTML = fieldname + ' Is InCorrect*';
                return false;
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
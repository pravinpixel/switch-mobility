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

                    <!--end::Card header-->
                    <!--begin::Card body-->
                    <div class="card-body">
                        <div class="" style="">
                            <div class="row g-8">
                                <!--begin::Col-->
                                <div class="col-md-3">
                                    <label class="fs-6 form-label fw-bold text-dark "> Department </label>
                                    <select class="form-select form-select-solid filterDeptAndDes" data-kt-select2="true" data-placeholder="Department" data-allow-clear="true" id="deptFilter">
                                        <option></option>
                                        @foreach ($departments as $department)
                                        <option value="{{ $department['id'] }}">
                                            {{ $department['name'] }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <label class="fs-6 form-label fw-bold text-dark ">Designation </label>
                                    <select class="form-select form-select-solid filterDeptAndDes" name="project_code_name" data-kt-select2="true" data-placeholder="Desgination" data-allow-clear="true" id="designationFilter">
                                        <option></option>
                                        @foreach ($designation as $des)
                                        <option value="{{ $des['id'] }}">
                                            {{ $des['name'] }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-1">
                                    <label class="fs-6 fw-semibold mb-2">&nbsp;</label>
                                    <span class="btn btn-warning " onclick="resetFilter()">Reset</span>
                                </div>
                                @if (auth()->user()->is_super_admin == 1 ||
                                auth()->user()->can('employee-create'))
                                <div class="col-md-1">
                                    <a href="{{url('employees/create')}}">
                                        <label class="fs-6 fw-semibold mb-2">&nbsp;</label>
                                        <span class="btn switchPrimaryBtn  ">+Add</span>
                                    </a>
                                </div>
                                @endif
                                <div class="col-md-1">
                                    <a href="{{url('bulkUploadCreate')}}">
                                        <label class="fs-6 fw-semibold mb-2">&nbsp;</label>
                                        <span class="btn btn-success ">Import</span>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!--begin::Table-->
                        <table class="table align-middle table-row-bordered fs-6 gy-5" id="service_table">
                            <!--begin::Table head-->
                            <thead>
                                <!--begin::Table row-->
                                <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">

                                    <th class="min-w-125px">Name</th>
                                    <th class="min-w-125px">SAP-ID</th>
                                    <th class="min-w-125px">Mobile</th>
                                    <th class="min-w-125px">Department</th>
                                    <th class="min-w-125px">Designation</th>
                                    <th class="min-w-50px">Status</th>

                                    <th class="text-center min-w-125px">Actions</th>
                                </tr>
                                <!--end::Table row-->
                            </thead>
                            <!--end::Table head-->
                            <!--begin::Table body-->
                            <tbody class="text-gray-600 fw-semibold">
                                <!--begin::Table row-->
                                @foreach ($employee_all as $key => $d)
                                <tr>
                                    <!--begin::Checkbox-->

                                    <!--end::Checkbox-->
                                    <!--begin::User=-->

                                    <?php if ($d->profile_image) {
                                        $pImage = $d->profile_image;
                                    } else {
                                        $pImage = "noimage.png";
                                    } ?>

                                    <td class="">
                                        <!--begin:: Avatar -->
                                        <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                            <a href="javascript:void(0);">
                                                <div class="symbol-label">
                                                    <img src="{{ asset('images/Employee/' . $pImage) }}" alt="" width="50" height="50" class="w-100" />
                                                </div>
                                            </a>
                                        </div>
                                        <!--end::Avatar-->
                                        <!--begin::User details-->
                                        <div class="d-flex flex-column">
                                            <a href="javascript:void(0);" class="text-gray-800 text-hover-primary mb-1"><?php echo $d->first_name . ' ' . $d->last_name; ?></a>
                                            <span>Email:{{ $d->email }}</span>
                                        </div>
                                        <!--begin::User details-->
                                    </td>
                                    <td>{{ $d->sap_id }}</td>
                                    <td>{{ $d->mobile }}</td>
                                    <td>{{ $d->department_name }}</td>
                                    <td>{{ $d->designation_name }}</td>
                                    <td>
                                        <label class="switch">
                                            <input type="checkbox" data-id="{{ $d->id }}" value="" class="status" <?php echo $d->is_active == 1 ? 'checked' : ''; ?>>
                                            <span class="slider round"></span>
                                        </label>

                                    </td>
                                    <td>
                                        <div class="d-flex my-3 ms-9">
                                            <!--begin::Edit-->
                                            @if (auth()->user()->is_super_admin == 1 ||
                                            auth()->user()->can('employee-edit'))
                                            <a href="{{route('employees.edit',$d->id)}}" style="display:inline;cursor: pointer;" id="{{ $d->id }}" title="Edit Employee"><i class="fa-solid fa-pen" style="color:orange"></i></a>
                                            @endif
                                            <!--end::Edit-->
                                            @if (auth()->user()->is_super_admin == 1 ||
                                            auth()->user()->can('employee-delete'))
                                            <div onclick="delete_item(<?php echo $d->id; ?>);" style="display:inline;cursor: pointer; margin-left: 10px;" id="{{$d->id }}" class="" title="Delete Employee"><i class="fa-solid fa-trash" style="color:red"></i></div>
                                            @endif
                                            <!--end::Delete-->
                                            <!--begin::More-->


                                            <!--end::More-->
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

<!-- Edit Model -->

@endsection
<script data-require="jquery@*" data-semver="3.0.0" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.js">
</script>
<script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.js"></script>
<script>
    $(document).ready(function() {
        $(".designation_id").select2({
            dropdownParent: $("#designation_form1")
        });
        $(".department").select2({
            dropdownParent: $("#designation_form1")
        });
        // on form submit
        $("#designation_form1").on('submit', function() {

            // to each unchecked checkbox          
            return validateFormCreate();
            $(this).find('input[type=checkbox]:not(:checked)').prop('checked', true).val(0);
        });
        $(".email").on('input', function() {
            var pkey = $(this).closest('form').attr('pkey');


            var email = $(this).val();
            $('.submit').prop('disabled', true);

            if (email) {
                getValidationResult('email', email, pkey);
            }
        });
        $(".mobile").on('input', function() {
            var mobile = $(this).val();
            var pkey = $(this).closest('form').attr('pkey');
            $('.submit').prop('disabled', true);

            if (mobile) {
                getValidationResult('mobile', mobile, pkey);
            }
        });
        $(".sapId").on('input', function() {
            var sapId = $(this).val();
            var pkey = $(this).closest('form').attr('pkey');
            $('.submit').prop('disabled', true);

            if (sapId) {
                getValidationResult('sapId', sapId, pkey);
            }
        });
    })

    function resetFilter() {
        $(".filterDeptAndDes").val("").trigger('change');
        $('.tableSearch').val("");
    }

    function validateFormCreate() {
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

            console.log("Good");
            return true;
        } else {
            console.log("Not well");
            return false;
        }
        return false;
    }

    function validateFormEdit() {

        var firstname = $('.editFirstName').val();

        var lastname1 = $('.editLastName1').val();
        if (lastname1) {
            console.log("Yes");
        } else {
            console.log("no");
        }
        console.log("lastname > " + lastname1);
        var email = $('.editEmail').val();
        var mobile = $('.editMobile').val();
        var department_id = $('.editDepartment').val();
        var designation_id = $('.editDesignation').val();
        console.log("designation_id > " + designation_id);
        var sap_id = $('.editSapId').val();

        var firstNameError = validateField('firstNameAlert', 'First Name', firstname);
        var lastNameError = validateField('lastNameAlert', 'Last Name', lastname1);
        var emailError = validateField('emailAlert', 'Email', email);
        var mobileError = validateField('mobileAlert', 'Mobile', mobile);
        var departmentError = validateField('departmentAlert', 'Department', department_id);
        var designationError = validateField('designationAlert', 'Designation', designation_id);

        var sapidError = validateField('sapIdAlert', 'Sap Id', sap_id);


        console.log(firstNameError);
        console.log(lastNameError);
        console.log(emailError);
        console.log(mobileError);
        console.log(departmentError);
        console.log(designationError);
        console.log(sapidError);



        if (firstNameError && lastNameError && emailError && mobileError && departmentError && designationError &&
            sapidError) {

            console.log("Good");
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
        document.getElementById(alertName).style.display = "none";
        return true;
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
    $(document).ready(
        function() {


            $('.emplySelect').on('change', function() {
                var emplyId = $(this).children("option:selected").val();
                $.ajax({
                    url: "{{ route('employeeDetailById') }}",
                    type: 'ajax',
                    method: 'post',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        id: emplyId,
                    },
                    success: function(data) {

                        table.clear().draw();
                        $.each(data, function(key, val) {
                            var id = val.id;
                            var sapId = val.sap_id;
                            var mobile = val.mobile;
                            var dept = val.deptName;
                            var desg = val.desgName;
                            var email = val.email;
                            var firstName = val.first_name;
                            var lastName = val.last_name;
                            var activeStatus = (val.is_active == 1) ? "checked" : "";
                            console.log(activeStatus);
                            var pic = val.profile_image;
                            var editurl = '{{ route("employees.edit", ":id") }}';
                            editurl = editurl.replace(':id', id);

                            var editBtn = (
                                '<a href="' + editurl + '" style="display:inline;cursor: pointer;" title="Edit Employeee"><i class="fa-solid fa-pen" style="color:orange"></i>></a>'
                            );
                            var deleteBtn = (
                                '<div  onclick="delete_item(' + id + ');" style="display:inline;cursor: pointer;margin-left: 10px;" title="Delete Employeee"><i class="fa-solid fa-trash" style="color:red"></i>></div>'
                            );


                            var Action = (editBtn +
                                deleteBtn
                            );
                            var status = val.is_active;
                            var person = pic + "<br>" + firstName + " " + lastName +
                                "<br>" + "Email:" + email;
                            var result = (
                                '<label class="switch"><input type="checkbox" data-id="' +
                                id + '" class="status" ' + activeStatus +
                                '>  <span class="slider round"></span></label>');

                            table.row.add([person, sapId, mobile, dept, desg, result,
                                Action
                            ]).draw();
                        });
                    },
                    error: function() {
                        $("#otp_error").text("Update Error");
                    }

                });
            });
            // Department & Desgination
            $('.filterDeptAndDes').on('change', function() {
                var table = $('#service_table').DataTable();
                var deptId = $('#deptFilter').val();
                var descId = $("#designationFilter").val();
                $('.tableSearch').val("");

                $.ajax({
                    url: "{{ route('employeeDetailByDesDept') }}",
                    type: 'ajax',
                    method: 'post',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        descId: descId,
                        deptId: deptId,
                    },
                    success: function(data) {

                        table.clear().draw();
                        $.each(data, function(key, val) {
                            var id = val.id;
                            var sapId = val.sap_id;
                            var mobile = val.mobile;
                            var dept = val.deptName;
                            var desg = val.desgName;
                            var email = val.email;
                            var firstName = val.first_name;
                            var lastName = val.last_name;
                            var activeStatus = (val.is_active == 1) ? "checked" : "";

                            var pic = (val.profile_image) ? val.profile_image : 'noimage.png';
                            var folder = "images/Employee/";
                            folder += pic;

                            var firsttd =
                                '<div class="symbol symbol-circle symbol-50px overflow-hidden me-3">';
                            firsttd += '<a href="javascript:void(0);">';
                            firsttd += '<div class="symbol-label">';
                            firsttd +=
                                '<img src=' + folder + ' alt="' + firstName + '" width="50" height="50" class="w-100" />';
                            firsttd += ' </div>';
                            firsttd += '</a>';
                            firsttd += '</div>';
                            firsttd += '<div class="d-flex flex-column">';
                            firsttd += '<a href="javascript:void(0);"class="text-gray-800 text-hover-primary mb-1" style="position:relative;left:59px;bottom:43px;">' + firstName + ' ' + lastName + '</a>';
                            firsttd += ' <span style="position:relative;left:59px;bottom:43px;">Email:' + email + '</span>';
                            firsttd += ' </div>';

                            var editurl = '{{ route("employees.edit", ":id") }}';
                            editurl = editurl.replace(':id', id);
                            var editBtn = (
                                '<a href="' + editurl + '" style="display:inline;cursor: pointer;" title="Edit Employeee"><i class="fa-solid fa-pen" style="color:orange"></i></a>'
                            );
                            var deleteBtn = (
                                '<div  onclick="delete_item(' + id + ');" style="display:inline;cursor: pointer;margin-left: 10px;" title="Delete Employeee"><i class="fa-solid fa-trash" style="color:red"></i></div>'
                            );


                            var Action = (editBtn +
                                deleteBtn
                            );
                            var status = val.is_active;
                            var person = pic + "<br>" + firstName + " " + lastName +
                                "<br>" + "Email:" + email;
                            var result = (
                                '<label class="switch"><input type="checkbox" data-id="' +
                                id + '" class="status" ' + activeStatus +
                                '>  <span class="slider round"></span></label>');

                            table.row.add([firsttd, sapId, mobile, dept, desg, result,
                                Action
                            ]).draw();
                        });
                    },
                    error: function() {
                        $("#otp_error").text("Update Error");
                    }

                });


            });



            $('.tableSearch').on('input', function() {
                var searchData = $('.tableSearch').val();


                $.ajax({
                    url: "{{ route('employeeSearch') }}",
                    type: 'ajax',
                    method: 'post',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        searchData: searchData,
                    },
                    success: function(data) {

                        table.clear().draw();
                        $.each(data, function(key, val) {
                            var id = val.id;
                            var sapId = val.sap_id;
                            var mobile = val.mobile;
                            var dept = val.deptName;
                            var desg = val.desgName;
                            var email = val.email;
                            var firstName = val.first_name;
                            var lastName = val.last_name;
                            var activeStatus = (val.is_active == 1) ? "checked" : "";

                            var pic = (val.profile_image) ? val.profile_image : 'noimage.png';
                            var folder = "images/Employee/";
                            folder += pic;

                            var firsttd =
                                '<div class="symbol symbol-circle symbol-50px overflow-hidden me-3">';
                            firsttd += '<a href="javascript:void(0);">';
                            firsttd += '<div class="symbol-label">';
                            firsttd +=
                                '<img src=' + folder + ' alt="' + firstName + '" width="50" height="50"class="w-100" />';
                            firsttd += ' </div>';
                            firsttd += '</a>';
                            firsttd += '</div>';
                            firsttd += '<div class="d-flex flex-column">';
                            firsttd += '<a href="javascript:void(0);"class="text-gray-800 text-hover-primary mb-1" style="position:relative;left:59px;bottom:43px;">' + firstName + ' ' + lastName + '</a>';
                            firsttd += ' <span style="position:relative;left:59px;bottom:43px;">Email:' + email + '</span>';
                            firsttd += ' </div>';
                            var editurl = '{{ route("employees.edit", ":id") }}';
                            editurl = editurl.replace(':id', id);
                            var editBtn = (
                                '<a href="' + editurl + '" class="btn btn-icon btn-active-light-primary w-30px h-30px me-3" <span data-bs-toggle="tooltip" data-bs-trigger="hover" title="Edit"><span class="svg-icon svg-icon-3"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"> <path opacity="0.3" d="M21.4 8.35303L19.241 10.511L13.485 4.755L15.643 2.59595C16.0248 2.21423 16.5426 1.99988 17.0825 1.99988C17.6224 1.99988 18.1402 2.21423 18.522 2.59595L21.4 5.474C21.7817 5.85581 21.9962 6.37355 21.9962 6.91345C21.9962 7.45335 21.7817 7.97122 21.4 8.35303ZM3.68699 21.932L9.88699 19.865L4.13099 14.109L2.06399 20.309C1.98815 20.5354 1.97703 20.7787 2.03189 21.0111C2.08674 21.2436 2.2054 21.4561 2.37449 21.6248C2.54359 21.7934 2.75641 21.9115 2.989 21.9658C3.22158 22.0201 3.4647 22.0084 3.69099 21.932H3.68699Z" fill="currentColor" /><path d="M5.574 21.3L3.692 21.928C3.46591 22.0032 3.22334 22.0141 2.99144 21.9594C2.75954 21.9046 2.54744 21.7864 2.3789 21.6179C2.21036 21.4495 2.09202 21.2375 2.03711 21.0056C1.9822 20.7737 1.99289 20.5312 2.06799 20.3051L2.696 18.422L5.574 21.3ZM4.13499 14.105L9.891 19.861L19.245 10.507L13.489 4.75098L4.13499 14.105Z" fill="currentColor" /></svg> </span></span></a>'
                            );
                            //   var img=('<img src='  'width=50' 'height=50' 'class=w-100'' />')
                            var Action = (editBtn +
                                '<a class="btn btn-icon btn-active-light-primary w-30px h-30px me-3" href="javascript:void(0);" class="menu-link px-3" onclick="delete_item(' +
                                id +
                                ')"><span class="svg-icon svg-icon-3"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z" fill="currentColor" /><path opacity="0.5" d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z" fill="currentColor" /><path opacity="0.5" d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z" fill="currentColor" /></svg></span></a>'
                            );
                            var status = val.is_active;
                            var person = pic + "<br>" + firstName + " " + lastName +
                                "<br>" + "Email:" + email;
                            var result = (
                                '<label class="switch"><input type="checkbox" data-id="' +
                                id + '" class="status" ' + activeStatus +
                                '>  <span class="slider round"></span></label>');

                            table.row.add([firsttd, sapId, mobile, dept, desg, result,
                                Action
                            ]).draw();
                        });
                    },
                    error: function() {
                        $("#otp_error").text("Update Error");
                    }

                });


            });
        });



    function delete_item(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3565ed',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then(isConfirmed => {
            if (isConfirmed.value) {
                $.ajax({
                    url: "{{ url('employees') }}" + "/" + id,
                    type: 'ajax',
                    method: 'delete',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        id: id,
                    },
                    success: function(result) {
                        if (result.message == "Failed") {
                            Swal.fire(
                                'Deleted!',
                                result.data,
                                'error'
                            );
                        } else {
                            Swal.fire(
                                'Deleted!',
                                result.data,
                                'success'
                            );
                            window.location.reload();
                        }
                    }
                });

            }
        });
    }
    $(document).on('change', '.status', function() {
        var chk = $(this);
        var id = $(this).attr('data-id');
        var status = $(this).prop('checked') == true ? 1 : 0;
        var activeStatus = "";
        if (status) {
            activeStatus = "Active";
        } else {
            activeStatus = "InActive";
        }
        console.log(status);

        Swal.fire({
            title: 'Change Status',
            text: "Are You Sure To " + activeStatus + " This Employee!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3565ed',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Change it!'
        }).then(isConfirmed => {
            if (isConfirmed.value) {
                $.ajax({
                    url: "{{ url('changeEmployeeActiveStatus') }}",
                    type: 'ajax',
                    method: 'post',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        id: id,
                        status: status,
                    },
                    success: function(result) {
                        if (result) {
                            window.location.reload();
                        }
                    }
                });
                if (isConfirmed.value) {
                    Swal.fire(
                        'Status!',
                        'Employee Status has been Changed.',
                        'success'
                    );

                }
            } else {
                if (status == 1) {
                    chk.prop('checked', false);

                } else {

                    chk.prop('checked', true).attr('checked', 'checked');
                }
            }
        });
    });
</script>
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
                    <div class="card-body  p-3">
                        <div class="" style="">
                            <div class="row g-8">
                                <!--begin::Col-->
                                <div class="col-md-3">
                                    <label class=" form-label text-dark "> Department </label>
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
                                    <select class="form-select form-select-solid filterDeptAndDes" name="project_code_name" data-kt-select2="true" data-placeholder="Designation" data-allow-clear="true" id="designationFilter">
                                        <option></option>
                                        @foreach ($designation as $des)
                                        <option value="{{ $des['id'] }}">
                                            {{ $des['name'] }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="w-auto">
                                    <label class="fs-6 fw-semibold mb-2 d-block">&nbsp;</label>
                                    <span class="btn btn-warning " onclick="resetFilter()">Reset</span>
                                </div>
                                @if (auth()->user()->is_super_admin == 1 ||
                                auth()->user()->can('employee-create'))
                                <div class="w-auto">
                                    <a href="{{url('employees/create')}}">
                                        <label class="fs-6 fw-semibold mb-2 d-block">&nbsp;</label>
                                        <span class="btn switchPrimaryBtn  ">+Add</span>
                                    </a>
                                </div>
                                @endif
                                <div class="w-auto">
                                    <a href="{{url('bulkUploadCreate')}}">
                                        <label class="fs-6 fw-semibold mb-2 d-block">&nbsp;</label>
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

                                    <th class="min-w-50px">Name</th>
                                    <th class="min-w-50px">SAP-ID</th>
                                    <th class="min-w-50px">Mobile</th>
                                    <th class="min-w-50px">Department</th>
                                    <th class="min-w-50-px">Designation</th>
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
                                <tr itsDepend="{{$d['itsDepend']}}">
                                    <!--begin::Checkbox-->

                                    <!--end::Checkbox-->
                                    <!--begin::User=-->

                                    <?php if ($d['profileImage']) {
                                        $pImage = $d['profileImage'];
                                    } else {
                                        $pImage = "noimage.png";
                                    } ?>

                                    <td class="">
                                        <div class="d-flex align-items-center flex-grow-1">
                                            <!--begin::Avatar-->
                                            <div class="symbol symbol-45px me-5">
                                                <img src="{{ asset('images/Employee/' . $pImage) }}" alt="" style="width: auto;">
                                            </div>
                                            <!--end::Avatar-->

                                            <!--begin::Info-->
                                            <div class="d-flex flex-column">
                                                <a href="javascript:void(0);" class="text-gray-900 text-hover-primary fs-6 fw-bold">{{$d['name']}}</a>

                                                <span class="text-gray-400 fw-bold">Email:{{ $d['email'] }}</span>
                                            </div>
                                            <!--end::Info-->
                                        </div>

                                    </td>
                                    <td>{{ $d['sapId'] }}</td>
                                    <td>{{ $d['mobile']}}</td>
                                    <td>{{ $d['departmentName'] }}</td>
                                    <td>{{ $d['designationName'] }}</td>
                                    <td>
                                        <label class="switch">
                                            <input type="checkbox" data-id="{{ $d['id'] }}" value="" class="status" <?php echo $d['is_active'] == 1 ? 'checked' : ''; ?>>
                                            <span class="slider round"></span>
                                        </label>

                                    </td>
                                    <td>
                                        <div class="d-flex my-3 ms-9">
                                            <!--begin::Edit-->
                                            @if (auth()->user()->is_super_admin == 1 ||
                                            auth()->user()->can('employee-edit'))
                                            <a class="editPage" style="display:inline;cursor: pointer;" id="{{ $d['id'] }}" title="Edit Employee"><i class="fa-solid fa-pen" style="color:orange"></i></a>
                                            @endif
                                            <!--end::Edit-->
                                            @if (auth()->user()->is_super_admin == 1 ||
                                            auth()->user()->can('employee-delete'))
                                            <div style="display:inline;cursor: pointer; margin-left: 10px;" id="{{$d['id'] }}" class="deleteEmployee" title="Delete Employee"><i class="fa-solid fa-trash" style="color:red"></i></div>
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
    $(document).on('click', '.editPage', function() {
        var id = $(this).attr('id');
        var url = "{{route('employeeEdit')}}";
        var form = $('<form action="' + url + '" method="post">' +
            ' {{ csrf_field() }} <input type="hidden" name="id" value="' + id + '" />' +
            '</form>');
        $('body').append(form);
        form.submit();

    });

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
                                '<a class="editPage" id="' + id + '" style="display:inline;cursor: pointer;" title="Edit Employeee"><i class="fa-solid fa-pen" style="color:orange"></i>></a>'
                            );
                            var deleteBtn = (
                                '<div  id="' + id + '"  class="deleteEmployee" style="display:inline;cursor: pointer;margin-left: 10px;" title="Delete Employeee"><i class="fa-solid fa-trash" style="color:red"></i>></div>'
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
            // Department & Designation
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
                                '<a class="editPage" id="' + id + '" style="display:inline;cursor: pointer;" title="Edit Employeee"><i class="fa-solid fa-pen" style="color:orange"></i></a>'
                            );
                            var deleteBtn = (
                                '<div id="' + id + '"  class="deleteEmployee"  style="display:inline;cursor: pointer;margin-left: 10px;" title="Delete Employeee"><i class="fa-solid fa-trash" style="color:red"></i></div>'
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


        });



    $(document).on('click', '.deleteEmployee', function() {
        var id = $(this).attr('id');
        var alertmsg = "You won't be able to revert this!";
        var itsdepend = $(this).closest('tr').attr('itsdepend');
        console.log(itsdepend);
        if (itsdepend ==true) {
            alertmsg = "This employee already mapped with the workflow,Do You want to want to re-assign to another Employee? ";
        }

        Swal.fire({
            title: 'Are you sure?',
            text: alertmsg,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3565ed',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then(isConfirmed => {
            if (isConfirmed.value) {
                if (itsdepend ==true) {
                    reAssignEmployee(id, "delete");
                } else {
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
                                getListData();
                            }
                        }
                    });
                }

            }
        });
    });
    $(document).on('change', '.status', function() {
        var isSuperAdmin = "{{ auth()->user()->is_super_admin }}";
        var isAuthorityEdit = "{{ auth()->user()->can('employee-edit') }}";
        var isAuthorityDelete = "{{ auth()->user()->can('employee-delete') }}";
        var table = $('#service_table').DataTable();

        var chk = $(this);
        var id = $(this).attr('data-id');
        var status = $(this).prop('checked') == true ? 1 : 0;
        var activeStatus = "";
        if (status) {
            activeStatus = "Active";
        } else {
            activeStatus = "InActive";
        }
        var alertmsg = "Are You Sure To " + activeStatus + " This Employee!";
        var itsdepend = $(this).closest('tr').attr('itsdepend');
        var ipType = 1;
        if (itsdepend == true) {
            alertmsg = "This employee already mapped with the workflow,Do You want to want to re-assign to another Employee? ";
        }


        Swal.fire({
            title: 'Change Status',
            text: alertmsg,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3565ed',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Change it!'
        }).then(isConfirmed => {
            if (isConfirmed.value) {
                if (itsdepend ==true) {
                    reAssignEmployee(id, "status");
                } else {


                    $.ajax({
                        url: "{{ url('changeEmployeeActiveStatus') }}",
                        type: 'ajax',
                        method: 'post',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            id: id,
                            status: status,
                            itsdepend: itsdepend,
                        },
                        success: function(result) {
                            var resDatas = result.data;
                            console.log(resDatas);

                            if (resDatas.message == "Failed") {
                                if (status == 1) {
                                    chk.prop('checked', false);

                                } else {

                                    chk.prop('checked', true).attr('checked', 'checked');
                                }
                                Swal.fire(
                                    'Status!',
                                    resDatas.data,
                                    'error'
                                );
                            } else {
                                Swal.fire(
                                    'Status!',
                                    resDatas.data,
                                    'success'
                                );
                                getListData();
                            }
                        }
                    });
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

    function reAssignEmployee(empId, status) {

        var url = "{{route('reAssignEmployee')}}";
        var form = $('<form action="' + url + '" method="post">' +
            ' {{ csrf_field() }} <input type="hidden" name="id" value="' + empId + '" /> <input type="hidden" name="actionType" value="' + status + '" />' +
            '</form>');
        $('body').append(form);
        form.submit();
    }

    function getListData() {
        var isSuperAdmin = "{{ auth()->user()->is_super_admin }}";
        var isAuthorityEdit = "{{ auth()->user()->can('employee-edit') }}";
        var isAuthorityDelete = "{{ auth()->user()->can('employee-delete') }}";

        var table = $('#service_table').DataTable();

        $.ajax({
            url: "{{ url('getEmployeeListData') }}",
            type: 'ajax',
            method: 'get',
            data: {
                "_token": "{{ csrf_token() }}"
            },
            success: function(result) {
                table.clear().draw();

                $.each(result, function(key, val) {
                    console.log(val);
                                 
                    var itsDepend = (val.itsDepend)?1:0;
                    var name = val.name ;                   
                    var id = val.id;
                    var sapId = val.sapId;
                    var mobile = val.mobile;
                    var dept = val.departmentName;
                    var desg = val.designationName;
                    var email = val.email;
                    var pic = (val.profileImage) ? val.profileImage : 'noimage.png';
                    var folder = "{{ asset('images/Employee') }}"+"/";                             
                    folder += pic;
               
                    var firsttd =
                        '<div class="symbol symbol-circle symbol-50px overflow-hidden me-3">';
                    firsttd += '<a href="javascript:void(0);">';
                    firsttd += '<div class="symbol-label">';
                    firsttd +=
                        '<img src=' + folder + ' alt="' + name + '" width="50" height="50" class="w-100 testd" />';
                    firsttd += ' </div>';
                    firsttd += '</a>';
                    firsttd += '</div>';
                    firsttd += '<div class="d-flex flex-column">';
                    firsttd += '<a href="javascript:void(0);"class="text-gray-800 text-hover-primary mb-1" style="position:relative;left:59px;bottom:43px;">' + name + '</a>';
                    firsttd += ' <span style="position:relative;left:59px;bottom:43px;">Email:' + email + '</span>';
                    firsttd += ' </div>';


                    var statusRes = (val.is_active == 1) ? "checked" : "";
                    var statusBtn = '<label class="switch">';
                    statusBtn += '<input type="checkbox" data-id="' + id + '" value="" class="status" ' + statusRes + '>';
                    statusBtn += '<span class="slider round"></span></label>';
                    var editurl = '{{ route("employees.edit", ":id") }}';
                    editurl = editurl.replace(':id', id);

                    if (isSuperAdmin || isAuthorityEdit) {
                        var editBtn = (
                            '<a class="editPage" id="' + id + '" style="display:inline;cursor: pointer;" title="Edit Employeee"><i class="fa-solid fa-pen" style="color:orange"></i></a>'
                        );
                    }

                    if (isSuperAdmin || isAuthorityDelete) {
                        var deleteBtn = (
                            '<div  id="' + id + '"  class="deleteEmployee"  style="display:inline;cursor: pointer;margin-left: 10px;" title="Delete Employeee"><i class="fa-solid fa-trash" style="color:red"></i></div>'
                        );
                    }


                    var actionBtn = (editBtn +
                        deleteBtn
                    );

                    var newRow = table.row.add([firsttd, sapId, mobile, dept, desg, statusBtn, actionBtn]).node();
                    newRow.setAttribute('itsDepend', itsDepend);
                    table.draw();
                });
            }
        });
    }
</script>
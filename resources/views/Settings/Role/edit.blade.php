@extends('layouts.app')

@section('content')
<style>
    input.permission {
        width: 40px;
        height: 40px;
    }

    .accordion {
        background-color: #eee;
        color: #444;
        cursor: pointer;
        padding: 18px;
        width: 100%;
        border: none;
        text-align: left;
        outline: none;
        font-size: 15px;
        transition: 0.4s;
    }

    .active,
    .accordion:hover {
        background-color: #ccc;
    }

    .accordion:after {
        content: '\002B';
        color: #777;
        font-weight: bold;
        float: right;
        margin-left: 5px;
    }

    .active:after {
        content: "\2212";
    }

    .panel {
        padding: 0 18px;
        background-color: white;
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.2s ease-out;
    }

    .checkboxes {
        display: flex;
        justify-content: start;
        align-items: center;
        vertical-align: middle;
        word-wrap: break-word;

    }

    .checkAll {
        width: 25px;
        height: 25px;
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
                    Privileges</h1>
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
                        <li class="breadcrumb-item text-muted">Privileges</li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-400 w-5px h-2px"></span>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted"><?php echo isset($roles) ? "Edit" : "Add"; ?></li>
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
                    <div class="card-body py-4">
                        <!--begin::Card title-->

                        <!--begin::Card title-->
                        <!--begin::Table-->

                        <form id="department_form1" method="post" action="{{url('roles')}}">
                            @csrf
                            <input type="hidden" class="editid" name="id" value="{{$roles->id}}">
                            @php $rolem = Spatie\Permission\Models\Role::findorFail($roles->id);
                            $roleP =json_decode($rolem->permissions);
                            $allroles = [];

                            @endphp
                            @foreach($roleP as $roleP1)
                            @php
                            $s1=$roleP1->name;
                            array_push($allroles,$s1);
                            @endphp
                            @endforeach

                            <!--end::Input group-->

                            <div class="row g-9 mb-7">
                                <!--begin::Col-->
                                <div class="col-md-12 fv-row">
                                    <!--begin::Label-->
                                    <label class="required fs-6 fw-semibold mb-2">Name</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input class="form-control form-control-solid roleName" placeholder="Enter Privilage Name" name="name" value="{{$roles->name}}" fieldData="{{$roles->id}}" />
                                    <!--end::Input-->
                                    <p id="roleNameAlert" class="notifyAlert"></p>
                                    <p id="roleNameaddAlert" class="notifyAlert"></p>
                                </div>
                                <!--end::Col-->
                            </div>
                            <div class="fv-row mb-15">
                                <!--begin::Wrapper-->
                                <div class="d-flex flex-stack">
                                    <!--begin::Label-->
                                    <div class="me-5">
                                        <label class="required fs-6 fw-semibold">Authority</label>
                                    </div>
                                    <!--end::Label-->
                                    <!--begin::Checkboxes-->
                                    <div class="d-flex">
                                        <!--begin::Checkbox-->
                                        <label class="form-radio form-radio-custom form-radio-solid me-6">
                                            <!--begin::Input-->
                                            <input class="form-radio-input h-20px w-20px authority_type" type="radio" value="1" name="authority_type" <?php echo ($roles->authority_type == 1) ? "checked" : "" ?> />
                                            <!--end::Input-->
                                            <!--begin::Label-->
                                            <span class="form-radio-label fw-semibold">Admin/HOD</span>
                                            <!--end::Label-->
                                        </label>
                                        <!--end::Checkbox-->
                                        <!--begin::Checkbox-->
                                        <label class="form-radio form-radio-custom form-radio-solid">
                                            <!--begin::Input-->
                                            <input class="form-radio-input h-20px w-20px authority_type" type="radio" value="2" name="authority_type" <?php echo ($roles->authority_type == 2) ? "checked" : "" ?> />
                                            <!--end::Input-->
                                            <!--begin::Label-->
                                            <span class="form-radio-label fw-semibold">Employee</span>
                                            <!--end::Label-->
                                        </label>
                                        <!--end::Checkbox-->
                                    </div>
                                    <!--end::Checkboxes-->
                                </div>
                                <!--begin::Wrapper-->
                            </div>
                            <label for="permissions" class="form-label">Assign Permissions</label>
                            <div class="col-md-12 col-sm-12">
                                <button type="button" class="accordion">Permission</button>

                                <div class="panel">

                                    <table class="table table-striped">
                                        <thead>
                                            <th scope="col" width="1%">S.No</th>
                                            <th scope="col" width="30%">Screen Name</th>
                                            <th scope="col" width="10%">View</th>
                                            <th scope="col" width="10%">Create</th>
                                            <th scope="col" width="10%">Edit </th>
                                            <th scope="col" width="10%">Delete</th>
                                            <th scope="col" width="10%">Upload </th>
                                            <th scope="col" width="15%">Download</th>

                                        </thead>

                                        <tbody>
                                            <tr>
                                                <td>1</td>
                                                <td>Department</td>
                                                <td><input type="checkbox" name="permission[]" value="department-view" class='permission permissionEdit' <?php echo (in_array("department-view", $allroles) ? "checked" : ''); ?>></td>
                                                <td><input type="checkbox" name="permission[]" value="department-create" class='permission permissionEdit' <?php echo (in_array("department-create", $allroles) ? "checked" : ''); ?>></td>
                                                <td><input type="checkbox" name="permission[]" value="department-edit" class='permission permissionEdit' <?php echo (in_array("department-edit", $allroles) ? "checked" : ''); ?>></td>
                                                <td><input type="checkbox" name="permission[]" value="department-delete" class='permission permissionEdit' <?php echo (in_array("department-delete", $allroles) ? "checked" : ''); ?>></td>
                                                <td><input type="checkbox" name="permission[]" value="department-upload" class='permission permissionEdit' <?php echo (in_array("department-upload", $allroles) ? "checked" : ''); ?>></td>
                                                <td><input type="checkbox" name="permission[]" value="department-download" class='permission permissionEdit' <?php echo (in_array("department-download", $allroles) ? "checked" : ''); ?>></td>
                                            </tr>
                                            <tr>
                                                <td>2</td>
                                                <td>Designation</td>
                                                <td><input type="checkbox" name="permission[]" value="designation-view" class='permission permissionEdit' <?php echo (in_array("designation-view", $allroles) ? "checked" : ''); ?>></td>
                                                <td><input type="checkbox" name="permission[]" value="designation-create" class='permission permissionEdit' <?php echo (in_array("designation-create", $allroles) ? "checked" : ''); ?>></td>
                                                <td><input type="checkbox" name="permission[]" value="designation-edit" class='permission permissionEdit' <?php echo (in_array("designation-edit", $allroles) ? "checked" : ''); ?>></td>
                                                <td><input type="checkbox" name="permission[]" value="designation-delete" class='permission permissionEdit' <?php echo (in_array("designation-delete", $allroles) ? "checked" : ''); ?>></td>
                                                <td><input type="checkbox" name="permission[]" value="designation-upload" class='permission permissionEdit' <?php echo (in_array("designation-upload", $allroles) ? "checked" : ''); ?>></td>
                                                <td><input type="checkbox" name="permission[]" value="designation-download" class='permission permissionEdit' <?php echo (in_array("designation-download", $allroles) ? "checked" : ''); ?>></td>

                                            </tr>
                                            <tr>
                                                <td>3</td>
                                                <td>Document Type</td>
                                                <td><input type="checkbox" name="permission[]" value="document-type-view" class='permission permissionEdit' <?php echo (in_array("document-type-view", $allroles) ? "checked" : ''); ?>></td>
                                                <td><input type="checkbox" name="permission[]" value="document-type-create" class='permission permissionEdit' <?php echo (in_array("document-type-create", $allroles) ? "checked" : ''); ?>></td>
                                                <td><input type="checkbox" name="permission[]" value="document-type-edit" class='permission permissionEdit' <?php echo (in_array("document-type-edit", $allroles) ? "checked" : ''); ?>></td>
                                                <td><input type="checkbox" name="permission[]" value="document-type-delete" class='permission permissionEdit' <?php echo (in_array("document-type-delete", $allroles) ? "checked" : ''); ?>></td>
                                                <td><input type="checkbox" name="permission[]" value="document-type-upload" class='permission permissionEdit' <?php echo (in_array("document-type-upload", $allroles) ? "checked" : ''); ?>></td>
                                                <td><input type="checkbox" name="permission[]" value="document-type-download" class='permission permissionEdit' <?php echo (in_array("document-type-download", $allroles) ? "checked" : ''); ?>></td>

                                            </tr>
                                            <tr>
                                                <td>4</td>
                                                <td>Employee</td>
                                                <td><input type="checkbox" name="permission[]" value="employee-view" class='permission permissionEdit' <?php echo (in_array("employee-view", $allroles) ? "checked" : ''); ?>></td>
                                                <td><input type="checkbox" name="permission[]" value="employee-create" class='permission permissionEdit' <?php echo (in_array("employee-create", $allroles) ? "checked" : ''); ?>></td>
                                                <td><input type="checkbox" name="permission[]" value="employee-edit" class='permission permissionEdit' <?php echo (in_array("employee-edit", $allroles) ? "checked" : ''); ?>></td>
                                                <td><input type="checkbox" name="permission[]" value="employee-delete" class='permission permissionEdit' <?php echo (in_array("employee-delete", $allroles) ? "checked" : ''); ?>></td>
                                                <td><input type="checkbox" name="permission[]" value="employee-upload" class='permission permissionEdit' <?php echo (in_array("employee-upload", $allroles) ? "checked" : ''); ?>></td>
                                                <td><input type="checkbox" name="permission[]" value="employee-download" class='permission permissionEdit' <?php echo (in_array("employee-download", $allroles) ? "checked" : ''); ?>></td>

                                            </tr>
                                            <tr>
                                                <td>5</td>
                                                <td>Projects</td>
                                                <td><input type="checkbox" name="permission[]" value="project-view" class='permission permissionEdit' <?php echo (in_array("project-view", $allroles) ? "checked" : ''); ?>></td>
                                                <td><input type="checkbox" name="permission[]" value="project-create" class='permission permissionEdit' <?php echo (in_array("project-create", $allroles) ? "checked" : ''); ?>></td>
                                                <td><input type="checkbox" name="permission[]" value="project-edit" class='permission permissionEdit' <?php echo (in_array("project-edit", $allroles) ? "checked" : ''); ?>></td>
                                                <td><input type="checkbox" name="permission[]" value="project-delete" class='permission permissionEdit' <?php echo (in_array("project-delete", $allroles) ? "checked" : ''); ?>></td>
                                                <td><input type="checkbox" name="permission[]" value="project-upload" class='permission permissionEdit' <?php echo (in_array("project-upload", $allroles) ? "checked" : ''); ?>></td>
                                                <td><input type="checkbox" name="permission[]" value="project-download" class='permission permissionEdit' <?php echo (in_array("project-download", $allroles) ? "checked" : ''); ?>></td>

                                            </tr>
                                            <tr>
                                                <td>6</td>
                                                <td>WorkFlow</td>
                                                <td><input type="checkbox" name="permission[]" value="workflow-view" class='permission permissionEdit' <?php echo (in_array("workflow-view", $allroles) ? "checked" : ''); ?>></td>
                                                <td><input type="checkbox" name="permission[]" value="workflow-create" class='permission permissionEdit' <?php echo (in_array("workflow-create", $allroles) ? "checked" : ''); ?>></td>
                                                <td><input type="checkbox" name="permission[]" value="workflow-edit" class='permission permissionEdit' <?php echo (in_array("workflow-edit", $allroles) ? "checked" : ''); ?>></td>
                                                <td><input type="checkbox" name="permission[]" value="workflow-delete" class='permission permissionEdit' <?php echo (in_array("workflow-delete", $allroles) ? "checked" : ''); ?>></td>
                                                <td><input type="checkbox" name="permission[]" value="workflow-upload" class='permission permissionEdit' <?php echo (in_array("workflow-upload", $allroles) ? "checked" : ''); ?>></td>
                                                <td><input type="checkbox" name="permission[]" value="workflow-download" class='permission permissionEdit' <?php echo (in_array("workflow-download", $allroles) ? "checked" : ''); ?>></td>

                                            </tr>
                                            <tr>
                                                <td>7</td>
                                                <td>Privilage</td>
                                                <td><input type="checkbox" name="permission[]" value="role-view" class='permission permissionEdit' <?php echo (in_array("role-view", $allroles) ? "checked" : ''); ?>></td>
                                                <td><input type="checkbox" name="permission[]" value="role-create" class='permission permissionEdit' <?php echo (in_array("role-create", $allroles) ? "checked" : ''); ?>></td>
                                                <td><input type="checkbox" name="permission[]" value="role-edit" class='permission permissionEdit' <?php echo (in_array("role-edit", $allroles) ? "checked" : ''); ?>></td>
                                                <td><input type="checkbox" name="permission[]" value="role-delete" class='permission permissionEdit' <?php echo (in_array("role-delete", $allroles) ? "checked" : ''); ?>></td>
                                                <td><input type="checkbox" name="permission[]" value="role-upload" class='permission permissionEdit' <?php echo (in_array("role-upload", $allroles) ? "checked" : ''); ?>></td>
                                                <td><input type="checkbox" name="permission[]" value="role-download" class='permission permissionEdit' <?php echo (in_array("role-download", $allroles) ? "checked" : ''); ?>></td>

                                            </tr>
                                            <tr>
                                                <td>8</td>
                                                <td>User</td>
                                                <td><input type="checkbox" name="permission[]" value="user-view" class='permission permissionEdit' <?php echo (in_array("user-view", $allroles) ? "checked" : ''); ?>></td>
                                                <td><input type="checkbox" name="permission[]" value="user-create" class='permission permissionEdit' <?php echo (in_array("user-create", $allroles) ? "checked" : ''); ?>></td>
                                                <td><input type="checkbox" name="permission[]" value="user-edit" class='permission permissionEdit' <?php echo (in_array("user-edit", $allroles) ? "checked" : ''); ?>></td>
                                                <td><input type="checkbox" name="permission[]" value="user-delete" class='permission permissionEdit' <?php echo (in_array("user-delete", $allroles) ? "checked" : ''); ?>></td>
                                                <td><input type="checkbox" name="permission[]" value="user-upload" class='permission permissionEdit' <?php echo (in_array("user-upload", $allroles) ? "checked" : ''); ?>></td>
                                                <td><input type="checkbox" name="permission[]" value="user-download" class='permission permissionEdit' <?php echo (in_array("user-download", $allroles) ? "checked" : ''); ?>></td>

                                            </tr>
                                            <tr>
                                                    <td>9</td>
                                                    <td>Dashboard</td>
                                                    <td><input type="checkbox" name="permission[]" value="dashboard-view" class='permission permissionEdit' <?php echo (in_array("dashboard-view", $allroles) ? "checked" : ''); ?> ></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td>10</td>
                                                    <td>Document Listing</td>
                                                    <td><input type="checkbox" name="permission[]" value="document-listing-view" class='permission permissionEdit' <?php echo (in_array("document-listing-view", $allroles) ? "checked" : ''); ?>></td>
                                                    <td></td>
                                                    <td><input type="checkbox" name="permission[]" value="document-listing-edit" class='permission permissionEdit' <?php echo (in_array("document-listing-edit", $allroles) ? "checked" : ''); ?>></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td>11</td>
                                                    <td>Approval Listing</td>
                                                    <td><input type="checkbox" name="permission[]" value="approval-listing-view" class='permission permissionEdit' <?php echo (in_array("approval-listing-view", $allroles) ? "checked" : ''); ?>></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td>12</td>
                                                    <td>Datewise Report</td>
                                                    <td><input type="checkbox" name="permission[]" value="datewise-report" class='permission permissionEdit' <?php echo (in_array("datewise-report", $allroles) ? "checked" : ''); ?>></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td>13</td>
                                                    <td>Projectwise Report</td>
                                                    <td><input type="checkbox" name="permission[]" value="projectwise-report" class='permission permissionEdit' <?php echo (in_array("projectwise-report", $allroles) ? "checked" : ''); ?>></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td>14</td>
                                                    <td>Documentwise Report</td>
                                                    <td><input type="checkbox" name="permission[]" value="documentwise-report" class='permission permissionEdit' <?php echo (in_array("documentwise-report", $allroles) ? "checked" : ''); ?>></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td>15</td>
                                                    <td>Userwise Report</td>
                                                    <td><input type="checkbox" name="permission[]" value="userwise-report" class='permission permissionEdit' <?php echo (in_array("userwise-report", $allroles) ? "checked" : ''); ?>></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            {{-- FORM --}}
                            <div class="text-center pt-15">
                            <a href="{{route('roles.index')}}">
                                    <button type="button" class="btn btn-light-danger me-3">Cancel</button></a>
                                <button type="submit" id="updateBtn" class="btn switchPrimaryBtn " data-kt-users-modal-action="submit">
                                    <span class="indicator-label">Update and Exit</span>
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
<script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.js"></script>
<script>
    $(document).ready(function() {
        var acc = document.getElementsByClassName("accordion");
        var i;

        for (i = 0; i < acc.length; i++) {
            acc[i].addEventListener("click", function() {
                this.classList.toggle("active");
                var panel = this.nextElementSibling;
                if (panel.style.maxHeight) {
                    panel.style.maxHeight = null;
                } else {
                    panel.style.maxHeight = panel.scrollHeight + "px";
                }
            });
        }

    });
    $(document).on('click', '.checkAll', function() {
        if ($(this).prop('checked') == true) {
            $('.permisionCreate').each(function() {
                this.checked = true;
            });
        } else {
            $('.permisionCreate').each(function() {
                this.checked = false;
            });
        }


    });
    $(document).on('click', '.permission', function() {
        $(this).attr('checked', false);
        var a = document.forms["department_form"];
        var x = a.querySelectorAll('input[name="permission[]"]:checked');
        if (x.length == 48) {
            $('.checkAll').prop('checked', true);
        } else {
            $('.checkAll').prop('checked', false);
        }

    });
    $(document).on('click', '.permissionEdit', function() {

        var a = document.forms["department_form1"];
        var x = a.querySelectorAll('input[type="checkbox"]:checked');

    });
    $(document).on('input', '.roleName', function() {
        console.log($(this).attr('fieldData'));


        $.ajax({
            url: "{{ route('roleNameValidation') }}",
            type: 'ajax',
            method: 'post',
            data: {
                "_token": "{{ csrf_token() }}",
                name: $(this).val(),
                id: $(this).attr('fieldData'),
            },
            success: function(data) {
                var alertName = 'roleNameAlert';
                console.log(data.response);
                console.log(alertName);

                if (data.response == false) {
                    $('#submitBtn').attr('disabled', true);
                    $('#updateBtn').attr('disabled', true);

                    document.getElementById(alertName).style.display = "block";
                    document.getElementById(alertName).style.color = "red";
                    document.getElementById(alertName).innerHTML = 'Role Is Exists*';

                    document.getElementById('roleNameAddAlert').style.display = "block";
                    document.getElementById('roleNameAddAlert').style.color = "red";
                    document.getElementById('roleNameAddAlert').innerHTML = 'Role Is Exists*';
                    return false;
                }
                document.getElementById(alertName).style.display = "none";
                $('#submitBtn').removeAttr('disabled');
                $('#updateBtn').removeAttr('disabled');
                return true;


            },
            error: function() {
                $("#otp_error").text("Update Error");
            }

        });

    });
</script>
@endsection
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
                      <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Users
                      </h1>
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
                          <li class="breadcrumb-item text-muted">Users</li>
                          <!--end::Item-->
                          <!--begin::Item-->
                          <li class="breadcrumb-item">
                              <span class="bullet bg-gray-400 w-5px h-2px"></span>
                          </li>
                          <!--end::Item-->
                          <!--begin::Item-->
                          <li class="breadcrumb-item text-muted">Add</li>
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
                          <form id="department_form" class="form" method="post" action="{{ url('users') }}">
                              @csrf
                          
                              <!-- <input type="hidden" value="" name='id' class="id"> -->
                              <div class="row g-9 mb-7">
                                  <!--begin::Col-->
                                  <div class="col-md-12 fv-row">
                                      <!--begin::Label-->
                                      <label class="required fs-6 fw-semibold mb-2">Enter SAP-ID Or Employee Name</label>
                                      <!--end::Label-->
                                      <!--begin::Input-->
                                      <select class="form-control form-control initiator_id sap_id" name="initiator_id" required>
                                          <option value="">Select</option>
                                          @foreach ($employees as $emp)
                                          <?php
                                            $selectEmp = (isset($userDetails->emp_id) == $emp['id']) ? "selected" : "";
                                            ?>
                                          <option value="<?php echo $emp['id']; ?>" {{$selectEmp}}><?php echo $emp['first_name'] . ' ' . $emp['last_name'] . '(' . $emp['sap_id'] . ')'; ?></option>
                                          @endforeach
                                      </select>
                                      <p id="employeeAlert" class="notifyAlert"></p>
                                      <!--end::Input-->
                                  </div>
                              </div>

                              <div class="row g-9 mb-7">
                                  <!--begin::Col-->
                                  <div class="col-md-12 fv-row">
                                      <!--begin::Label-->
                                      <label class="required fs-6 fw-semibold mb-2">Mobile No</label>
                                      <!--end::Label-->
                                      <!--begin::Input-->
                                      <input class="form-control form-control-solid mobile" name="mobile" value="<?php echo (isset($userDetails->mobile)) ? $userDetails->mobile : "" ?>" disabled required />
                                      <!--end::Input-->
                                  </div>
                                  <!--end::Col-->

                              </div>
                              <div class="row g-9 mb-7">
                                  <!--begin::Col-->
                                  <div class="col-md-12 fv-row">
                                      <!--begin::Label-->
                                      <label class="required fs-6 fw-semibold mb-2">Email</label>
                                      <!--end::Label-->
                                      <!--begin::Input-->
                                      <input class="form-control form-control-solid email" name="email" value="<?php echo (isset($userDetails->email)) ? $userDetails->email : "" ?>" disabled required />
                                      <!--end::Input-->
                                  </div>
                                  <!--end::Col-->

                              </div>
                              <div class="row g-9 mb-7">
                                  <!--begin::Col-->
                                  <div class="col-md-12 fv-row">
                                      <!--begin::Label-->
                                      <label class="required fs-6 fw-semibold mb-2">Privileges</label>
                                      <!--end::Label-->
                                      <!--begin::Input-->
                                      <select class="form-control form-control roles Privillage" name="roles" required>
                                          <option value="">Select</option>
                                          @foreach ($roles as $role)
                                          <option value="<?php echo $role['id']; ?>"><?php echo $role['name']; ?></option>
                                          @endforeach
                                      </select>
                                      <p id="roleAlert" class="notifyAlert"></p>
                                      <!--end::Input-->
                                  </div>
                              </div>

                              <br>
                              <div class="row g-9 mb-7">
                                  <!--begin::Col-->
                                  <div class="col-md-12 fv-row">
                                      <!--begin::Label-->
                                      <label class="required fs-6 fw-semibold mb-2">Password</label>
                                      <!--end::Label-->
                                      <!--begin::Input-->
                                      <input class="form-control form-control password" placeholder="Enter Password" name="password" required />
                                      <!--end::Input-->
                                      <p id="passwordAlert" class="notifyAlert"></p>
                                  </div>
                                  <!--end::Col-->

                              </div>
                              <div class="row g-9 mb-7">
                                  <!--begin::Col-->
                                  <div class="col-md-12 fv-row">
                                      <!--begin::Label-->
                                      <label class="required fs-6 fw-semibold mb-2">Confirm Password</label>
                                      <!--end::Label-->
                                      <!--begin::Input-->
                                      <input class="form-control form-control cpassword" placeholder="Enter confirm password" name="cpassword" required />
                                      <p id="cpasswordAlert" class="notifyAlert"></p>
                                      <p id="cpasswordmissmatchAlert" class="notifyAlert"></p>
                                      <!--end::Input-->
                                  </div>
                                  <!--end::Col-->

                              </div>

                              {{-- FORM --}}
                              <div class="text-center pt-15">
                                  <button type="reset" class="btn btn-light me-3" data-kt-users-modal-action="cancel">Reset</button>
                                  <a href="{{route('users.index')}}">
                                      <button type="button" class="btn btn-light-danger me-3">Cancel</button></a>
                                  <button type="button" onclick="rolesValidation();" class="btn btn-primary submit submitBtn" data-kt-users-modal-action="submit">
                                      <span class="indicator-label" >Save and Exit</span>
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
  <script>
      $(document).ready(function() {
          $('.submitBtn').attr('disabled', 'true');
          if ($('.id').val()) {
              $('.submitBtn').removeAttr('disabled');
              $('.reset').css('display', 'none');
          }
          // on form submit
          $(".initiator_id").select2({
              dropdownParent: $("#department_form")
          });
          $(".roles").select2({
              dropdownParent: $("#department_form")
          });

          $(".initiator_id").on('change', function() {
              var employeeId = $(this).val();

              $('.submit').prop('disabled', true);

              if (employeeId) {
                  $.ajax({
                      url: "{{ route('getEmployeeDetailByParams') }}",
                      type: 'ajax',
                      method: 'post',
                      data: {
                          "_token": "{{ csrf_token() }}",
                          fieldname: 'EmpId',
                          fieldData: employeeId,
                      },
                      success: function(result) {
                          var data = JSON.parse(result);

                          console.log(data);
                          $(".name,.mobile,.email").val("");
                          if (data) {
                              if (data.user) {
                                  Swal.fire({
                                      icon: 'error',
                                      title: 'Oops...',
                                      text: 'This Sap-Id AllReady In Users!',
                                      footer: ''
                                  });
                                  $('.submit').prop('disabled', true);
                                  $(".sapId,.name,.mobile,.email").val("");
                              } else {
                                  $('.submit').prop('disabled', false);
                                  var name = data.first_name + " " + data.last_name;
                                  $(".name").val(name);

                                  $(".mobile").val(data.mobile);
                                  $(".email").val(data.email);
                              }
                          }
                      }
                  });
              }
          });
      });
      $(document).on('change', '.initiater_id', function() {
          if ($(this).val()) {
              $('.submitBtn').removeAttr('disabled');
          } else {
              $('.submitBtn').attr('disabled', 'true');
          }
      });
      $(document).on('change', '.roles', function() {
          if ($(this).val()) {
              $('.submitBtn').removeAttr('disabled');
          } else {
              $('.submitBtn').attr('disabled', 'true');
          }
      });
      $(document).on('input', '.password', function() {
          if ($(this).val()) {
              $('.submitBtn').removeAttr('disabled');
          } else {
              $('.submitBtn').attr('disabled', 'true');
          }
      });
      $(document).on('input', '.cpassword', function() {
          if ($(this).val()) {
              $('.submitBtn').removeAttr('disabled');
          } else {
              $('.submitBtn').attr('disabled', 'true');
          }
      });
      $('.cpassword').click(function() {
          $('#wrong').hide();
      });






      function rolesValidation1() {

          var sap_id = $('.sap_id').val();
          var Privillage = $('.Privillage').val();
          var paswd = $('.password').val();
          var confPaswd = $('.cpassword').val();



          if ($('.sap_id').val() == "") {
              console.log('No');
              return false;
          } else {
              console.log('yes');
              return false;
          }


          if (paswd == confPaswd) {} else {
              document.getElementById('wrong').style.display = "block";
              document.getElementById('wrong').style.color = "red";
              document.getElementById('wrong').innerHTML = 'Password Mismatched';
              return false;

          }
          $.ajax({
              url: "{{url('rolesValidation')}}",
              type: 'ajax',
              method: 'post',
              data: {
                  "_token": "{{ csrf_token() }}",
                  name: 1,
                  id: 1
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

      function rolesValidation() {
          var sap_id = $('.sap_id').val();
          var roles = $('.Privillage').val();
          var password = $('.password').val();
          var cpassword = $('.cpassword').val();

          var sapIdError = validateField('employeeAlert', 'Employee', sap_id);
          var roleError = validateField('roleAlert', 'Privilage', roles);
          var passwordError = validateField('passwordAlert', 'Password', password);
          var cpasswordError = validateField('cpasswordAlert', 'Confirm Password', cpassword);

          console.log(sapIdError);
          console.log(roleError);
          console.log(passwordError);
          console.log(cpasswordError);
          var cpasswordMissmatch = true;
          if (cpassword) {
              if (password != cpassword) {
                  document.getElementById('cpasswordmissmatchAlert').style.display = "block";
                  document.getElementById('cpasswordmissmatchAlert').style.color = "red";
                  document.getElementById('cpasswordmissmatchAlert').innerHTML = 'Password Mismatched';
                  cpasswordMissmatch = false;
              } else {
                  document.getElementById('cpasswordmissmatchAlert').style.display = "none";

              }
          }

          if (sapIdError && roleError && passwordError && cpasswordError && cpasswordMissmatch) {

              $(".form").submit();
              return true;
          } else {
              console.log("Not well");
              return false;
          }
          return false;
      }

      function validateField(alertName, fieldname, fieldValue) {
          console.log(alertName, fieldname, fieldValue);
          if (fieldValue == "" || fieldValue == null) {
              document.getElementById(alertName).style.display = "block";
              document.getElementById(alertName).style.color = "red";
              document.getElementById(alertName).innerHTML = fieldname + ' Is Mandatory*';
              return false;
          }

          document.getElementById(alertName).style.display = "none";
          return true;
      }
  </script>
  @endsection
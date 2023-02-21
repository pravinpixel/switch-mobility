27-1-23
1)create user authority table
create table `user_authorities` (
	`id` int (11),
	`name` varchar (90),
	`auth_type_id` int (11),
	`employee_type_id` int (11),
	`created_at` datetime ,
	`updated_at` datetime 
);

..level details

CREATE TABLE `workflow_level_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `workflow_id` int(11) NOT NULL,
  `workflow_level_id` int(11) NOT NULL,
  `designation_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=131 DEFAULT CHARSET=utf8mb4;
  @for ($i = 0; $i <= 10; $i++)
   <button type="button" class="tablinks" 
  <?php
   if ($i == 0) {
  echo "id='defaultOpen'";
              } else {
                     echo "id='next'"; } ?> onclick="openCity(event, 'London<?php echo $i; ?>',<?php echo $i + 1; ?>)" id="defaultOpen">Level<?php echo $i + 1; ?></button>
                                        @endfor
                                           @for ($i = 0; $i <= 11; $i++)
                                 <div id="London<?php echo $i; ?>" class="tabcontent">
                                    <br>
                                    <h4 style="text-align:center;">Level<?php echo $i + 1; ?></h4>
                                    <input type="hidden" class="project_level<?php echo $i; ?>" name="project_level[]" value="<?php echo $i + 1; ?>">
                                    <div class="col-md-12 fv-row">
                                        <!--begin::Label-->
                                        <label class="required fs-6 fw-semibold mb-2">Due Date</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->

                                        <input type="date" class="form-control duedate due_date<?php echo $i; ?>" name="due_date[]" onclick="set_min_max_value_due_date();" />
                                        <!--end::Input-->
                                    </div>

                                    <div class="col-md-12 fv-row">
                                        <!--begin::Label-->
                                        <label class="required fs-6 fw-semibold mb-2">Priority</label><br>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input id="critical" type="checkbox" class="priority1<?php echo $i; ?>" name="priority[]" value="1">&nbsp;&nbsp;
                                        <input id="low" type="checkbox" class="priority2<?php echo $i; ?>" name="priority[]" value="2">&nbsp;&nbsp;
                                        <input id="medium" type="checkbox" class="priority3<?php echo $i; ?>" name="priority[]" value="3">&nbsp;&nbsp;
                                        <input id="high" type="checkbox" class="priority4<?php echo $i; ?>" name="priority[]" value="4">
                                        <!--end::Input-->
                                    </div>
                                    <h4>Approvers</h4>
                                    <div class="col-md-12 fv-row">
                                        <!--begin::Label-->
                                        <label class="required fs-6 fw-semibold mb-2 staff_label">Staff</label><br>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <select name="staff<?php echo $i; ?>[]" class="employee_append<?php echo $i + 1; ?> form-control staff<?php echo $i; ?>" multiple>
                                            <option value="">Select</option>
                                            @foreach ($employee as $emp)
                                            <option value="<?php echo $emp['id']; ?>"><?php echo $emp['first_name'] . ' ' . $emp['last_name']; ?></option>
                                            @endforeach
                                        </select>

                                        <!--end::Input-->
                                    </div>                             

                                    <div class="col-md-12 fv-row">
                                        <!--begin::Label-->
                                        <label class="fs-6 fw-semibold mb-2">Documents</label><br>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input type="file" name="main_document<?php echo $i; ?>[]" class="form-control" multiple accept=".csv,.pdf, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                                        <div class="main_document<?php echo $i; ?>"></div>
                                        {{-- <a href="javascript:void(0);" target="_blank" class="main_document<?php echo $i; ?>">Click to Open</a> --}}
                                        <!--end::Input-->
                                    </div>

                                    <div class="col-md-12 fv-row">
                                        <!--begin::Label-->
                                        <label class="fs-6 fw-semibold mb-2">Auxillary
                                            Documents</label><br>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input type="file" name="auxillary_document<?php echo $i; ?>[]" class="form-control" multiple accept=".csv,.pdf, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                                        <div class="auxillary_document<?php echo $i; ?>"></div>
                                        <!--end::Input-->
                                        <!-- <a href="javascript:void(0);" target="_blank" class="auxillary_document<?php echo $i; ?>">Click to Open</a> -->
                                    </div>

                            </div>


DROP TABLE IF EXISTS `project_approvers`;
CREATE TABLE `project_approvers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `project_level_id` int(11) DEFAULT NULL,
  `approver_id` int(11) NOT NULL,
  `designation_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4;

## instalation
step -1) php artisan migrate
step-2) Add Spatie packages
1) composer require spatie/laravel-permission.
2)config>app.php to add

 'providers' => [
    // ...
    Spatie\Permission\PermissionServiceProvider::class,
];
3)php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
4) php artisan optimize:clear
 # or
 php artisan config:clear

 5) php artisan migrate

Step-3) Added DB AND ROLES RElated  Files
step-4) to add default Table Data:

  insert  into `users`(`id`,`name`,`username`,`email`,`email_verified_at`,`is_admin`,`is_super_admin`,`auth_level`,`password`,`emp_id`,`authority_type`,`remember_token`,`created_at`,`updated_at`) values 
(1,'Admin','admin','admin@gmail.com',NULL,1,1,9,'$2y$10$OvbOTQ4LNMwd.jb/BGO/bOf2a1HBRwWOr2H31rpfFj2h55r/.9iky',0,NULL,NULL,'2023-01-04 08:09:00','2023-01-23 11:09:23');
step 5)finally Ur Logged Id Default Admin Temp:
1)user name:Admin
2)password:1234

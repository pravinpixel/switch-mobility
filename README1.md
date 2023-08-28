
## instalation
step -1) php artisan migrate
step-2) Add Spatie packages
        1) composer require spatie/laravel-permission
        2)config>app.php to add

        'providers' => [
            // ...
            Spatie\Permission\PermissionServiceProvider::class,
        ];
        3)php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
        And
        config>permission.php Add  'teams' => false,
step-3)Following Cmd Run
    1) php artisan optimize:clear
    2)php artisan config:cache
    3)php artisan config:clear
    4) php artisan migrate
    5) php artisan db:seed
step -4)Alter Role Table Run Following Command

        ALTER TABLE roles ADD authority_type INTEGER;
     

step 5)finally Ur Logged Id Default Admin Temp:
            1)user name:Admin
            2)password:1234

INSERT INTO `permissions`(`name`, `guard_name`) VALUES ('dashboard-view','web');
INSERT INTO `permissions`(`name`, `guard_name`) VALUES ('document-listing-view','web');
INSERT INTO `permissions`(`name`, `guard_name`) VALUES ('document-listing-edit','web');

DROP TABLE IF EXISTS `project_employees`;

CREATE TABLE `project_employees` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `level` int(11) DEFAULT NULL,
  `employee_id` int(11) NOT NULL,
  `type` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=210 DEFAULT CHARSET=utf8mb4;


  ALTER TABLE project_document_details ADD project_id INTEGER;
  ALTER TABLE project_document_details ADD upload_level INTEGER;
  ALTER TABLE project_document_details ADD updated_by INTEGER;
  ALTER TABLE project_document_details ADD is_latest INTEGER;

INSERT INTO `permissions`(`name`, `guard_name`) VALUES ('datewise-report','web');
INSERT INTO `permissions`(`name`, `guard_name`) VALUES ('projectwise-report','web');
INSERT INTO `permissions`(`name`, `guard_name`) VALUES ('documentwise-report','web');
INSERT INTO `permissions`(`name`, `guard_name`) VALUES ('userwise-report','web');


04/04/23

 ALTER TABLE projects ADD current_status INTEGER;

php artisan migrate --path=/database/migrations/2023_04_26_050057_create_project_document_first_stages_table.php  
php artisan migrate --path=/database/migrations/2023_04_22_063651_create_project_document_status_by_levels_table.php  
//test
 
ALTER TABLE project_document_details
ADD COLUMN is_downloaded INTEGER DEFAULT 0;

ALTER TABLE project_document_details
ADD COLUMN is_downloaded_time DATETIME DEFAULT NULL;

<======================================================>
18.8.23

ALTER TABLE projects
ADD COLUMN document_size INT DEFAULT 1,
ADD COLUMN document_orientation INT DEFAULT 1;

<======================================================>


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
5)php artisan config:cache

6) php artisan migrate
7) php artisan db:seed

Step-3)to run permission Screen

insert  into `permissions`(`id`,`name`,`guard_name`,`created_at`,`updated_at`) values (1,'department-view','web',NULL,NULL),(2,'designation-view','web',NULL,NULL),(3,'document-type-view','web',NULL,NULL),(4,'employee-view','web',NULL,NULL),(5,'workflow-view','web',NULL,NULL),(6,'project-view','web',NULL,NULL),(7,'role-view','web',NULL,NULL),(8,'user-view','web',NULL,NULL),(10,'department-create','web',NULL,NULL),(11,'department-edit','web',NULL,NULL),(12,'department-delete','web',NULL,NULL),(13,'designation-create','web',NULL,NULL),(14,'designation-edit','web',NULL,NULL),(15,'designation-delete','web',NULL,NULL),(16,'document-type-create','web',NULL,NULL),(17,'document-type-edit','web',NULL,NULL),(18,'document-type-delete','web',NULL,NULL),(19,'employee-create','web',NULL,NULL),(20,'employee-edit','web',NULL,NULL),(21,'employee-delete','web',NULL,NULL),(22,'project-create','web',NULL,NULL),(23,'project-edit','web',NULL,NULL),(24,'project-delete','web',NULL,NULL),(25,'workflow-create','web',NULL,NULL),(26,'workflow-edit','web',NULL,NULL),(27,'workflow-delete','web',NULL,NULL),(28,'role-create','web',NULL,NULL),(29,'role-edit','web',NULL,NULL),(30,'role-delete','web',NULL,NULL),(31,'user-create','web',NULL,NULL),(32,'user-edit','web',NULL,NULL),(33,'user-delete','web',NULL,NULL),(34,'department-upload','web',NULL,NULL),(35,'designation-upload','web',NULL,NULL),(36,'document-type-upload','web',NULL,NULL),(37,'employee-upload','web',NULL,NULL),(38,'workflow-upload','web',NULL,NULL),(39,'project-upload','web',NULL,NULL),(40,'role-upload','web',NULL,NULL),(41,'user-upload','web',NULL,NULL),(42,'department-download','web',NULL,NULL),(43,'designation-download','web',NULL,NULL),(44,'document-type-download','web',NULL,NULL),(45,'employee-download','web',NULL,NULL),(46,'workflow-download','web',NULL,NULL),(47,'project-download','web',NULL,NULL),(48,'role-download','web',NULL,NULL),(49,'user-download','web',NULL,NULL);

step 5)finally Ur Logged Id Default Admin Temp:
1)user name:Admin
2)password:1234




Truncate Tables:


TRUNCATE TABLE project_approvers;  
TRUNCATE TABLE project_document_details; 
TRUNCATE TABLE project_levels;  
TRUNCATE TABLE project_documents; 
TRUNCATE TABLE project_milestone;  
TRUNCATE TABLE projects; 

TRUNCATE TABLE workflow_level_details;  
TRUNCATE TABLE workflow_levels; 
TRUNCATE TABLE workflows;

TRUNCATE TABLE employees;   
TRUNCATE TABLE document_types; 

ALTER TABLE roles
ADD authority_type INTEGER;
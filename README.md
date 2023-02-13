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

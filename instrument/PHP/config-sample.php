<?php
/* This is the configuration file that should NOT be added to git! */

$limesurvey_db = array(
	'connector' => 'mysql',
	'host' => 'HOST', //replace this
	'port' => '3306',
	'database' => 'DBNAME', //replace this
    'username' => 'USERNAME', //replace this
    'password' => 'PASSWORD', //replace this
    'charset' => 'utf8',
    'prefix' => '',
);
				
$atmsg_db = array(
	'connector' => 'mysql',
	'host' => 'HOST', //replace this
	'port' => '3306',
	'database' => 'DBNAME', //replace this
    'username' => 'USERNAME', //replace this
    'password' => 'PASSWORD', //replace this
    'charset' => 'utf8',
    'prefix' => '',
);

$survey_id = 'SID'; //replace this
$send_emails = false;
$admin_email = 'admin@example.com'; //replace this

?>
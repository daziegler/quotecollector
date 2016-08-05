<?php

global $project;
$project = 'quotecollector';

global $databaseConfig;
$databaseConfig = array(
	'type' => 'MySQLDatabase',
	'server' => 'localhost',
	'username' => 'root',
	'password' => '',
	'database' => 'quotecollector',
	'path' => ''
);

// Set the site locale
i18n::set_locale('en_US');

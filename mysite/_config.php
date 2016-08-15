<?php

global $project;
$project = 'quotecollector';

global $database;
$database = 'dziegler_quotecollector';

// Use _ss_environment.php file for configuration
require_once("conf/ConfigureFromEnv.php");

// Set the site locale
i18n::set_locale('en_US');

Member::add_extension('QuoteMember');

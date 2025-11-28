<?php

# start session
session_start();

# required files
include_once('../app/includes/config.php');
include_once(PATH_INCLUDES.'app.php');
include_once(PATH_INCLUDES.'autoload.php');
include_once(PATH_INCLUDES.'connect.php');
include_once(PATH_INCLUDES.'lib.database.php');
include_once(PATH_INCLUDES.'lib.vars.php');

# load settings
loadsettings();
$global_language = new Language();
$global_alerts = new Alerts();

# view
include(getview("index.msg"));

?>
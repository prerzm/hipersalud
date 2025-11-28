<?php

# start session
session_start();

# required files
include_once('../../app/includes/config.php');
include_once(PATH_INCLUDES.'app.php');
include_once(PATH_INCLUDES.'autoload.php');
include_once(PATH_INCLUDES.'connect.php');
include_once(PATH_INCLUDES.'lib.database.php');
include_once(PATH_INCLUDES.'lib.vars.php');
include_once(PATH_APP.'vendor/autoload.php');

# get params
$mod = (Login::logged()) ? pg('mod') : "log";
$cmd = pg('cmd');

# load configurations settings
loadsettings();

# language
$global_language = new Language();

# alerts
$global_alerts = new Alerts();

# permissions
$global_perms = new Perms((int)Session::get_safe("roleId"));

redirect_on_access($mod);

$global_menu = getmenu((int)Session::get_safe("roleId"));

# module
include(getmodule($mod));

?>
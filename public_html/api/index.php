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

# vars
$global_language = new Language();

$api = new API();
$api->handleRequest();

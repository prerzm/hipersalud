<?php

# Server-based settings
if(isset($_SERVER['SERVER_NAME']) && $_SERVER['SERVER_NAME']=="localhipersalud") {
    date_default_timezone_set('America/Mexico_City');
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
    define("SITE_URL", "http://localhipersalud/");
} else {
    date_default_timezone_set('America/Mazatlan');
    error_reporting(0);
    ini_set('display_errors', '0');
    define("SITE_URL", "https://hipersalud.com/");
}

# Database login details
define("DB_HOST", "localhost");
define("DB_NAME", "hipersalud_data");
define("DB_USER", "hipersalud_user");
define("DB_PASS", "3Bhu1bmFQmhM2");

# path settings
define("PATH_ROOT", dirname(dirname(dirname(__FILE__))).DIRECTORY_SEPARATOR);
define("PATH_APP", PATH_ROOT."app".DIRECTORY_SEPARATOR);
define("PATH_INCLUDES", PATH_APP."includes".DIRECTORY_SEPARATOR);
define("PATH_HTML", PATH_APP."html".DIRECTORY_SEPARATOR);
define("PATH_CLASSES", PATH_APP."classes".DIRECTORY_SEPARATOR);
define("PATH_MODULES", PATH_APP."modules".DIRECTORY_SEPARATOR);
define("PATH_MAILS", PATH_APP."mails".DIRECTORY_SEPARATOR);

# roles settings
define("ROLE_WEBMASTER", "1");
define("ROLE_ADMIN", "2");
define("ROLE_DOCTOR", "3");
define("ROLE_PATIENT", "4");

# appointments settings
define("APP_SCHEDULED", "1");
define("APP_ATTENDED", "2");
define("APP_MISSED", "3");
define("APP_BLOCKED", "4");

# login settings
define("TOKEN_SETPSWD_LIFE", "10080");

# params safe
define("ENCRYPTED_PARAMS", "0");
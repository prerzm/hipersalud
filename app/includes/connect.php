<?php

/** Quiniela */

/* Tell mysqli to throw an exception if an error occurs */
#mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

/*	Connect and select MySQL database */
$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}

/*	Set mysql connection charset */
if (!$mysqli->set_charset('utf8mb4')) {
    printf("Error loading character set utf8mb4: %s\n", $mysqli->error);
    exit;
}

?>
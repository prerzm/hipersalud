<?php

# required files
include_once('/home/famzen/public_html/app/includes/config.php');
include_once('/home/famzen/public_html/app/includes/connect.php');
include_once('/home/famzen/public_html/app/includes/lib.database.php');
include_once('/home/famzen/public_html/app/includes/autoload.php');

# process cron
$tomorrow = strtotime("tomorrow");
$start = date("Y-m-d 00:00:00", $tomorrow);
$end = date("Y-m-d 23:59:59", $tomorrow);

$jor = sql_select_row("SELECT jornada_nombre, jornada_inicio FROM jornadas WHERE jornada_inicio BETWEEN '$start' AND '$end'");

if($jor) {

	$mail = new PREMailer();
	$mail->jornada_cambiar($jor['jornada_nombre'], date("d/m/Y", strtotime($jor['jornada_inicio']))." a las ".date("H:i", strtotime($jor['jornada_inicio'])));

}

?>
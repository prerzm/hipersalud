<?php

# includes
include_once("../../app/includes/config.php");
include_once("../../app/includes/connect.php");
include_once("../../app/includes/lib.vars.php");
include_once("../../app/includes/lib.database.php");
include_once("../../app/classes/Crypt.php");

# process
$cmd = pg('cmd');
$keyword = pf('query');

switch($cmd) {

    case 'doctor_search':
        $results = sql_select("SELECT userId AS data, CONCAT(name, ' (', email, ')') AS value FROM admin_users WHERE rolId  = ".ROLE_DOCTOR." AND (name LIKE '%$keyword%' OR email LIKE '%$keyword%') ORDER BY name ASC LIMIT 0, 100");
    break;

    case 'patient_search':
        $results = sql_select("SELECT userId AS data, CONCAT(name, ' (', email, ')') AS value FROM admin_users WHERE rolId  = ".ROLE_PATIENT." AND (name LIKE '%$keyword%' OR email LIKE '%$keyword%') ORDER BY name ASC LIMIT 0, 100");
    break;

	case 'calevents':

		$doctor_id = (int)pg('id');
		$start = date("Y-m-d H:i:s", pf('start'));
		$end = date("Y-m-d H:i:s", pf('end'));

		$results = sql_select("	SELECT 	a.appointmentId AS id, LEFT(u.name, LOCATE(' ', u.name) - 1) AS title, 
										LEFT(a.appDateTime, 16) AS start, LEFT(DATE_ADD(appDateTime, INTERVAL 30 MINUTE), 16) AS end, 
										CONCAT('#', s.bgcolor) AS color, CONCAT('#', s.color) AS textColor, 
										CONCAT('./?mod=".ps('apo')."&did=".ps($doctor_id)."&date=') AS url
								FROM 	admin_appointments a, admin_users u, admin_appointments_status s
								WHERE 	a.userId = u.userId AND a.appStatusId = s.appStatusId AND a.doctorId = $doctor_id AND 
										a.appDateTime >= '$start' AND a.appDateTime <= '$end'");
		
		if($results) {
			$total = count($results);
			for($i=0; $i<$total; $i++) {
				# encode date for results
				$results[$i]['url'] .= ps(substr($results[$i]['start'], 0, 10));
				$results[$i]['allDay'] = false;
			}
		}

		print json_encode($results);
		die();

	break;

	default:
		$results = false;
	break;
}

# output
if($results) {
	$jsonArray = json_encode($results);
	print "{";
	print '"query": "'.$keyword.'",';
	print '"suggestions": ';
	print $jsonArray;
	print "}";
} else {
	print "{";
	print '"query": "'.$keyword.'",';
	print '"suggestions": []';
	print "}";
}

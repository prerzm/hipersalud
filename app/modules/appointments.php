<?php

switch($cmd) {

	case 'schedule':

		# vars
		$doctor_id = (Session::get_safe('roleId')==ROLE_DOCTOR) ? Session::get_safe('userId') : pf('did');
		$date = pf('date');
		$record = new Appointment();

		if($record->add()>0) {
			$global_alerts->success("La información se actualizó correctamente");
		} else {
			$global_alerts->error("Hubo un problema en la información, intentar nuevamente");
		}

		# redirect
		if(Session::get_safe('roleId')==ROLE_DOCTOR) {
			redirect( array("mod" => "apo", "date" => $date) );
		} else {
			redirect( array("mod" => "apo", "date" => $date, "did" => $doctor_id) );
		}
		
	break;

	case 'confirm':

		# vars
		$id = (int)pg('id');
		$date = pg('date', 10);
		$record = new Appointment($id);

		if($record->confirm()) {
			$global_alerts->success("La información se actualizó correctamente");
		} else {
			$global_alerts->error("Hubo un problema en la información, intentar nuevamente");
		}

		# redirect
		redirect( ["mod" => "apo", "date" => $date] );

	break;

	case 'missed':

		# vars
		$record = new Appointment((int)pg('id'));

		if($record->missed()) {
			$global_alerts->success("La información se actualizó correctamente");
		} else {
			$global_alerts->error("Hubo un problema en la información, intentar nuevamente");
		}

		# redirect
		redirect( ["mod" => "apo", "date" => pg('date'), "did" => pg('did')] );

	break;

	case 'delete':

		# vars
		$id = (int)pg('id');
		$date = pg('date', 10);
		$record = new Appointment($id);

		if($record->remove()) {
			$global_alerts->success("La información se actualizó correctamente");
		} else {
			$global_alerts->error("Hubo un problema en la información, intentar nuevamente");
		}

		# redirect
		redirect( ["mod" => "apo", "date" => $date] );

	break;

	case 'notes':

		# vars
		$id = (int)pf('id');
		$date = pg('date', 10);
		$doctor_id = (Session::get_safe('roleId')==ROLE_DOCTOR) ? Session::get_safe('userId') : pg('did');
		$record = new Appointment($id);

		if($record->id()>0 && $record->notes()) {
			$global_alerts->success("La información se actualizó correctamente");
		} else {
			$global_alerts->error("Hubo un problema en la información, intentar nuevamente");
		}

		# redirect
		redirect( ["mod" => "apo", "date" => $date, "did" => $doctor_id] );

	break;

	default:

		# doctor
		$selected_doctor = (int)pf('seldoctor');
		$current_doctor = (int)pg('did');
		if(Session::get_safe('roleId')==ROLE_DOCTOR) {
			$doctor_id = Session::get_safe('userId');
		} elseif($selected_doctor>0) {
			$doctor_id = $selected_doctor;
		} elseif($current_doctor>0) {
			$doctor_id = $current_doctor;
		} else {
			$doctor_id = (int)sql_select_value("SELECT userId FROM admin_users WHERE rolId = ".ROLE_DOCTOR." AND deleted = 0 ORDER BY name ASC");
		}
		$doctor = new Doctor($doctor_id);

		# date
		$selected_date = pf('seldate');
		$current_date = pg('date');
		if($selected_date!="" && strtotime($selected_date)!==false) {
			$date = $selected_date;
		} elseif($current_date!="" && strtotime($current_date)!==false) {
			$date = $current_date;
		} else {
			$date = date("Y-m-d");
		}

		# create array
		$start = strtotime("$date ".DAY_HOUR_START);
		$end = strtotime("$date ".DAY_HOUR_END);
		$prev = date("Y-m-d", strtotime($date." -1 day"));
		$next = date("Y-m-d", strtotime($date." +1 day"));
		$int = $start;

		$intervals = array();
		while($int<$end) {
			$intervals[$int] = array("date" => date("Y-m-d", $int), "time" => date("H:i", $int), "blocked" => false, "apps" => false);
			$int = strtotime(date("Y-m-d H:i:s", $int)." +30 minutes");
		}

		$results = sql_select("	SELECT 	a.appointmentId, a.userId, a.doctorId, LEFT(a.appDateTime, 16) AS appDateTime, a.fields, s.appStatusId, sl.appStatus, u.userId, u.name, u.email
								FROM 	admin_appointments a, admin_appointments_status s, admin_appointments_status_lang sl, admin_users u 
								WHERE 	a.appStatusId = s.appStatusId AND s.appStatusId = sl.appStatusId AND a.userId = u.userId AND 
										sl.lang = '".$global_language->get()."' AND a.doctorId = $doctor_id AND a.appDateTime LIKE '$date%'");
		if($results) {
			foreach($results as $r) {
				$app_date = substr($r['appDateTime'], 0, 14);
				$minutes = ((int)substr(substr($r['appDateTime'], 11, 5), 3, 2)<16) ? "00" : "30";
				$time = strtotime($app_date.$minutes);
				if(isset($intervals[$time])) {
					if($r['appStatusId']==APP_BLOCKED) {
						$intervals[$time]['blocked'] = true;
					} else {
						$fields = fromdb($r['fields'], true);
						#var_dump($fields);
						$r['notes'] = (isset($fields['notes'])) ? $fields['notes'] : "";
						$intervals[$time]['apps'][] = $r;
					}
				}
			}
		}

		#var_dump($results);

		# view
		include(getview("appointments.index"));

	break;

}

?>
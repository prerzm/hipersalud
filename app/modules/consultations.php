<?php

switch($cmd) {

	case 'newpat':

		# vars
        $id = (int)pf('id');
		$did = (Session::get_safe('roleId')==ROLE_DOCTOR) ? Session::get_safe('userId') : pf('did');

		if($id>0) {
        	$record = new Patient($id);
		} else {

			$record = new Patient();
            $values['rolId'] = ROLE_PATIENT;
            $values['name'] = pf('name', 200);
            $values['email'] = pf('email', 200);
            $token = new Token("");
            $token->generate(array("email" => $values['email']), (int)TOKEN_SETPSWD_LIFE);
            $values['code'] = base64_encode($token->get_token());
            $values['fields'] = "";
            $values['notes'] = "";
            
            $record->set($values);
            $id = $record->add();

            if($id>0) {
                $record->send_welcome();
            }

		}

		if($did>0) {
			if($id>0) {
				redirect( array("mod" => "csu", "cmd" => "add", "id" => $id, "did" => $did) );
			} else {
				$global_alerts->error("Hubo un problema en la información, intentar nuevamente");
				redirect( array("mod" => "csu") );
			}
		} else {
			$global_alerts->error("Es necesario que seleccione al doctor de la consulta");
			redirect( array("mod" => "csu") );
		}

	break;

	case 'updatepat':

		# vars
		$id = (int)pg('id');
		$pid = (int)pg('pid');

		$record = new Consultation($id);
		$contact = new Patient($pid);

		if($record->id()>0 && $contact->id()>0) {

			if($contact->update()>0) {
				$global_alerts->success("La información se actualizó correctamente");
			} else {
				$global_alerts->error("Hubo un problema en la información, intentar nuevamente");
			}

		} else {
			$global_alerts->error("Hubo un problema al obtener el registro.");
		}

		# redirect
		redirect( array("mod" => "csu", "cmd" => "edit", "id" => $id) );

	break;

	case 'add':

		# vars
        $id = pg('id');
		$did = (Session::get_safe('roleId')==ROLE_DOCTOR) ? Session::get_safe('userId') : pg('did');
        $record = new Patient($id);

        # history
        $history = $record->get_history();
		$data = $record->get_graph_data();
		$app_data = $record->get_app_data();

		# view
		include(getview("consultations.add"));

	break;

    case 'save':

		# vars
		$record = new Consultation();
		$cid = $record->add();

		if($cid>0) {
			$record->set_params();
			$global_alerts->success("La información se actualizó correctamente");
		} else {
			$global_alerts->error("Hubo un problema en la información, intentar nuevamente");
		}

		# redirect
		redirect( array("mod" => "csu") );

    break;

	case 'edit':

		# vars
		$id = (int)pg('id');
		$record = new Consultation($id);
		$edit = $global_perms->can($mod, "EDIT");

		if($record->id()>0) {
			$contact = new Patient($record->get("userId"));
			$params = $record->get_params();
			$bmi = NumberFormat::float(Health::bmi($params->get("weight"), $contact->get("height")));
			$history = $contact->get_history();
		}

		# view
		include(getview("consultations.edit"));

	break;

	case 'update':

		# vars
        $id = (int)pg('id');
		$record = new Consultation($id);

		if($record->id()>0) {
			$record->update();
			$record->set_params();
			$global_alerts->success("La información se actualizó correctamente");
		} else {
			$global_alerts->error("Hubo un problema al obtener el registro.");
		}

		# redirect
		redirect( array("mod" => "csu", "cmd" => "edit", "id" => $id) );

	break;

	default:

		# queries
		if(Session::get_safe('roleId')==ROLE_DOCTOR) {
			$results = sql_select("SELECT a.appointmentId, a.appDateTime, u.name AS patient, u.email, TIMESTAMPDIFF(YEAR, u.dob, CURDATE()) AS age, 
										a.appStatusId, s.class, al.appStatus
									FROM admin_appointments a, admin_users u, admin_appointments_status s, admin_appointments_status_lang al 
									WHERE a.userId = u.userId AND a.appStatusId = s.appStatusId AND a.appStatusId = al.appStatusId AND 
										al.lang = '".$global_language->get()."' AND a.doctorId = ".Session::get_safe('userId')." AND u.deleted = 0 
									ORDER BY a.appDateTime DESC");
		} elseif(Session::get_safe('roleId')==ROLE_PATIENT) {
			$results = sql_select("SELECT a.appointmentId, a.appDateTime, u.name AS doctor, u.email, TIMESTAMPDIFF(YEAR, u.dob, CURDATE()) AS age, 
										a.appStatusId, s.class, al.appStatus
									FROM admin_appointments a, admin_users u, admin_appointments_status s, admin_appointments_status_lang al
									WHERE a.doctorId = u.userId AND a.appStatusId = s.appStatusId AND a.appStatusId = al.appStatusId AND 
										al.lang = '".$global_language->get()."' AND a.userId = ".Session::get_safe('userId')." AND u.deleted = 0 
									ORDER BY a.appDateTime DESC");
		} else {
			$results = sql_select("SELECT a.appointmentId, a.appDateTime, u.name AS patient, u.email, TIMESTAMPDIFF(YEAR, u.dob, CURDATE()) AS age, 
										a.appStatusId, s.class, al.appStatus, 
										d.name AS doctor 
									FROM admin_users u, admin_appointments_status s, admin_appointments_status_lang al, admin_appointments a 
										LEFT JOIN admin_users d ON a.doctorId = d.userId
									WHERE a.userId = u.userId AND a.appStatusId = s.appStatusId AND a.appStatusId = al.appStatusId AND 
										al.lang = '".$global_language->get()."' AND u.deleted = 0 
									ORDER BY a.appDateTime DESC");
		}

		# view
		include(getview("consultations.index"));

	break;

}

?>
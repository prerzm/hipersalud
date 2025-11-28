<?php

switch($cmd) {

	case 'add':

		# vars
		$record = new Patient();
        $values['rolId'] = ROLE_PATIENT;
        $values['companyId'] = (int)pf('companyId');
        $values['name'] = pf('name', 200);
        $values['email'] = pf('email', 200);
        $values['dob'] = pf('dob', 10);
		$token = new Token("");
		$token->generate(array("email" => $values['email']), (int)TOKEN_SETPSWD_LIFE);
		$values['code'] = base64_encode($token->get_token());
        $values['fields'] = todb(pf('fields'), true);
		$values['notes'] = "";
		
		$record->set($values);
		$id = $record->add();

		if($id>0) {
			$record->send_welcome();
			$global_alerts->success("La información se actualizó correctamente");
			redirect( array("mod" => "pat", "cmd" => "edit", "id" => $id) );
		} else {
			$global_alerts->error("Hubo un problema en la información, intentar nuevamente");
		}

		# redirect
		redirect( array("mod" => "pat") );

	break;

	case 'edit':

		# vars
		$id = (int)pg('id');
		$record = new Patient($id);
		$edit = $global_perms->can($mod, "EDIT");

        # queries
		$companies = Company::get_all_companies();
        $history = $record->get_history();
		$data = $record->get_graph_data();
		$app_data = $record->get_app_data();
		$app = $record->get_app_graph_points();

		# view
		include(getview("patients.edit"));

	break;

	case 'update':

		# vars
		$id = (int)pg('id');
		$record = new Patient($id);

		if($record->id()>0) {

			if($record->update()>0) {
				$global_alerts->success("La información se actualizó correctamente");
			} else {
				$global_alerts->error("Hubo un problema en la información, intentar nuevamente");
			}

		} else {
			$global_alerts->error("Hubo un problema al obtener el registro.");
		}

		# redirect
		redirect( array("mod" => "pat", "cmd" => "edit", "id" => $id) );

	break;

	case 'delete':

		if($global_perms->can($mod, "DELETE")) {

			# vars
			$id = (int)pg('id');
			$record = new Patient($id);

			if($record->delete()) {
				$global_alerts->success("La información se actualizó correctamente");
			} else {
				$global_alerts->error("Hubo un problema en la información, intentar nuevamente");
			}

		} else {
			$global_alerts->error("No cuenta con los permisos necesarios.");
		}

		# redirect
		redirect( ["mod" => "pat"] );

	break;

	default:

		# queries
		$results = sql_select("	SELECT u.*, TIMESTAMPDIFF(YEAR, u.dob, CURDATE()) AS age, c.name AS company
								FROM admin_users u, admin_companies c WHERE u.companyId = c.companyId AND u.rolId = ".ROLE_PATIENT." AND u.deleted = 0");
		$companies = Company::get_all_companies();

		# view
		include(getview("patients.index"));

	break;

}

?>
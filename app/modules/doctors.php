<?php

switch($cmd) {

	case 'add':

		# vars
		$values['rolId'] = ROLE_DOCTOR;
		$values['name'] = pf('name');
		$values['email'] = pf('email');
        $values['dob'] = pf('dob');
		$values['fields'] = "";

		$record = new Patient();
		$record->set($values);

		$id = $record->add();

		if($id>0) {
			$global_alerts->success("La información se actualizó correctamente");
			redirect( array("mod" => "doc", "cmd" => "edit", "id" => $id) );
		} else {
			$global_alerts->error("Hubo un problema en la información, intentar nuevamente");
		}

		# redirect
		redirect( array("mod" => "doc") );

	break;

	case 'edit':

		# vars
		$id = (int)pg('id');
		$record = new Patient($id);
		$edit = $global_perms->can($mod, "EDIT");

		# view
		include(getview("doctors.edit"));

	break;

	case 'update':

		# vars
		$id = (int)pg('id');
		$record = new Patient($id);

		if($record->id()>0) {

			$values['name'] = pf('name');
			$values['email'] = pf('name');
			$values['dob'] = pf('name');
			$values['fields'] = todb($_POST['fields']);

			$record->clear();
			$record->set($values);

			if($record->update()>0) {
				$global_alerts->success("La información se actualizó correctamente");
			} else {
				$global_alerts->error("Hubo un problema en la información, intentar nuevamente");
			}

		} else {
			$global_alerts->error("Hubo un problema al obtener el registro.");
		}

		# redirect
		redirect( array("mod" => "doc", "cmd" => "edit", "id" => $id) );

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
		redirect( ["mod" => "doc"] );

	break;

	default:

		# queries
		$results = sql_select("SELECT *, TIMESTAMPDIFF(YEAR, dob, CURDATE()) AS age FROM admin_users WHERE rolId = ".ROLE_DOCTOR." AND deleted = 0");

		# view
		include(getview("doctors.index"));

	break;

}

?>
<?php

switch($cmd) {

	case 'add':

		# vars
		$record = new Doctor();
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
		$record = new Doctor($id);
		$edit = $global_perms->can($mod, "EDIT");

		if($record->id()==0)  {
			$global_alerts->error("Hubo un problema al obtener la información, intentar nuevamente");
			redirect( array("mod" => "doc") );
		}

		$consultations = $record->get_consultations();
		if($consultations) {
			for($i=0; $i<count($consultations); $i++) {
				$fields = fromdb($consultations[$i]['fields'], true);
				$consultations[$i]['notes'] = ($fields['notes']) ?? "-";
			}
		}

		# view
		include(getview("doctors.edit"));

	break;

	case 'update':

		# vars
		$id = (int)pg('id');
		$record = new Doctor($id);

		if($record->id()>0) {

			$values['name'] = pf('name');
			$values['email'] = pf('name');
			$values['fields'] = todb($_POST['fields'], true);

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
			$record = new Doctor($id);

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
		$results = sql_select("SELECT * FROM admin_users WHERE rolId = ".ROLE_DOCTOR." AND deleted = 0");

		if($results) {
			for($i=0; $i<count($results); $i++) {
				$fields = fromdb($results[$i]['fields'], true);
				$results[$i]['esp'] = ($fields['esp']) ?? "-";
			}
		}

		# view
		include(getview("doctors.index"));

	break;

}

?>
<?php

switch($cmd) {

	case 'add':

		# vars
		$record = new Patient();
		
		$id = $record->add();

		if($id>0) {
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

        # history
        $history = $record->get_history();
		$data = $record->get_graph_data();
		$app_data = $record->get_app_data();
		$app = $record->get_app_graph_points();

		print "<pre>";
		var_dump($app);
		print "</pre>";

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
		$results = sql_select("SELECT *, TIMESTAMPDIFF(YEAR, dob, CURDATE()) AS age FROM admin_users WHERE rolId = ".ROLE_PATIENT." AND deleted = 0");

		# view
		include(getview("patients.index"));

	break;

}

?>
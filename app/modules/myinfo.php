<?php

switch($cmd) {

	case 'update':

		# vars
		$id = Session::get_safe('userId');
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

	case 'paramsadd':

		# vars
		$id = Session::get_safe('userId');
		$record = new Patient($id);

		if($record->id()>0) {

			if($record->params_add()>0) {
				$global_alerts->success("La información se actualizó correctamente");
			} else {
				$global_alerts->error("Hubo un problema en la información, intentar nuevamente");
			}

		} else {
			$global_alerts->error("Hubo un problema al obtener el registro.");
		}

		# redirect
		redirect( array("mod" => "inf") );

	break;

	default:

		# vars
		$id = Session::get_safe("userId");
		$record = new Patient($id);

		$appointments = $record->get_appointments();
		$data = $record->get_data("desc");

		# view
		include(getview("myinfo.index"));

	break;

}

?>
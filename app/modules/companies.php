<?php

switch($cmd) {

	case 'add':

		# vars
		$record = new Company();
		$id = $record->add();

		if($id>0) {
			$global_alerts->success("La información se actualizó correctamente");
			redirect( array("mod" => "com", "cmd" => "edit", "id" => $id) );
		} else {
			$global_alerts->error("Hubo un problema en la información, intentar nuevamente");
		}

		# redirect
		redirect( array("mod" => "com") );

	break;

	case 'edit':

		# vars
		$id = (int)pg('id');
		$record = new Company($id);

		if($record->id()==0)  {
			$global_alerts->error("Hubo un problema al obtener la información, intentar nuevamente");
			redirect( array("mod" => "com") );
		}

        $results = $record->get_employees_data();

		# view
		include(getview("companies.edit"));

	break;

	case 'update':

		# vars
		$id = (int)pg('id');
		$record = new Doctor($id);

		if($record->id()>0) {

			$values['name'] = pf('name');
			$values['email'] = pf('name');
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
		redirect( array("mod" => "com", "cmd" => "edit", "id" => $id) );

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
		redirect( ["mod" => "com"] );

	break;

	default:

		# queries
		$results = sql_select(" SELECT c.companyId, c.name, c.city, IFNULL(u.total, 0) AS employees
                                FROM admin_companies c LEFT JOIN 
                                    (SELECT companyId, COUNT(companyId) AS total FROM admin_users u WHERE deleted = 0 GROUP BY companyId) u ON c.companyId = u.companyId
                                WHERE c.deleted = 0;");

		# view
		include(getview("companies.index"));

	break;

}

?>
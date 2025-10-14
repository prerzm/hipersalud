<?php

switch($cmd) {

	case 'add':

		# vars
		$values['name'] = pg('name');
		$values['type'] = pg('type');
        $values['size'] = pg('size');
        $values['label'] = pg('label');
		$values['required'] = (int)pg('required');
        $values['minLen'] = (int)pg('minLen');
        $values['maxLen'] = (int)pg('maxLen');

		# record
		$record = new Field();
		$record->set($values);

		if($record->add()>0) {
			$global_alerts->success("La información se actualizó correctamente");
		} else {
			$global_alerts->error("Hubo un problema en la información, intentar nuevamente");
		}

		# redirect
		redirect( array("mod" => "fie") );

	break;

	case 'edit':

		# vars
		$id = (int)pg('id');
		$record = new Field($id);

		# view
		include(getview("fields.edit"));

	break;

	case 'update':

		# vars
		$record = new Field((int)pg('id'));

		if($record->id()>0) {

			$record->clear();

            $values['name'] = pg('name');
            $values['type'] = pg('type');
            $values['size'] = pg('size');
            $values['label'] = pg('label');
            $values['required'] = (int)pg('required');
            $values['minLen'] = (int)pg('minLen');
            $values['maxLen'] = (int)pg('maxLen');

			$record->set($values);

			if($record->update()>0) {
				$global_alerts->success("La información se actualizó correctamente");
			} else {
				$global_alerts->error("Hubo un problema en la información, intentar nuevamente");
			}
	
		} else {
			$global_alerts->error("Hubo un problema al obtener al registro.");
		}

		# redirect
		redirect( array("mod" => "fie") );

	break;

	case 'delete':

		# vars
		$id = (int)pg('id');
		$record = new Field($id);

		if($record->delete()) {
			$global_alerts->success("La información se actualizó correctamente");
		} else {
			$global_alerts->error("Hubo un problema en la información, intentar nuevamente");
		}

		# redirect
		redirect( ["mod" => "fie"] );

	break;

	default:

		# queries
		if(Session::get_safe("roleId")==ROLE_WEBMASTER) {
			$results = sql_select("SELECT * FROM admin_fields ORDER BY name ASC");
		} else {
            $results = sql_select("SELECT * FROM admin_fields WHERE deleted = 0 ORDER BY name ASC");
		}

		# view
		include(getview("fields.index"));

	break;

}

?>
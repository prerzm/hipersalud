<?php

switch($cmd) {

	case 'add':

		# vars
		$values['rol'] = pf('rol');

		# role
		$record = new Role();
		$record->set($values);

		if($record->add()>0) {
			$global_alerts->success("La información se actualizó correctamente");
		} else {
			$global_alerts->error("Hubo un problema en la información, intentar nuevamente");
		}

		# redirect
		redirect( array("mod" => "rol") );

	break;

	case 'edit':

		# vars
		$id = (int)pg('id');
		$record = new Role($id);

		# queries
		if(Session::get_safe("roleId")==ROLE_WEBMASTER) {
			$modules = sql_select("SELECT m.moduloId, ml.lang, ml.modulo FROM admin_modulos m, admin_modulos_lang ml 
									WHERE m.moduloId = ml.moduloId AND ml.lang = '".$global_language->get()."' ORDER BY orden ASC");
		} else {
			$modules = sql_select("SELECT m.moduloId, ml.lang, ml.modulo FROM admin_modulos m, admin_modulos_lang ml 
									WHERE m.moduloId = ml.moduloId AND m.master = 0 AND m.deleted = 0 AND ml.lang = '".$global_language->get()."' 
									ORDER BY orden ASC");
		}

		if($modules) {
			$max_perms = 0;
			for($i=0; $i<count($modules); $i++) {
				$modules[$i]['perms'] = sql_select("SELECT mp.*, IF(rp.rolPermisoId, 1, 0) AS hasPerm
													FROM admin_modulos_permisos mp 
														LEFT JOIN (SELECT * FROM admin_roles_permisos WHERE rolId = $id) rp ON mp.permisoId = rp.permisoId
													WHERE mp.moduloId = ".$modules[$i]['moduloId']." 
													ORDER BY mp.permisoId ASC");
				if($modules[$i]['perms']) {
					$max_perms = (count($modules[$i]['perms'])>$max_perms) ? count($modules[$i]['perms']) : $max_perms;
				}
			}
		}

		# view
		include(getview("roles.edit"));

	break;

	case 'update':

		# vars
		$record = new Role((int)pg('id'));

		if($record->id()>0) {

			$record->clear();
			$values['rol'] = pf('rol');
			$record->set($values);

			$record->update();
			$record->set_perms($_POST['perms']);

			$global_alerts->success("La información se actualizó correctamente");
	
		} else {
			$global_alerts->error("Hubo un problema al obtener la información.");
		}

		# redirect
		redirect( array("mod" => "rol") );

	break;

	case 'delete':

		# vars
		$record = new Role((int)pg('id'));

		if($record->delete()) {
			$global_alerts->success("La información se actualizó correctamente");
		} else {
			$global_alerts->error("Hubo un problema en la información, intentar nuevamente");
		}

		# redirect
		redirect( ["mod" => "usu"] );

	break;

	default:

		# queries
		if(Session::get_safe("roleId")==ROLE_WEBMASTER) {
			$results = sql_select(" SELECT * FROM admin_roles");
		} else {
			$results = sql_select("SELECT * FROM admin_roles WHERE deleted = 0 AND rolId <> ".ROLE_WEBMASTER);
		}

		# view
		include(getview("roles.index"));

	break;

}

?>
<?php

switch($cmd) {

	case 'add':

		# vars
		$values['moduloKey'] = pf('moduloKey');
		$values['menuParentKey'] = pf('menuParentKey');
		$values['menuIcon'] = pf('menuIcon');
		$values['orden'] = (int)pf('orden');

		# record
		$record = new Module();
		$record->set($values);
		$id = $record->add();

		# lang
		if($id>0) {
			$es = pf('es');
			$es['moduloId'] = $id;
			$es['lang'] = "es";
			query_insert("admin_modulos_lang", $es);
			$en = pf('en');
			$en['moduloId'] = $id;
			$en['lang'] = "en";
			query_insert("admin_modulos_lang", $en);
		}

		if($id>0) {
			$global_alerts->success("La información se actualizó correctamente");
		} else {
			$global_alerts->error("Hubo un problema en la información, intentar nuevamente");
		}

		# redirect
		redirect( array("mod" => "mod") );

	break;

	case 'edit':

		# vars
		$id = (int)pg('id');
		$record = new Module($id);
		$lang_es = $record->get_lang("es");
		$lang_en = $record->get_lang("en");
		$results = $record->get_perms();

		# view
		include(getview("modules.edit"));

	break;

	case 'update':

		# vars
		$id = (int)pg('id');
		$record = new Module($id);

		if($record->id()>0) {

			$record->clear();

			$values['moduloKey'] = pf('moduloKey');
			$values['menuParentKey'] = pf('menuParentKey');
			$values['menuIcon'] = pf('menuIcon');
			$values['orden'] = (int)pf('orden');
			
			$record->set($values);

			# lang
			query_update("admin_modulos_lang", pf('es'), "moduloId = $id AND lang = 'es'");
			query_update("admin_modulos_lang", pf('en'), "moduloId = $id AND lang = 'en'");

			if($record->update()>0) {
				$global_alerts->success("La información se actualizó correctamente");
			} else {
				$global_alerts->error("Hubo un problema en la información, intentar nuevamente");
			}
	
		} else {
			$global_alerts->error("Hubo un problema al obtener al registro.");
		}

		# redirect
		redirect( array("mod" => "mod", "cmd" => "edit", "id" => $id) );

	break;

	case 'delete':

		# vars
		$id = (int)pg('id');
		$record = new Module($id);

		if($record->delete()) {
			$global_alerts->success("La información se actualizó correctamente");
		} else {
			$global_alerts->error("Hubo un problema en la información, intentar nuevamente");
		}

		# redirect
		redirect( ["mod" => "usu"] );

	break;

	case 'addperm':

		# vars
		$id = (int)pg('id');
		$record = new Module($id);

		if($record->id()>0) {

			$updated = $record->add_perm(pf('permisoKey'), pf('permiso'));

			if($updated>0) {
				$global_alerts->success("La información se actualizó correctamente");
			} else {
				$global_alerts->error("Hubo un problema en la información, intentar nuevamente");
			}
	
		} else {
			$global_alerts->error("Hubo un problema al obtener al registro.");
		}

		# redirect
		redirect( array("mod" => "mod", "cmd" => "edit", "id" => $id) );

	break;

	case 'editperm':

		# vars
		$id = (int)pg('id');
		$pid = (int)pg('pid');
		$module = new Module($id);
		$record = new Perm($pid);

		# view
		include(getview("modules.edit.perm"));

	break;

	case 'updateperm':

		# vars
		$id = (int)pg('id');
		$pid = (int)pg('pid');
		$record = new Perm($pid);

		if($record->id()>0) {

			$record->clear();
			$values['permisoKey'] = pf('permisoKey');
			$values['permiso'] = pf('permiso');
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
		redirect( array("mod" => "mod", "cmd" => "edit", "id" => $id) );

	break;

	case 'delperm':

		# vars
		$id = (int)pg('id');
		$record = new Module($id);

		if($record->id()>0) {

			$updated = $record->del_perm((int)pg('pid'));

			if($updated>0) {
				$global_alerts->success("La información se actualizó correctamente");
			} else {
				$global_alerts->error("Hubo un problema en la información, intentar nuevamente");
			}
	
		} else {
			$global_alerts->error("Hubo un problema al obtener al registro.");
		}

		# redirect
		redirect( array("mod" => "mod", "cmd" => "edit", "id" => $id) );

	break;

	default:

		# queries
		if(Session::get_safe("roleId")==ROLE_WEBMASTER) {
			$results = sql_select("	SELECT m.*, ml.menuParentName, ml.modulo  
									FROM admin_modulos m, admin_modulos_lang ml
									WHERE m.moduloId = ml.moduloId AND ml.lang = '".$global_language->get()."' 
									ORDER BY orden ASC");
		} else {
			$results = sql_select("SELECT * FROM admin_modulos WHERE master = 0 ORDER BY orden ASC");
		}

		# view
		include(getview("modules.index"));

	break;

}

?>
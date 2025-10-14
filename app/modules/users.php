<?php

switch($cmd) {

	case 'add':

		# vars
		$values['name'] = pf('name');
		$values['rolId'] = (int)pf('rolId');
		$values['email'] = pf('email');
		$values['password'] = Crypt::hash(pf('password'));
		$values['fields'] = "";

		# user
		$user = new User();
		$user->set($values);

		if($user->add()>0) {
			$global_alerts->success("La información se actualizó correctamente");
		} else {
			$global_alerts->error("Hubo un problema en la información, intentar nuevamente");
		}

		# redirect
		redirect( array("mod" => "use") );

	break;

	case 'edit':

		# vars
		$id = (int)pg('id');
		$user = new User($id);

		# queries
		if(Session::get_safe("roleId")==ROLE_WEBMASTER) {
			$roles = sql_select("SELECT * FROM admin_roles ORDER BY rol ASC");
		} else {
			$roles = sql_select("SELECT * FROM admin_roles WHERE rolId <> ".ROLE_WEBMASTER." ORDER BY rol ASC");
		}

		# view
		include(getview("users.edit"));

	break;

	case 'update':

		# vars
		$user = new User((int)pg('id'));

		if($user->id()>0) {

			$user->clear();

			$values['name'] = pf('name');
			$values['rolId'] = (int)pf('rolId');
			$values['email'] = pf('email');
			$password = trim(pf('password'));
			if($password!="") {
				$values['password'] = Crypt::hash($password);
			}
			
			$user->set($values);

			if($user->update()>0) {
				$global_alerts->success("La información se actualizó correctamente");
			} else {
				$global_alerts->error("Hubo un problema en la información, intentar nuevamente");
			}
	
		} else {
			$global_alerts->error("Hubo un problema al obtener al registro.");
		}

		# redirect
		redirect( array("mod" => "use") );

	break;

	case 'delete':

		# vars
		$id = (int)pg('id');
		$user = new User($id);

		if($user->delete()) {
			$global_alerts->success("La información se actualizó correctamente");
		} else {
			$global_alerts->error("Hubo un problema en la información, intentar nuevamente");
		}

		# redirect
		redirect( ["mod" => "use"] );

	break;

	default:

		# queries
		if(Session::get_safe("roleId")==ROLE_WEBMASTER) {
			$results = sql_select("SELECT u.userId, u.name, u.email, r.rol FROM admin_users u, admin_roles r WHERE u.rolId = r.rolId");
			$roles = sql_select("SELECT * FROM admin_roles ORDER BY rol ASC");
		} else {
			$results = sql_select("SELECT u.userId, u.name, u.email, r.rol FROM admin_users u, admin_roles r WHERE u.rolId = r.rolId AND r.rolId <> ".ROLE_WEBMASTER);
			$roles = sql_select("SELECT * FROM admin_roles WHERE rolId <> ".ROLE_WEBMASTER." ORDER BY rol ASC");
		}

		# view
		include(getview("users.index"));

	break;

}

?>
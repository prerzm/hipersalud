<?php

# login

switch($cmd) {

	case 'login':

		if(Login::log_in( pf('email', 100), pf('password', 50) )===false) {
			$global_alerts->error("El usuario o contraseña son incorrectos!");
		}

		$global_language->set(pf('language'));

		if(Session::get_safe('roleId')==ROLE_DOCTOR) {
			redirect(array("mod" => "apo"));
		} else {
			redirect();
		}

	break;

	case 'logout':

		Login::logout();

		redirect();

	default:

		#$val = cookie_get("lang");
		#var_dump($val);
		#die();
		
		# view
		include(getview("login.index"));

	break;

}

?>
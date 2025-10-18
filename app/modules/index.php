<?php

# default

switch($cmd) {

	default:

		# vars
		$role_id = Session::get_safe("roleId");

		if($role_id==ROLE_PATIENT) {
			$record = new Patient(Session::get_safe("userId"));
			$data = $record->get_graph_data();
			$app_data = $record->get_app_data();
		}

		$pat = new Patient(9);
		$points = $pat->get_app_graph_points();
		$data = $pat->get_graph_data();
		$app = $pat->get_app_data();

		

		# view
		include(getview());

	break;

}

?>
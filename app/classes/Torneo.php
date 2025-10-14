<?php

class Torneo {

	protected $id;
	protected $torneo;

	public function __construct($id) {
		$this->id = $id;
	}

	public function get_torneo() {
		$this->torneo = get_record("torneos", "torneo_id = ".$this->id);
		return $this->torneo;
	}

	public function get_jornadas() {
		return sql_select("SELECT * FROM jornadas WHERE torneo_id = ".$this->id);
	}

	public function get_equipos() {
		return sql_select("	SELECT e.equipo_id, e.equipo_nombre, e.equipo_logo 
							FROM equipos_torneos et, equipos e 
							WHERE e.equipo_id = et.equipo_id AND et.torneo_id = ".$this->id."
							ORDER BY e.equipo_nombre ASC");
	}

	public function get_equipos_restantes() {
		return sql_select(" SELECT e.equipo_id, e.equipo_nombre 
							FROM equipos e 
							WHERE e.tipo = '".$this->torneo['torneo_tipo']."' AND e.equipo_id NOT IN (SELECT equipo_id FROM equipos_torneos WHERE torneo_id = ".$this->id.")
							ORDER BY e.equipo_nombre ASC");
	}

	public function get_usuarios() {
		return sql_select("	SELECT u.usuario_id, u.usuario_nombre, u.usuario_email, u.title 
							FROM usuarios u, usuarios_torneos ut 
							WHERE u.usuario_id = ut.usuario_id AND ut.torneo_id = ".$this->id."
							ORDER BY u.usuario_nombre ASC");
	}

	public function get_usuarios_restantes() {
		return sql_select("	SELECT u.usuario_id, u.usuario_nombre 
							FROM usuarios u 
							WHERE u.usuario_id NOT IN (SELECT usuario_id FROM usuarios_torneos WHERE torneo_id = ".$this->id.") AND u.activo = 1 AND u.deleted = 0
							ORDER BY u.usuario_nombre ASC");
	}

	public function get_usuarios_emails() {
		
		$results = $this->get_usuarios();
		$users_mails = array();
		foreach($results as $r) {
			$email = filter_var($r['usuario_email'], FILTER_SANITIZE_EMAIL);
			$email = filter_var($email, FILTER_VALIDATE_EMAIL);
			if($email!==false) {
				$users_mails[] = $email;
			}
		}

		return $users_mails;
	}

	public function is_active() {
		return (bool)$this->torneo['activo'];
	}

	public function allow_active() {

		$jornada_id = (int)sql_select_value("SELECT jornada_id FROM jornadas WHERE torneo_id = ".$this->id." ORDER BY jornada_id ASC LIMIT 0, 1");
		if($jornada_id>0) {
			$partidos = sql_select_value("SELECT COUNT(*) AS total FROM partidos WHERE jornada_id = $jornada_id");
			if($jornada_id>0 && $partidos>0 && file_exists(PATH_TORNEOS_IMGS.$this->torneo['torneo_background']) && is_file(PATH_TORNEOS_IMGS.$this->torneo['torneo_background'])) {
				return true;
			}
		}

		return false;

	}

	public function activate() {

		global $global_alerts;

		if($this->allow_active()) {
			$jornada_id = (int)sql_select_value("SELECT jornada_id FROM jornadas WHERE torneo_id = ".$this->id." ORDER BY jornada_id ASC LIMIT 0, 1");
			$updated = query_update("torneos", array("jornada_id" => $jornada_id, "activo" => 1), "torneo_id = ".$this->id);
			if($updated) {
				return true;
			}
		}

		return false;

	}

	public function deactivate() {

		global $global_alerts;

		$active = sql_select_value("SELECT torneo_id FROM torneos WHERE torneo_id <> ".$this->id." AND activo = 1");
		if($active) {
			$updated = query_update("torneos", array("activo" => 0), "torneo_id = ".$this->id);
			if($updated) {
				return true;
			}
		} else {
			$global_alerts->error("El torneo no se pudo desactivar, tiene que haber al menos 1 torneo activo");
		}

		return false;

	}

	public function notify_jornada() {

		$jor = new Jornada($this->torneo['jornada_id']);
		$info = $jor->get_jornada();

		$mail = new PREMailer();
		$result = $mail->jornada_activa($info['jornada_nombre'], date("d/m/Y", strtotime($info['jornada_inicio']))." a las ".date("H:i", strtotime($info['jornada_inicio'])), $this->get_usuarios_emails());

		if($result!==true) {
			$global_alerts->error($result);
		}

	}

	public function delete() {
		
		$tor = query_delete("torneos", "torneo_id = ".$this->id);
		$equ = query_delete("equipos_torneos", "torneo_id = ".$this->id);
		$usu = query_delete("usuarios_torneos", "torneo_id = ".$this->id);

		return ($tor && $equ && $usu) ? true : false;

	}

	public function update_campeon($campeon_id) {
		return query_update("torneos", array("torneo_campeon_id" => $campeon_id), "torneo_id = ".$this->id);
	}

	public static function get_default_torneo() {
		return sql_select_row("SELECT * FROM torneos WHERE activo = 1 ORDER BY torneo_id ASC LIMIT 0, 1");
	}

}
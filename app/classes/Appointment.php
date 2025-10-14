<?php

class Appointment extends Record {

    protected $key = "appointmentId";
    protected $table = "admin_appointments";

    public function add() {

        # user
        $pid = (int)pf('pid');

		if($pid>0) {
        	$patient = new Patient($pid);
		} else {
			$patient = new Patient();
			$pid = $patient->add();
		}

        # appointment
        $doctor_id = (Session::get_safe('roleId')==ROLE_DOCTOR) ? Session::get_safe('userId') : pf('did');
		$date = pf('date');
        $time = pf('time');
		$datetime = $date." ".$time;
		$values['userId'] = $patient->id();
        $values['doctorId'] = (int)$doctor_id;
		$values['appDateTime'] = $datetime;
        $values['fields'] = todb(pf('fields'), true);

        return query_insert("admin_appointments", $values);

    }

    public function notes() {
        $fields = $this->fields;
        $fields['notes'] = pf('notes');
        $values['fields'] = todb($fields, true);
        $this->fields = $fields;
        return query_update($this->table, $values, $this->key." = ".$this->id);
    }

    public function schedule() {
        return query_update($this->table, ["appStatusId" => APP_SCHEDULED], $this->key." = ".$this->id);
    }

    public function attended() {
        return query_update($this->table, ["appStatusId" => APP_ATTENDED], $this->key." = ".$this->id);
    }

    public function missed() {
        return query_update($this->table, ["appStatusId" => APP_MISSED], $this->key." = ".$this->id);
    }

}
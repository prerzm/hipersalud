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

            $pat_val['rolId'] = ROLE_PATIENT;
            $pat_val['name'] = pf('name', 200);
            $pat_val['email'] = pf('email', 200);
            $token = new Token("");
            $token->generate(array("email" => $pat_val['email']), (int)TOKEN_SETPSWD_LIFE);
            $pat_val['code'] = base64_encode($token->get_token());
            $pat_val['fields'] = "";
            $pat_val['notes'] = "";
            
            $patient->set($pat_val);
            $pid = $patient->add();

            if($pid>0) {
                $patient->send_welcome();
            }
            
		}

        # appointment
        if($pid>0) {
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

        return -1;

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
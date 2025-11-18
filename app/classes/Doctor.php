<?php

class Doctor extends Record {

    protected $key = "userId";
    protected $table = "admin_users";
    protected $query = "SELECT *, TIMESTAMPDIFF(YEAR, dob, CURDATE()) AS age FROM TABLE WHERE rolId = ".ROLE_DOCTOR." AND KEY = ID";

    public function add() {
        $values['rolId'] = ROLE_DOCTOR;
        $values['name'] = pf('name', 200);
        $values['email'] = pf('email', 200);
        $values['fields'] = "";
        $values['notes'] = "";

        # password
        if(pf('password')!="") {
            $values['password'] = Crypt::hash(pf('password'));
        }

        $this->set($values);
        return parent::add();
    }

    public function update() {

        $values['name'] = pf('name');
        $values['email'] = pf('email');
        $values['fields'] = todb(pf('fields'), true);

        # password
        if(pf('password')!="") {
            $values['password'] = Crypt::hash(pf('password'));
        }

        $this->clear();
        $this->set($values);

        return query_update($this->table, $this->info, $this->key." = ".$this->id);

    }

    public function get_consultations($limit=0) {
        $sql_limit = ($limit>0) ? "LIMIT 0, 20" : "";
        return sql_select("SELECT a.appointmentId, a.appDateTime, a.fields, u.userId, u.name, asl.appStatusId, s.class, asl.appStatus
                            FROM admin_appointments a, admin_appointments_status s, admin_appointments_status_lang asl, admin_users u 
                            WHERE a.userId = u.userId AND a.appStatusId = s.appStatusId AND a.appStatusId = asl.appStatusId AND 
                                    asl.lang = 'en' AND a.doctorId = ".$this->id."
                            ORDER BY a.appDateTime DESC
                            $sql_limit");
    }

}

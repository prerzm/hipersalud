<?php

class Consultation extends Record {

    protected $key = "appointmentId";
    protected $table = "admin_appointments";

    public function add() {
        $values['userId'] = (int)pg('id');
        $values['doctorId'] = (int)pg('did');
        $values['appStatusId'] = APP_ATTENDED;
        $values['fields'] = todb(pf('fields'), true);
        $this->set($values);
        return parent::add();
    }

    public function update() {
        $values['appStatusId'] = APP_ATTENDED;
        $values['fields'] = todb(pf('fields'), true);
        $this->set($values);
        return query_update($this->table, $values, $this->key." = ".$this->id);
    }

    public function get_params() {
        $params_id = (int)sql_select_value("SELECT paramsId FROM admin_users_params WHERE appointmentId = ".$this->id);
        return new PatientParams($params_id);
    }

    public function set_params() {
        $params_id = (int)sql_select_value("SELECT paramsId FROM admin_users_params WHERE appointmentId = ".$this->id);
        $values['fields'] = todb(pf('params'), true);
        if($params_id>0) {
            return query_update("admin_users_params", $values, "paramsId = $params_id");
        } else {
            $values['userId'] = $this->get('userId');
            $values['appointmentId'] = $this->id();
            return query_insert("admin_users_params", $values);
        }
    }

}
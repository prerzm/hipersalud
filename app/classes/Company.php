<?php

class Company extends Record {

    protected $key = "companyId";
    protected $table = "admin_companies";

    public function add() {
        $values['name'] = pf('name', 200);
        $values['city'] = pf('city', 100);
        $this->set($values);
        return parent::add();
    }

    public function get_employees_data() {
        return sql_select(" SELECT u.userId, u.dateCreated, u.name, IFNULL(a.lastDate, '-') AS lastDate, IFNULL(p.lastParams, '-') AS lastParams
                            FROM admin_users u 
                            LEFT JOIN
                                (SELECT userId, MAX(appDateTime) AS lastDate FROM admin_appointments 
                                WHERE appStatusId = ".APP_ATTENDED." GROUP BY userId) a ON a.userId = u.userId
                            LEFT JOIN
                                (SELECT userId, MAX(paramDateTime) AS lastParams FROM admin_users_params 
                                WHERE appointmentId = 0 GROUP BY userId) p ON p.userId = u.userId
                            WHERE u.rolId = ".ROLE_PATIENT." AND u.companyId = ".$this->id);
    }

    public static function get_all_companies() {
        return sql_select(" SELECT companyId, name FROM admin_companies WHERE deleted = 0 ORDER BY name ASC");
    }
    
}

<?php

class Patient extends Record {

    protected $key = "userId";
    protected $table = "admin_users";
    protected $query = "SELECT *, TIMESTAMPDIFF(YEAR, dob, CURDATE()) AS age FROM TABLE WHERE rolId = ".ROLE_PATIENT." AND KEY = ID";

    public function add() {
        $values['rolId'] = ROLE_PATIENT;
        $values['name'] = pf('name', 200);
        $values['email'] = pf('email', 200);
        $values['dob'] = pf('dob', 10);
        $values['fields'] = todb(pf('fields'), true);
        $this->set($values);
        return parent::add();
    }

    public function update() {

        $values['name'] = pf('name');
        $values['email'] = pf('email');
        $values['dob'] = pf('dob', 10);
        $values['fields'] = todb(pf('fields'), true);

        # password
        if(pf('password')!="") {
            $values['password'] = Crypt::hash(pf('password'));
        }

        $this->clear();
        $this->set($values);

        return query_update($this->table, $this->info, $this->key." = ".$this->id);

    }

    public function get_history() {
        $history = array();
        $results = sql_select("SELECT a.appointmentId, a.appDateTime, a.fields, p.paramsId, p.fields AS params FROM admin_appointments a, admin_users_params p 
                                WHERE a.appointmentId = p.appointmentId AND a.userId = ".$this->id." ORDER BY appDateTime DESC LIMIT 0, 30");
        if($results) {
            foreach($results as $r) {
                $f = fromdb($r['fields'], true);
                $p = fromdb($r['params'], true);
                $history[] = array(
                    "appointmentId" => $r['appointmentId'],
                    "date" => DateLang::short($r['appDateTime']), 
                    "weight" => $p['weight'], 
                    "bmi" => NumberFormat::float(Health::bmi($p['weight'], $this->get("height"))), 
                    "fc" => $p['fc'], 
                    "bp" => $p['presis']."/".$p['predia'], 
                    "glu" => (isset($p['glu'])) ? $p['glu'] : 0, 
                    "diagnosis" => $f['diagnosis'], 
                    "notes" => $f['notes']
                );
            }
        }
        return $history;
    }

    public function get_appointments() {
        global $global_language;
        $apps = array();
        $results = sql_select("SELECT a.appointmentId, a.appDateTime, aps.appStatusId, aps.class, al.appStatus, u.name
                                FROM admin_appointments a, admin_appointments_status aps, admin_appointments_status_lang al, admin_users u
                                WHERE a.appStatusId = aps.appStatusId AND a.appStatusId = al.appStatusId AND a.doctorId = u.userId AND 
                                    al.lang = '".$global_language->get()."' AND a.userId = ".$this->id."
                                ORDER BY a.appDateTime DESC
                                LIMIT 0, 20");
        return $results;
    }

    public function params_add() {
        $params = new PatientParams();
        $values['userId'] = $this->id;
        $values['fields'] = todb(pf('fields'), true);
        $params->set($values);
        return $params->add();
    }

   public function get_app_data() {
        global $global_language;
        $graph_data = array();
        $results = sql_select("SELECT al.appStatusId, al.appStatus, COUNT(a.appStatusId) AS total
                                    FROM admin_appointments_status_lang al LEFT JOIN 
                                        (SELECT * FROM admin_appointments WHERE userId = ".$this->id.") a ON al.appStatusId = a.appStatusId
                                    WHERE al.lang = '".$global_language->get()."' 
                                    GROUP BY al.appStatusId 
                                    ORDER BY al.appStatusId ASC");
        if($results) {
            $labels = "";
            $data = "";
            $total = 0;
            foreach($results as $r) {
                $total += $r['total'];
            }
            if($total>0) {
                foreach($results as $r) {
                    $subtotal = (int)($r['total']/$total*100);
                    $labels .= "'".$r['appStatus']." ($subtotal%)', ";
                    $data .= $r['total'].", ";
                }
                $labels = substr($labels, 0, strlen($labels)-2);
                $data = substr($data, 0, strlen($data)-2);
                $graph_data['labels'] = $labels;
                $graph_data['data'] =  $data;
            }
        }
        return $graph_data;
    }

    public function get_data_params() {
        $data = array();
        $params = sql_select("SELECT paramDateTime, fields FROM admin_users_params WHERE userId = ".$this->id." ORDER BY paramDateTime DESC LIMIT 0, 20");
        if($params) {
            foreach($params as $p) {
                $dec = fromdb($p['fields'], true);
                if(isset($dec['weight']) && isset($dec['fc']) && isset($dec['presis']) && isset($dec['predia'])) {
                    $data[strtotime($p['paramDateTime'])] = [
                        "date" => DateLang::date($p['paramDateTime'], "d/m"), 
                        "dateshort" => DateLang::short($p['paramDateTime'], "d/m"), 
                        "weight" => $dec['weight'], 
                        "bmi" => NumberFormat::float(Health::bmi($dec['weight'], $this->get("height"))), 
                        "fc" => $dec['fc'], 
                        "presis" => $dec['presis'], 
                        "predia" => $dec['predia']
                    ];
                }
            }
        }
        return $data;
    }

    public function get_data($sort="asc") {
        $data = $this->get_data_params();
        if($sort=="asc") {
            ksort($data);
        } else {
            krsort($data);
        }
        return $data;
    }

    public function get_graph_data() {
        $graph_data = array();
        $labels = "";
        $weight = "";
        $bmi = "";
        $fc = "";
        $presis = "";
        $predia = "";
        $data = $this->get_data();
        if(count($data)>0) {
            foreach($data as $d) {
                $labels .= "'".$d['date']."', ";
                $weight .= $d['weight'].", ";
                $bmi .= $d['bmi'].", ";
                $fc .= $d['fc'].", ";
                $presis .= $d['presis'].", ";
                $predia .= $d['predia'].", ";
            }
            $graph_data['labels'] = substr($labels, 0, strlen($labels)-2);
            $graph_data['weight'] = substr($weight, 0, strlen($weight)-2);
            $graph_data['bmi'] = substr($bmi, 0, strlen($bmi)-2);
            $graph_data['fc'] = substr($fc, 0, strlen($fc)-2);
            $graph_data['presis'] = substr($presis, 0, strlen($presis)-2);
            $graph_data['predia'] = substr($predia, 0, strlen($predia)-2);
        }
        return $graph_data;
    }

    public function get_app_graph_points() {
        # response
        $response = array( "attended" => 0, "total" => 0, "weight" => [], "bmi" => [], "hr" => [], "systolic" => [], "diastolic" => [], "glucose" => []);

        # attendance
        $appointments = sql_select("SELECT a.appStatusId, COUNT(a.appointmentId) AS total FROM admin_appointments a 
                                    WHERE a.userId = ".$this->id." AND a.appStatusId <> '".APP_SCHEDULED."' 
                                    GROUP BY a.appStatusId ORDER BY a.appStatusId ASC");
        $total = 0;
        $attended = 0;
        if($appointments) {
            $total = (int)$appointments[0]['total'];
            $total += (isset($appointments[1]['total'])) ? $appointments[1]['total'] : 0;
            $attended = (int)$appointments[0]['total'];
        }
        $response['attended'] = $attended;
        $response['total'] = $total;

        # params
        $results = sql_select("SELECT * FROM admin_users_params WHERE userId = ".$this->id." ORDER BY paramDateTime DESC LIMIT 0, 5");
        if($results) {
            for($i=0; $i<count($results); $i++) {
                $results[$i]['fields'] = fromdb($results[$i]['fields'], true);
            }
            $results = array_reverse($results);

            # weight
            $points = array();
            foreach($results as $r) {
                if(isset($r['fields']['weight'])) {
                    $points[] = array( "date" => DateLang::date($r['paramDateTime'], "d/m"), "value" => (float)$r['fields']['weight'] );
                }
            }
            $response['weight'] = array_reverse($points);

            # bmi
            $points = array();
            foreach($results as $r) {
                if(isset($r['fields']['weight'])) {
                    $points[] = array( "date" => DateLang::date($r['paramDateTime'], "d/m"), "value" => (float)NumberFormat::float(Health::bmi($r['fields']['weight'], $this->get("height"))) );
                }
            }
            $response['bmi'] = array_reverse($points);

            # hr
            $points = array();
            foreach($results as $r) {
                if(isset($r['fields']['fc'])) {
                    $points[] = array( "date" => DateLang::date($r['paramDateTime'], "d/m"), "value" => (int)$r['fields']['fc'] );
                }
            }
            $response['hr'] = array_reverse($points);

            # systolic
            $points = array();
            foreach($results as $r) {
                if(isset($r['fields']['presis'])) {
                    $points[] = array( "date" => DateLang::date($r['paramDateTime'], "d/m"), "value" => (int)$r['fields']['presis'] );
                }
            }
            $response['systolic'] = array_reverse($points);

            # diastolic
            $points = array();
            foreach($results as $r) {
                if(isset($r['fields']['predia'])) {
                    $points[] = array( "date" => DateLang::date($r['paramDateTime'], "d/m"), "value" => (int)$r['fields']['predia'] );
                }
            }
            $response['diastolic'] = array_reverse($points);

            # glucose
            $points = array();
            foreach($results as $r) {
                if(isset($r['fields']['glu'])) {
                    $points[] = array( "date" => DateLang::date($r['paramDateTime'], "d/m"), "value" => (int)$r['fields']['glu'] );
                }
            }
            $response['glucose'] = array_reverse($points);

        }

        # return
        return $response;

    }

    public function get_app_appointments() {

        $response = array( "next" => [], "previous" => [] );

        # next appointment
        $next = sql_select_row("SELECT a.appDateTime, u.name, u.email FROM admin_appointments a, admin_users u 
                                WHERE a.doctorId = u.userId AND a.userId = ".$this->id." AND a.appDateTime >= NOW()");
        if($next) {
            $response['next'] = array(  "date" => DateLang::short($next['appDateTime']), 
                                        "time" => date("H:i A", strtotime($next['appDateTime'])), 
                                        "doctor" => $next['name'], 
                                        "email" => $next['email']
                                );
        }

        # previous appointments
        $prevs = sql_select("SELECT a.appDateTime, u.name, u.email FROM admin_appointments a, admin_users u 
                            WHERE a.doctorId = u.userId AND a.userId = ".$this->id." AND a.appDateTime < NOW() 
                            ORDER BY a.appDateTime DESC 
                            LIMIT 0, 5");
        if($prevs) {
            foreach($prevs as $p) {
                $response['previous'][] = array("date" => DateLang::short($p['appDateTime']), 
                                                "time" => date("H:i A", strtotime($p['appDateTime'])), 
                                                "doctor" => $p['name'], 
                                                "email" => $p['email']
                                        );
            }
        }

        # return
        return $response;

    }

    public function get_app_notes() {
        return fromdb($this->get("notes"), true);
    }

}
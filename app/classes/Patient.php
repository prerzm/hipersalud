<?php

class Patient extends Record {

    protected $key = "userId";
    protected $table = "admin_users";
    protected $query = "SELECT *, TIMESTAMPDIFF(YEAR, dob, CURDATE()) AS age FROM TABLE WHERE rolId = ".ROLE_PATIENT." AND KEY = ID";

    public function update() {

        $values['companyId'] = (int)pf('companyId');
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

    public function send_welcome() {
        $mail = new MailWelcome();
        $mail->info($this->get("email"), $this->get("name"), $this->get("code"));
        return $mail->process();
    }

    public function set_password($pswd) {
        if(trim($pswd!="")) {
            return query_update($this->table, array("password" => Crypt::hash($pswd)), $this->key." = ".$this->id);
        }
        return -1;
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
        $params = sql_select("SELECT paramDateTime, fields FROM admin_users_params WHERE userId = ".$this->id." ORDER BY paramDateTime DESC LIMIT 0, 12");
        if($params) {
            foreach($params as $p) {
                $dec = fromdb($p['fields'], true);
                $data[strtotime($p['paramDateTime'])] = [
                    "date" => DateLang::date($p['paramDateTime'], "d/m"), 
                    "dateshort" => DateLang::short($p['paramDateTime'], "d/m"), 
                    "weight" => (isset($dec['weight']) && $dec['weight']>0) ? $dec['weight'] : 0, 
                    "bmi" => (isset($dec['weight']) && $dec['weight']>0) ? NumberFormat::float(Health::bmi($dec['weight'], $this->get("height"))) : 0, 
                    "fc" => (isset($dec['fc']) && $dec['fc']>0) ? $dec['fc'] : 0, 
                    "presis" => (isset($dec['presis']) && $dec['presis']>0) ? $dec['presis'] : 0, 
                    "predia" => (isset($dec['predia']) && $dec['predia']>0) ? $dec['predia'] : 0,
                    "glu" => (isset($dec['glu']) && $dec['glu']>0) ? $dec['glu'] : 0
                ];
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
        $glucose = "";
        $data = $this->get_data();
        if(count($data)>0) {
            foreach($data as $d) {
                $labels .= "'".$d['date']."', ";
                $weight .= $d['weight'].", ";
                $bmi .= $d['bmi'].", ";
                $fc .= $d['fc'].", ";
                $presis .= $d['presis'].", ";
                $predia .= $d['predia'].", ";
                $glucose .= $d['glu'].", ";
            }
            $graph_data['labels'] = substr($labels, 0, strlen($labels)-2);
            $graph_data['weight'] = substr($weight, 0, strlen($weight)-2);
            $graph_data['bmi'] = substr($bmi, 0, strlen($bmi)-2);
            $graph_data['fc'] = substr($fc, 0, strlen($fc)-2);
            $graph_data['presis'] = substr($presis, 0, strlen($presis)-2);
            $graph_data['predia'] = substr($predia, 0, strlen($predia)-2);
            $graph_data['glu'] = substr($glucose, 0, strlen($glucose)-2);
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

        $response = array( "nextWeekday" => 0, "nextDay" => 0, "nextMonth" => "", "nextYear" => 0, "nextTime" => "", "nextDoctor" => "", "nextEmail" => "", "previous" => [] );

        # next appointment
        $next = sql_select_row("SELECT a.appDateTime, u.name, u.email FROM admin_appointments a, admin_users u 
                                WHERE a.doctorId = u.userId AND a.userId = ".$this->id." AND a.appDateTime >= NOW()");
        if($next) {
            $response['nextWeekday'] = (int)date("N", strtotime($next['appDateTime']));
            $response['nextDay'] = (int)date("j", strtotime($next['appDateTime']));
            $response['nextMonth'] = (int)date("n", strtotime($next['appDateTime']));
            $response['nextYear'] = (int)date("Y", strtotime($next['appDateTime']));
            $response['nextTime'] = date("H:i A", strtotime($next['appDateTime']));
            $response['nextDoctor'] = $next['name'];
            $response['nextEmail'] = $next['email'];
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
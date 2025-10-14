<?php

# alets

class Alerts {

    public function add($msg, $type="info") {
        $alerts = Session::get("alerts");
        $alerts[] = array("type" => $type, "message" => $msg);
        Session::set("alerts", $alerts);
    }

    public function success($msg) {
        $this->add($msg, "success");
    }

    public function warning($msg) {
        $this->add($msg, "block");
    }

    public function error($msg) {
        $this->add($msg, "error");
    }

    public function display() {
        $alerts = Session::get("alerts");
        if(is_array($alerts)) {
            foreach($alerts as $alert) {
                print '<div class="alert alert-'.$alert['type'].'">
					<a class="close" data-dismiss="alert" href="#">&times;</a>
					<h4 class="alert-heading">'.$alert['message'].'!</h4>
				</div>';
            }
        }
        $this->clear();
    }

    public function clear() {
        Session::set("alerts", array());
    }

}
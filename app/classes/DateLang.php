<?php

class DateLang {

    public static function convert($date="", $format="Y-m-d") {
        
    }

    public static function date($date="", $format="Y-m-d") {
        global $global_language;
        $time = ($date!="" && strtotime($date)!==false) ? strtotime($date) : time();
        $date = date($format, $time);
        if($global_language->get()!="en") {
            $class = "Date".strtoupper($global_language->get());
            return $class::convert($date, $format);
        }
        return $date;
    }

    public static function short($date="") {
        return self::date($date, "d/m/y");
    }

    public static function med($date="") {
        return self::date($date, "d-M-y");
    }

    public static function long($date="") {
        return self::date($date, "l d, F, Y");
    }

    public static function is_date($date) {
        if(strtotime($date)===false || $date=="1900-01-01" || $date=="") {
            return "";
        } else {
            return $date;
        }
    }

}

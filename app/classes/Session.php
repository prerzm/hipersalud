<?php

# session

class Session {
    
    public static function set($key, $value) {
        $_SESSION[$key] = $value;
    }

    public static function set_data($array) {

        if(is_array($array)) {
            foreach($array as $key => $value) {
                $_SESSION[$key] = $value;
            }
        }

    }

    public static function get($key="") {

        if($key=="") {

            return $_SESSION;

        } else {

            if(isset($_SESSION[$key])) {
                return $_SESSION[$key];
            } else {
                return false;
            }

        }

    }

    public static function set_safe($key, $value) {
        $_SESSION[$key] = Crypt::encrypt($value);
    }

    public static function get_safe($key) {
        return (isset($_SESSION[$key])) ? Crypt::decrypt($_SESSION[$key]) : "";
    }

    public static function unset($key) {

        if(isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
        }

    }

}
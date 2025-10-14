<?php

# params

class Params {

    public static function set($arr) {
        $query = "p=";
        if(is_array($arr) && count($arr)>0) {
            $crypt = Crypt::encrypt(http_build_query($arr));
            $query .= urlencode($crypt);
        }
        return $query;
    }

    public static function get() {

        $params = array();

        if(isset($_GET['p'])) {
            $decrypt = Crypt::decrypt($_GET['p']);
            parse_str($decrypt, $params);
        }

        if(!isset($params['mod'])) {
            $params['mod'] = "";
        }

        if(!isset($params['cmd'])) {
            $params['cmd'] = "";
        }

        return $params;

    }

}

?>
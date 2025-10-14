<?php

class NumberFormat {

    public static function float($number, $decimals=2) {

        $number = (float)str_replace( array("$", ",", " "), "", $number);

        return number_format($number, $decimals, ".", "");
        
    }

    public static function currency($amount, $symbol="$", $code="") {

        $amount	= str_replace(array(",", "$", " "), "", $amount);
        $code = ($code=="") ? "" : " ".$code;

        return $symbol." ".number_format($amount, 2, ".", ",").$code;

    }


    public static function thousands($amount, $decimals=2) {

        $amount	= str_replace(array(",", "$", " "), "", $amount);

        return number_format($amount, $decimals, ".", ",");
        
    }

    function number_thousands($amount) {

        # strip amount
        $amount	= str_replace(array(",", "$", " "), "", $amount);
        $amount = $amount * 1;

        return number_format($amount, 0, "", ",");
        
    }


}
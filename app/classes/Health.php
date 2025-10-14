<?php

class Health {

    public static function bmi($weight, $height) {
        $bmi = 0;
        if((int)$weight>0 && (int)$height>0) {
            $height = $height / 100;
            $bmi = $weight / ($height*$height);
        }
        return $bmi;
    }

}
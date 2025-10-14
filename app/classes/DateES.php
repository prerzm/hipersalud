<?php

class DateES {

    protected static $days_long = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
    protected static $days_long_es = ["Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado"];
    protected static $days_short = ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"];
    protected static $days_short_es = ["Dom", "Lun", "Mar", "Mié", "Jue", "Vie", "Sáb"];
    protected static $months_long = ["January", "February", "March", "April", "May", "June", "July", 
                                    "August", "September", "October", "November", "December"];
    protected static $months_long_es = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", 
                                        "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
    protected static $months_short = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
    protected static $months_short_es = ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"];

    public static function convert($date) {
        $es = str_replace(self::$days_long, self::$days_long_es, $date);
        $es = str_replace(self::$days_short, self::$days_short_es, $es);
        $es = str_replace(self::$months_long, self::$months_long_es, $es);
        $es = str_replace(self::$months_short, self::$months_short_es, $es);
        return $es;
    }

}
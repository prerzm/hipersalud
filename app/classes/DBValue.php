<?php

class DBValue {

    protected $key = "configId";
    protected $table = "admin_configuration";

    public function __construct() {
        $results = sql_select("SELECT * FROM ".$this->table);
        $config = array();
        if($results) {
            for($i=0;$i<count($results);$i++) {
                $key = strtoupper($results[$i]['configKey']);
                $config[$key] = $results[$i]['configValue'];
            }
        }
        $this->info = $config;
    }

    public function get($field) {
        return (isset($this->info[$field])) ? $this->info[$field] : false;
    }
    
}
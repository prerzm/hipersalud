<?php

# Partido

class Partido {

    protected $id;

    public function __construct($id) {
        $this->id = (int)$id;
    }

    public function get_partido() {
        return get_record("partidos", "partido_id = ".$this->id);
    }

    public function delete() {

        $par = query_delete("partidos", "partido_id = ".$this->id);
		$res = query_delete("resultados", "partido_id = ".$this->id);

		return (($par+$res)>0) ? true : false;

    }
    
}
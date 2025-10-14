<?php

class Field extends Record {

	protected $key = "fieldId";
	protected $table = "admin_fields";

    public function html() {
        $html = "";
        switch($this->get("type")) {
            case 'text':
                $html = '<input type="text" name="'.$this->get("name").'">';
            break;
            default:
                $html = "";
            break;
        }
        return $html;
    }
    
}
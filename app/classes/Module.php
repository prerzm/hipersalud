<?php

class Module extends Record {

    protected $key = "moduloId";
    protected $table = "admin_modulos";

    public function get_lang($lang) {
        return sql_select_row("SELECT * FROM admin_modulos_lang WHERE moduloId = ".$this->id." AND lang = '$lang'");
    }

    public function get_perms() {
        return sql_select("SELECT * FROM admin_modulos_permisos WHERE moduloId = ".$this->id." ORDER BY permisoId ASC");
    }

    public function add_perm($permisoKey, $permiso) {
        return query_insert("admin_modulos_permisos", array("moduloId" => $this->id, "permisoKey" => $permisoKey, "permiso" => $permiso));
    }

    public function del_perm($permisoId) {
        return query_delete("admin_modulos_permisos", "permisoId = $permisoId");
    }

}
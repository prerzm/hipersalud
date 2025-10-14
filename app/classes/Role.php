<?php

class Role extends Record {

    protected $key = "rolId";
    protected $table = "admin_roles";

    public function set_perms($perms) {

        if(is_array($perms)) {
            $sql = "INSERT INTO admin_roles_permisos (rolId, permisoId) VALUES ";
            foreach($perms as $permisoId => $x) {
                $sql .= "(".$this->id().", $permisoId), ";
            }
            $sql = rtrim($sql, ", ");

            query_delete("admin_roles_permisos", "rolId = ".$this->id());
            return sql_query($sql);
        }

        return 0;

    }

}
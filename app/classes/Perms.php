<?php

class Perms {

    protected $perms;

    public function __construct($role_id) {

        $role_id = (int)$role_id;

		$results = sql_select("SELECT m.moduloId, m.moduloKey, mp.permisoKey, IF(rp.rolPermisoId, 1, 0) AS hasPerm
                                FROM admin_modulos m, admin_modulos_permisos mp 
                                    LEFT JOIN (SELECT * FROM admin_roles_permisos WHERE rolId = $role_id) rp ON mp.permisoId = rp.permisoId
                                WHERE m.moduloId = mp.moduloId
                                ORDER BY mp.moduloId ASC, mp.permisoId ASC");

		if($results && $role_id>0) {
            $perms = array();
            foreach($results as $r) {
                $perms[$r['moduloKey']][$r['permisoKey']] = (bool)$r['hasPerm'];
            }
            $this->perms = $perms;
		}

    }

    public function can($mod, $perm) {
        if(isset($this->perms[$mod][$perm])) {
            return $this->perms[$mod][$perm];
        } else {
            die("App malfunction no mod or perm error...");
        }
        return false;
    }

}
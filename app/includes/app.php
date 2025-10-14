<?php

# get module name based on file
function getmodule($mod) {
    switch($mod) {
        case 'log': $module = PATH_MODULES."login.php"; break;

        case 'inf': $module = PATH_MODULES."myinfo.php"; break;
        case 'pat': $module = PATH_MODULES."patients.php"; break;
        case 'doc': $module = PATH_MODULES."doctors.php"; break;

        case 'apo': $module = PATH_MODULES."appointments.php"; break;
        case 'csu': $module = PATH_MODULES."consultations.php"; break;

        case 'mod': $module = PATH_MODULES."modules.php"; break;
        case 'rol': $module = PATH_MODULES."roles.php"; break;
        case 'die': $module = PATH_MODULES."diets.php"; break;
        case 'use': $module = PATH_MODULES."users.php"; break;
        case 'fie': $module = PATH_MODULES."fields.php"; break;
        case 'set': $module = PATH_MODULES."settings.php"; break;

        default: $module = PATH_MODULES."index.php"; break;
    }
    if(!file_exists($module) || !is_file($module)) {
        die("error loading module $mod<br>");
    }
    return $module;
}

# load view (include view file)
function getview($view="index.index") {
    $file = PATH_HTML.$view.".php";
    if(file_exists($file) && is_file($file)) {
        return $file;
    } else {
        die("View is missing... $view");
    }
}

# load settings
function loadsettings() {
    $settings = sql_select("SELECT configKey, configValue FROM admin_configuration");
    if($settings) {
        for($i=0; $i<count($settings); $i++) {
            $key = $settings[$i]['configKey'];
            $val = $settings[$i]['configValue'];
            define("$key", "$val");
        }
    }
}

# redirect including params
function redirect($params="") {

    if(is_array($params)) {
        if((bool)ENCRYPTED_PARAMS) {
            foreach($params as $key => &$value) {
                $value = ps($value);
            }
        }
        $location = "./?".http_build_query($params);
    } else {
        $location = "./";
    }

    header("Location: $location");
    exit;

}

function redirect_if_logged_out($mod) {
    if(!Login::logged() && $mod!="log") {
        redirect(array("mod" => "log"));
        exit;
    }
    
}

function redirect_on_access($mod) {
    global $global_perms, $global_alerts;
    if($mod!="" && $mod!="log" && !$global_perms->can($mod, "READ")) {
        $global_alerts->warning("No cuenta con los permisos para acceder a este módulo!");
        redirect();
        exit;
    }
}

function getmenu($role_id) {
    global $global_language;
    $result = sql_select("SELECT DISTINCT m.menuParentKey, ml.menuParentName, m.menuIcon
                        FROM admin_modulos m, admin_modulos_lang ml, admin_modulos_permisos mp, admin_roles_permisos rp
                        WHERE m.moduloId = ml.moduloId AND m.moduloId = mp.moduloId AND mp.permisoId = rp.permisoId AND 
                            ml.lang = '".$global_language->get()."' AND rp.rolId = $role_id AND mp.permisoKey = 'READ'
                        ORDER BY m.orden ASC, mp.moduloId ASC");
    if($result) {
        for($i=0; $i<count($result); $i++) {
            $mods = sql_select("SELECT m.moduloKey, ml.modulo 
                                FROM admin_modulos m, admin_modulos_lang ml, admin_modulos_permisos mp, admin_roles_permisos rp
                                WHERE m.moduloId = ml.moduloId AND m.moduloId = mp.moduloId AND mp.permisoId = rp.permisoId AND 
                                    ml.lang = '".$global_language->get()."' AND rp.rolId = $role_id AND m.menuParentKey = '".$result[$i]['menuParentKey']."' AND 
                                    mp.permisoKey = 'READ'
                                ORDER BY m.orden ASC");
            $result[$i]['modules'] = $mods;
        }
    }
    return $result;
}
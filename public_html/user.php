<?php

# start session
session_start();

# required files
include_once('../app/includes/config.php');
include_once(PATH_INCLUDES.'app.php');
include_once(PATH_INCLUDES.'autoload.php');
include_once(PATH_INCLUDES.'connect.php');
include_once(PATH_INCLUDES.'lib.database.php');
include_once(PATH_INCLUDES.'lib.vars.php');

# load settings
loadsettings();
$global_language = new Language();
$global_alerts = new Alerts();

# process
switch(pg('cmd')) {

    case 'newpswd':

		$code = pg('code');
		$token = new Token(base64_decode($code));
        if($token->valid()) {
            $email = $token->get("email");
            $res = sql_select_row("SELECT userId, rolId, code, name FROM admin_users WHERE email = '$email'");
            if(!$res || $code!==$res['code']) {
                $global_alerts->error("Hubo un problema al recuperar tu información, favor de contactar al administrador del sitio");
                header("Location: msg.php");
                exit;
            }
        }

        # view
        include(getview("index.setpswd"));

    break;

    case 'setpswd':

        # vars
		$code = pg('code');
        $password = trim(pf('password'));
        $password_confirm = trim(pf('password_confirm'));

        if($password!="") {
            if($password===$password_confirm) {
                $token = new Token(base64_decode($code));
                if($token->valid()) {
                    $res = sql_select_row("SELECT userId, rolId, code, name FROM admin_users WHERE email = '".$token->get("email")."'");
                    if($res && $code===$res['code']) {
                        $updated = query_update("admin_users", array("code" => '', "password" => Crypt::hash($password)), "userId = ".(int)$res['userId']);
                        if($updated>0) {
                            $global_alerts->success("La información se actualizó correctamente");
                        } else {
                            $global_alerts->error("Hubo un problema al actualizar tu información, favor de contactar al administrador del sitio");
                        }
                    } else {
                        $global_alerts->error("Hubo un problema al recuperar tu información, favor de contactar al administrador del sitio");
                    }
                } else {
                    $global_alerts->error("Hubo un problema al recuperar tu información, favor de contactar al administrador del sitio");
                }
            } else {
                $global_alerts->error("Tus contraseñas no coinciden");
            }
        } else {
            $global_alerts->error("La contraseña de tu cuenta no puede estar en blanco, favor de intentar nuevamente");
        }

        header("Location: msg.php");
        exit;

    break;

    default:
        header("Location: index.html");
        exit;
    break;

}

?>
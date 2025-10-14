<?php

class Login {

    public static function log_in($email, $user_password) {

        $user = sql_select_row("SELECT userId, rolId, name, email, password FROM admin_users WHERE email = '$email' AND deleted = 0 LIMIT 1");

	    if($user) {
            $db_password = $user['password'];
            if( password_verify( $user_password, $db_password) ) {
                Session::set_safe("userId", (int)$user['userId']);
                Session::set_safe("roleId", (int)$user['rolId']);
                Session::set_safe("name", $user['name']);
                Session::set_safe("email", $user['email']);
                Session::set("login_string", Crypt::hash($db_password . $_SERVER['HTTP_USER_AGENT']));
				return true;
            }
        }

        return false;

    }

    public static function validate_user($email, $user_password) {

        $user = sql_select_row("SELECT userId, password FROM admin_users WHERE email = '$email' AND deleted = 0 LIMIT 1");

	    if($user) {
            $db_password = $user['password'];
            if( password_verify( $user_password, $db_password) ) {
                return ['userId' => (int)$user['userId']];
            }
        }

        return false;
        
    }

    public static function logged() {

        if (isset($_SESSION['userId'], $_SESSION['roleId'], $_SESSION['name'], $_SESSION['email'], $_SESSION['login_string'])) {

            $user = sql_select_row("SELECT password FROM admin_users WHERE userId = ".Session::get_safe("userId")." LIMIT 1");
            if($user && password_verify( $user['password'].$_SERVER['HTTP_USER_AGENT'], Session::get("login_string"))) {
                return true;
            }
        }

        return false;

    }

    public static function logout() {

        Session::unset("userId", "roleId", "name", "email", "login_string");

        $cookieParams = session_get_cookie_params();
        setcookie(session_name(), '', time() - 84600, $cookieParams["path"], $cookieParams["domain"]);

        session_destroy();

    }

}
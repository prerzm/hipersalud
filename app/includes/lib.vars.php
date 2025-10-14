<?php

# params functions
function pf($name, $len=0) {
    $value = "";
    if(isset($_POST[$name])) {
        $value = $_POST[$name];
    } elseif(isset($_GET[$name])) {
        $value = $_GET[$name];
    }
    if($len>0) {
        $value = substr($value, 0, $len);
    }
    return $value;
}

function pg($name, $len=0) {
    $value = "";
    if(isset($_POST[$name])) {
        $value = $_POST[$name];
    } elseif(isset($_GET[$name])) {
        $value = $_GET[$name];
    }
    if((bool)ENCRYPTED_PARAMS) {
        $value = Crypt::decrypt(base64_decode($value));
    } else {
		if($len>0) {
			$value = substr($value, 0, $len);
		}
	}
    return $value;
}

function ps($value) {
    if((bool)ENCRYPTED_PARAMS) {
        $value = base64_encode(Crypt::encrypt($value));
    }
    return $value;
}

function todb($array, $encrypt=false) {
	$output = "";
	if(is_array($array)) {
		$output = json_encode($array, JSON_UNESCAPED_UNICODE);
		if($encrypt) {
			$output = Crypt::encrypt($output);
		}
		$output = base64_encode($output);
	}
	return $output;
}

function fromdb($string, $encrypted=false) {
	$output = base64_decode($string);
	if($encrypted) {
		$output = Crypt::decrypt($output);
	}
	return json_decode($output, true);
}

// cookies
function cookie_set($name, $value) {
	$expires = time() + (3600 * 24 * 7);
	return setcookie($name, base64_encode($value), $expires, "/");
}

function cookie_get($name) {
	if(isset($_COOKIE) && isset($_COOKIE[$name])) {
		return trim(base64_decode($_COOKIE[$name]));
	}
	return "";
}

<?php

# crypt

class Crypt {

    protected static $salt = "BullSharks$20250123";

    public static function hash($text) {

        return password_hash($text, PASSWORD_BCRYPT);

    }

    public static function encrypt($text) {

        return openssl_encrypt($text, 'bf-ecb', self::$salt);

    }

    public static function decrypt($text) {

        return openssl_decrypt($text, 'bf-ecb', self::$salt);

    }

}
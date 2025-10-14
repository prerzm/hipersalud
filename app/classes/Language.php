<?php

class Language {

    protected $langs = ["es", "en"];
    protected $code = "es";
    
    public function __construct() {
        # from browser
        $browser = $this->browser();
        if($browser!="" && $this->exists($browser)) {
            $this->code = $browser;
        }
        # from cookie
        $cookie = cookie_get("lang");
        if(!is_null($cookie) && $cookie!="" && $this->exists($cookie)) {
            $this->code = $cookie;
        }
        $this->load();
    }

    public function exists($lang) {
        return in_array($lang, $this->langs);
    }

    public function set($lang) {
        if(!is_null($lang) && $lang!="" && $this->exists($lang)) {
            cookie_set("lang", $lang);
        }
    }

    public function load() {
        $file = PATH_INCLUDES."lang.".$this->code.".php";
        if( file_exists($file) && is_file($file) ) {
            require_once($file);
        } else {
            die('error loading lang file '.$this->file);
        }
    }

    public function get() {
        return $this->code;
    }

    public function browser() {
        if(isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) && $_SERVER['HTTP_ACCEPT_LANGUAGE']!="") {
            $langs = explode(',', $_SERVER['HTTP_ACCEPT_LANGUAGE']);
            if(is_array($langs) && isset($langs[0])) {
                $main = $langs[0];
                if(strlen($main)>2 && strpos($main, "-")>0) {
                    list($code, ) = explode("-", $main);
                    return $code;
                }
            }
        }
        return "";
    }

}
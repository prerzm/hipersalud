<?php

class Token {

    /********* changed to 480 minutes (8 hours) to test flutter app api calls ********/
    private static $life = 480 * 60; // 15 minutes
    /*********  ********/
    private $token;
    private $expires_at;
    private $data;

    public function __construct($token) {
        $decoded = json_decode(Crypt::decrypt($token), true);
        if($decoded) {
            $this->token = $token;
            $this->expires_at = $decoded['expires'];
            $data = json_decode(base64_decode($decoded['data']), true);
            if($data) {
                $this->data = $data;
            }
        }
    }

    public static function generate($data) {
        $token['data'] = base64_encode(json_encode($data));
        $token['random']= base64_encode(random_bytes(16));
        $token['expires'] = time() + self::$life;
        return Crypt::encrypt(json_encode($token));
    }

    public function refresh() {
        if($this->valid()) {
            $this->token = $this->generate($this->data);
            $this->expires_at = time() + self::$life;
        }
    }

    public function valid() {
        if( time()>$this->expires_at || !isset($this->data['userId']) || (int)$this->data['userId']==0) {
            return false;
        }
        return true;
    }

    public function get_token() {
        return $this->token;
    }

    public function get_data() {
        return $this->data;
    }

    public function check_times() {
        print date("Y-m-d H:i:s")."<br>";
        print date("Y-m-d H:i:s", $this->expires_at);
    }

}

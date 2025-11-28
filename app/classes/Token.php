<?php

class Token {

    private $token;
    private $life = 15; // 15 minutes
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

    public function generate($data, $total=15) {
        $token['data'] = base64_encode(json_encode($data));
        $token['random']= base64_encode(random_bytes(16));
        $token['expires'] = strtotime("+$total minutes");
        $this->life = $total;
        $this->expires_at = $token['expires'];
        $this->data = $data;
        $this->token = Crypt::encrypt(json_encode($token));
    }

    public function refresh() {
        if($this->valid()) {
            $this->generate($this->data, $this->life);
        }
    }

    public function valid() {
        if( time()>$this->expires_at || empty($this->data)) {
            return false;
        }
        return true;
    }

    public function get_token() {
        return $this->token;
    }

    public function get($field) {
        if(isset($this->data[$field])) {
            return $this->data[$field];
        }
        return "";
    }

    public function check_times() {
        print date("Y-m-d H:i:s")."<br>";
        print date("Y-m-d H:i:s", $this->expires_at);
    }

}

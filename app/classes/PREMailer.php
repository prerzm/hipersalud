<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class PREMailer extends PHPMailer {

	public $From     = "info@hipersalud.com";
	public $FromName = "Hipersalud";
	public $Host = "mail.hipersalud.com";
	public $Port = 465;
	public $SMTPAuth = true;		// SMTP requires authentication
	public $SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;	//Enable implicit TLS encryption
	public $Username = "info@hipersalud.com";
    public $Password = "0Rc77iulsgQLXSTIie";
    #public $SMTPDebug = SMTP::DEBUG_SERVER; // debug
	protected $to_email;
	protected $template;
	protected $search;
	protected $replace;
    
    // construct
    public function __construct() {
        parent::__construct(true);
        $this->IsSMTP();
		$this->CharSet = "UTF-8";
		$this->isHTML(true);
    }

	// build
	public function build() {
		$html_body = file_get_contents(PATH_MAILS.$this->template);
		$html_body = str_replace($this->search, $this->replace, $html_body);
		$this->Body = str_replace("SITE_URL", SITE_URL, $html_body);
	}

    // send or display mail
	public function process() {

		$this->build();
		
		switch(EMAIL_MODE) {

			case EMAIL_BYPASS:
				return true;
			break;

			case EMAIL_DISPLAY:
				$this->AddAddress($this->to_email);
				print "<br>Mail from: $this->From &lt;$this->FromName&gt;<br>Mail to: <br>";
            	print_r($this->getToAddresses());
				print "<br>Subject: $this->Subject<br>".$this->Body."<br>";
				die();
			break;

			case EMAIL_TEST:
				$this->AddAddress("ramirozm@gmail.com");
				return $this->Send();
			break;

			case EMAIL_ACTIVE:
				$this->AddAddress($this->to_email);
				return $this->Send();
			break;

			default:
				return false;
			break;

		}

		return false;

    }
    
}

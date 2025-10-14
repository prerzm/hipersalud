<?php

# mailer

class PREMailer extends PHPMailer {

	// Set default variables for all new objects
	public $From     = "quiniela@familiazendejas.org";
	public $FromName = "Quiniela";

	// SMTP configuration
	public $Host	= "mail.familiazendejas.org";
	public $Port 	= 465;
	public $SMTPAuth 	= true;		// SMTP requires authentication
	public $SMTPSecure	= "ssl";
	public $Username = "quiniela@familiazendejas.org";
    public $Password = "n54yYa7Sfd5mJwU";

	// Vars
	public $mail_ccs = false;
	public $mail_html_body = "";

    // construct
    public function __construct() {
        $this->IsSMTP();
		$this->SMTPDebug = false; // 1 = errors & messages, 2 = messages
		$this->CharSet = "UTF-8";
    }

	// Jornada activa
	public function jornada_activa($jornada_nombre, $jornada_inicio, $ccs=false) {

		# subject
		$this->Subject = "Resultados $jornada_nombre";

		# add addresses
		$this->AddAddress("ramirozm@gmail.com");

		if($ccs!==false && is_array($ccs) && count($ccs)>0) {
			$this->mail_ccs = $ccs;
			foreach($ccs as $cc_email) {
				$this->AddCC($cc_email);
			}
		}

		# content/template
		$html = file_get_contents(PATH_MAILS."mail.jornada.activa.html");

		$this->mail_html_body = str_replace(array("[JORNADA_NOMBRE]", "[JORNADA_INICIO]"), array($jornada_nombre, $jornada_inicio), $html);
		$this->MsgHTML($this->mail_html_body);

		# send mail
		return $this->send_mail();

	}

	// Jornada cambiar
	public function jornada_cambiar($jornada_nombre, $jornada_inicio) {

		# subject
		$this->Subject = "Quiniela - cambiar jornada";

		# add addresses
		$this->AddAddress("ramirozm@gmail.com");

		# content/template
		$html = file_get_contents(PATH_MAILS."mail.jornada.cambiar.html");
		$this->mail_html_body = str_replace(array("[JORNADA_NOMBRE]", "[JORNADA_INICIO]"), array($jornada_nombre, $jornada_inicio), $html);
		$this->MsgHTML($this->mail_html_body);

		# send mail
		return $this->send_mail();

	}

	// Ganadores de torneo
	public function torneo_ganadores($torneo_ganadores, $ccs=false) {

		# subject
		$this->Subject = "Ganadores del Torneo";

		# add addresses
		$this->AddAddress("ramirozm@gmail.com");

		if($ccs!==false && is_array($ccs) && count($ccs)>0) {
			$this->mail_ccs = $ccs;
			foreach($ccs as $cc_email) {
				$this->AddCC($cc_email);
			}
		}

		# content/template
		$html = file_get_contents(PATH_MAILS."mail.torneo.ganadores.html");

		$this->mail_html_body = str_replace("[EMAIL_BODY]", nl2br($torneo_ganadores), $html);
		$this->MsgHTML($this->mail_html_body);

		# send mail
		return $this->send_mail();

	}

	// Display
	public function display() {

		print "<br><br><br>";
		print "Mail from: $this->From &lt;$this->FromName&gt;<br>";
		print "Mail to: ramirozm@gmail.com<br>";

		if($this->mail_ccs!==false && is_array($this->mail_ccs) && count($this->mail_ccs)>0) {
			foreach($this->mail_ccs as $cc_email) {
				print "CC to: $cc_email<br>";
			}
		}

		print "Subject: ".$this->Subject."\n<br><br>";
		print $this->mail_html_body;
		print "<br><br>";

		die();

	}

	// Send
	public function send_mail() {

		if(EMAIL_MODE=="SEND") {
			if(!$this->Send()) {
				return "Mailer Error: " . $this->ErrorInfo;
			} else {
				return true;
			}
		} else {
			$this->display();
		}

	}

}


?>
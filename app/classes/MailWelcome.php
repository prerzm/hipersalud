<?php

class MailWelcome extends PREMailer {

    protected $template = "mail.welcome.html";

    public function info($to_email, $name, $code) {
        $this->Subject = LABEL_EMAIL_WELCOME_WELCOME;
        $this->to_email = $to_email;
        $this->search = ["TO_NAME", "LINK_SET_PSWD", "LABEL_EMAIL_WELCOME_WELCOME", "LABEL_EMAIL_WELCOME_HELLO", "LABEL_EMAIL_WELCOME_MESSAGE", "LABEL_EMAIL_WELCOME_LINK", 
                        "LABEL_EMAIL_WELCOME_ACCESS_1", "LABEL_EMAIL_WELCOME_ACCESS_2", "LABEL_EMAIL_WELCOME_THANKS", "LABEL_EMAIL_WELCOME_TERMS"
                    ];
        $this->replace = [$name, SITE_URL."user.php?cmd=".ps('newpswd')."&code=".ps($code), LABEL_EMAIL_WELCOME_WELCOME, 
                        LABEL_EMAIL_WELCOME_HELLO, LABEL_EMAIL_WELCOME_MESSAGE, LABEL_EMAIL_WELCOME_LINK, LABEL_EMAIL_WELCOME_ACCESS_1, 
                        LABEL_EMAIL_WELCOME_ACCESS_2, LABEL_EMAIL_WELCOME_THANKS, LABEL_EMAIL_WELCOME_TERMS
                    ];
    }

}
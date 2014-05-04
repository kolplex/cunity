<?php

namespace Core\Models\Mail;

class Mail extends \Zend_Mail {

    public function __construct() {
        parent::__construct();
        $config = \Core\Cunity::get("config");
        parent::setDefaultTransport(new \Zend_Mail_Transport_Smtp($config->mail->params->host, $config->mail->params->toArray()));
        parent::setDefaultFrom($config->mail->sendermail, $config->mail->sendername);
    }

    public function sendMail($body, $subject, array $receiver, array $cc = []) {
        $this->setBodyHtml($body);
        $this->addTo($receiver['email'], $receiver['name']);
        if (!empty($cc))
            $this->addCc($cc['email'], $cc['name']);
        $this->setSubject($subject);
        $this->send();
    }

}

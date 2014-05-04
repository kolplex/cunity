<?php

namespace Contact\View;

use Core\View\Mail\MailView;

class ContactMail extends MailView {

    protected $templateDir = "contact";
    protected $templateFile = "contact-mail.tpl";

    public function __construct(array $receiver = [], array $content = [], array $cc = []) {
        parent::__construct();
        if (empty($receiver)) {
            $settings = \Core\Cunity::get("settings");
            $receiver = ["email" => $settings->getSetting("contact_mail"), "name" => "Cunity Administrator"];
        }
        $this->_receiver = $receiver;
        $this->_cc = $cc;
        $this->_subject = $content['subject'];
        $this->assign('message', $content['message']);
        $this->show();
    }

}

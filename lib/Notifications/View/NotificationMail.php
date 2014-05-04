<?php

namespace Notifications\View;

use Core\View\Mail\MailView;

class NotificationMail extends MailView {

    protected $templateDir = "notifications";
    protected $templateFile = "notification-mail.tpl";

    public function __construct(array $receiver, array $data) {
        parent::__construct();
        $this->_receiver = $receiver;
        $this->_subject = $data['message'];
        $this->assign("message", $data['message']);
        $this->show();
    }

}

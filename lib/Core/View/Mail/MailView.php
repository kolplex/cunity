<?php

namespace Core\View\Mail;

use \Core\View\View;

class MailView extends View {

    protected $_receiver = [];
    protected $_cc = [];
    protected $_subject;
    protected $_body;

    public function __construct() {
        parent::__construct();
    }

    public function show() {
        $this->assign('tpl_name', $this->templateDir . DIRECTORY_SEPARATOR . $this->templateFile);
        $_body = $this->fetch('Core/out_mail.tpl');
        $mailer = new \Core\Models\Mail\Mail();
        $mailer->sendMail($_body, $this->translate($this->_subject), $this->_receiver, $this->_cc);
    }

}

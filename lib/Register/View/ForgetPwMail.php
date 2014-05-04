<?php

namespace Register\View;

use Core\View\Mail\MailView;

class ForgetPwMail extends MailView {

    protected $templateDir = "register";
    protected $templateFile = "forgetpw-mail.tpl";    
    
    protected $_subject = "Your new password";

    public function __construct($receiver,$password) {
        parent::__construct();
        $this->_receiver = $receiver;
        $this->assign("name",$receiver["name"]);
        $this->assign('password',$password);
        $this->show();
    }

}

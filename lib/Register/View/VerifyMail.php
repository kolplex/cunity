<?php

namespace Register\View;

use Core\View\Mail\MailView;

class VerifyMail extends MailView {

    protected $templateDir = "register";
    protected $templateFile = "register-mail.tpl";    
    
    protected $_subject = "Your Cunity-Registration";

    public function __construct($receiver,$registerSalt) {
        parent::__construct();
        $this->_receiver = $receiver;        
        $this->assign("name",$receiver["name"]);
        $this->assign('registerSalt',$registerSalt);
        $this->show();
    }

}

<?php
namespace Register\View;

use Core\View\View;

class ForgetPw extends View {
    
    protected $templateDir = "register";
    protected $templateFile = "forgetpw.tpl";
    protected $languageFolder = "Register/languages";
    protected $metadata = ["title"=>"Reset Password"];

    public function __construct() {
        parent::__construct();                     
    }
    
    public function render(){        
        $this->show();        
    }
}



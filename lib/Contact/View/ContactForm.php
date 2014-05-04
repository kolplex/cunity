<?php

namespace Contact\View;

use Core\View\View;
use Register\Models\Login;

class ContactForm extends View {

    protected $templateDir = "contact";
    protected $templateFile = "contactform.tpl";
    protected $metadata = ["title"=>"Contact Form"];

    public function __construct() {
        parent::__construct();
        if(Login::loggedIn()){
            $user = $_SESSION['user'];
            $userData = ["firstname"=>$user->firstname,"lastname"=>$user->lastname,"email"=>$user->email];
        }else
            $userData = ["firstname"=>"","lastname"=>"","email"=>""];
        $this->assign("userData",$userData);
        $this->show();
    }

    public function render() {
    }

}

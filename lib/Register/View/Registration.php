<?php

namespace Register\View;

use Core\View\View;

class Registration extends View {

    protected $templateDir = "register";
    protected $templateFile = "registration.tpl";
    protected $languageFolder = "Register/languages/";
    protected $metadata = ["title" => "Registration"];

    public function __construct() {
        parent::__construct();
        $this->registerScript("register", "registration");
        $this->registerCss("register", "style");
        $this->assign('success',false);
        $this->assign("values",["username"=>"","firstname"=>"","lastname"=>"","email"=>"","password"=>"","password_repeat"=>""]);
    }

    public function render() {
        $this->show();
    }

}



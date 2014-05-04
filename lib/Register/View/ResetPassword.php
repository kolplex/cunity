<?php

namespace Register\View;

use Core\View\View;

class ResetPassword extends View {

    protected $templateDir = "register";
    protected $templateFile = "resetpw.tpl";
    protected $metadata = ["title" => "Reset Password"];

    public function __construct() {
        parent::__construct();
        $this->registerCss("register", "resetpw");
    }

}

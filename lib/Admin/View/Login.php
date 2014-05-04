<?php

namespace Admin\View;

use Core\View\View;

class Login extends View {

    protected $templateDir = "Admin";
    protected $templateFile = "login.tpl";
    protected $useWrapper = false;

    public function __construct() {
        parent::__construct();
    }

}

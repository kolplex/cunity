<?php

namespace Admin\View;

use Core\View\View;

class Modules extends View {

    protected $templateDir = "Admin/modules";
    protected $templateFile = "";
    protected $useWrapper = false;

    public function __construct() {
        parent::__construct();
        $this->templateFile = $_GET['x'] . ".tpl";
        $this->registerCss("Admin/modules",$_GET['x']);
    }

}

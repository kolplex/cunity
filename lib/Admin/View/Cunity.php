<?php

namespace Admin\View;

use Core\View\View;

class Cunity extends View {

    protected $templateDir = "Admin/cunity";
    protected $templateFile = "";
    protected $useWrapper = false;

    public function __construct() {
        parent::__construct();
        $this->templateFile = $_GET['x'] . ".tpl";
        $this->registerCss("Admin/cunity",$_GET['x']);
        $this->show();
    }

}

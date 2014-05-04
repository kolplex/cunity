<?php

namespace Admin\View;

use Core\View\View;

class Appearance extends View {

    protected $templateDir = "Admin/appearance";
    protected $templateFile = "";
    protected $useWrapper = false;

    public function __construct() {
        parent::__construct();
        $this->templateFile = $_GET['x'] . ".tpl";
        $this->registerCss($this->templateDir,$_GET['x']);
    }

}

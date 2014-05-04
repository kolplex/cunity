<?php

namespace Admin\View;

use Core\View\View;

class Statistics extends View {

    protected $templateDir = "admin/statistics";
    protected $templateFile = "";
    protected $useWrapper = false;

    public function __construct() {
        parent::__construct();
        $this->templateFile = $_GET['x'] . ".tpl";
        $this->registerCss("Admin/statistics", $_GET['x']);
        $this->show();
    }

}

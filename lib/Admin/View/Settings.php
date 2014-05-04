<?php
namespace Admin\View;

use Core\View\View;

class Settings extends View {
    
    protected $templateDir = "admin/settings";
    protected $templateFile = "";
    protected $useWrapper = false;

    public function __construct() {
        parent::__construct();
        $this->templateFile = $_GET['x'] . ".tpl";
        $this->registerCss("Admin/settings",$_GET['x']);
    }
}



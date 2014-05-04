<?php
namespace Admin\View;

use Core\View\View;

class Mailing extends View {
    
    protected $templateDir = "Admin/mailing";
    protected $templateFile = "";
    protected $useWrapper = false;

    public function __construct() {
        parent::__construct();
        $this->templateFile = $_GET['x'] . ".tpl";
        $this->registerCss("Admin/mailing",$_GET['x']);
        $this->show();
    }    
}



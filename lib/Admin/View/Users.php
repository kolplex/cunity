<?php
namespace Admin\View;

use Core\View\View;

class Users extends View {
    
    protected $templateDir = "admin/users";
    protected $templateFile = "";
    protected $useWrapper = false;

    public function __construct() {
        parent::__construct();
        $this->templateFile = $_GET['x'] . ".tpl";
        $this->registerCss("Admin/users",$_GET['x']);
    }   
}



<?php
namespace Admin\View;

use Core\View\View;

class Dashboard extends View {
    
    protected $templateDir = "Admin/dashboard";
    protected $templateFile = "dashboard.tpl";
    protected $useWrapper = false;

    public function __construct() {
        parent::__construct();
        \Admin\Models\Login::loginRequired();
        $this->registerCss("admin/dashboard","dashboard");       
    }
    
}
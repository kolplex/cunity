<?php

namespace Core\View;

class PageNotFound extends \Core\View\View {

    protected $templateDir = "Core";
    protected $templateFile = "404.tpl";    
    protected $metadata = ["title" => "404 - Page Not Found"];

    public function __construct() {
        parent::__construct();        
        $this->registerCss("", "pagenotfound");
        $this->show();
        exit();
    }
}

<?php
namespace Forums\View;

use Core\View\View;

class Forum extends View{
    
    protected $templateDir = "forums";
    protected $templateFile = "forum.tpl";    
    protected $metadata = ["title"=>"Forum"];
    
    public function __construct() {
        parent::__construct();
        $this->registerCss("forums","forum");        
        $this->registerScript("forums", "forum");        
        $this->registerScript("forums", "category-cloud");
    }
}
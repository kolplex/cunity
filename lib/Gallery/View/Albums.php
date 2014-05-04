<?php
namespace Gallery\View;

use Core\View\View;

class Albums extends View{
    
    protected $templateDir = "gallery";
    protected $templateFile = "albums.tpl";    
    protected $metadata = ["title"=>"Albums"];
    
    public function __construct() {
        parent::__construct();
        $this->registerCss("gallery","albums");
        $this->registerScript("gallery", "albums");        
        $this->show();
    }
}
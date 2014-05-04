<?php
namespace Pages\View;

use Core\View\View;

class Page extends View {
    
    protected $templateDir = "pages";
    protected $templateFile = "page.tpl";    
    protected $metadata = ["title"=>"Content page"];

    public function __construct() {
        parent::__construct();            
        $this->registerCss("pages","page");
    }
    
    public function setMetaData(array $data){
        $this->metadata = $data;
    }
}



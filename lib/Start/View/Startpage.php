<?php
namespace Start\View;

use Core\View\View;

class Startpage extends View {
    
    protected $templateDir = "start";
    protected $templateFile = "startpage.tpl";
    protected $languageFolder = "start/languages";
    protected $metadata = ["title"=>"Welcome"];
    protected $useWrapper = false;

    public function __construct() {
        parent::__construct();            
        $this->assign('success',false);
        $this->registerScript("register","registration");
        $this->registerCss("register", "style");
        $this->assign("values",["username"=>"","firstname"=>"","lastname"=>"","email"=>"","password"=>"","password_repeat"=>""]);
        $this->render();
    }
    
    public function render(){        
        $this->show();        
    }
}

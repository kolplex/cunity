<?php
namespace Core\View\Exception;

class View extends \Core\View\View{
    
    protected $templateDir = "core";
    protected $templateFile = "exception.tpl";
    protected $languageFolder = "core/languages/";
    protected $metadata = ["title" => "Error", "description" => "Cunity - Your private social network"];

    public function __construct($e){
        parent::__construct();
        $this->assign('MESSAGE',$e->getMessage());        
        $this->show();
    }
}



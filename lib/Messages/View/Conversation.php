<?php

namespace Messages\View;

class Conversation extends \Core\View\View {

    protected $templateDir = "messages";
    protected $templateFile = "conversation.tpl";    
    protected $metadata = ["title" => "Conversation"];

    public function __construct() {
        parent::__construct();
        $this->registerScript("messages","conversation");
        $this->registerCss("messages", "conversation");        
        $this->registerScript("","jquery.jscrollpane");
        $this->registerScript("","jquery.mousewheel");
        $this->registerCss("", "jquery.jscrollpane"); 
    }

    public function render() {
        $this->show();
    }

}

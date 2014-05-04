<?php

namespace Messages\View;

class Inbox extends \Core\View\View {

    protected $templateDir = "messages";
    protected $templateFile = "inbox.tpl";    
    protected $metadata = ["title" => "My Conversations"];

    public function __construct() {
        parent::__construct();
        $this->registerScript("messages","inbox");
        $this->registerCss("messages", "inbox");
        $this->render();
    }

    public function render() {
        $this->show();
    }

}

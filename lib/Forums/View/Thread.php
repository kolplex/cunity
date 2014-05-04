<?php

namespace Forums\View;

use Core\View\View;

class Thread extends View {

    protected $templateDir = "forums";
    protected $templateFile = "thread.tpl";
    protected $metadata = ["title" => "Topic"];

    public function __construct() {
        parent::__construct();
        $this->registerCss("forums", "thread");
        $this->registerScript("forums", "thread");
        $this->registerCss("", "summernote");
        $this->registerScript("", "summernote");
        $this->registerScript("forums", "category-cloud");
    }

}

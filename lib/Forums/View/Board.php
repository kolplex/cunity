<?php

namespace Forums\View;

use Core\View\View;

class Board extends View {

    protected $templateDir = "forums";
    protected $templateFile = "board.tpl";
    protected $metadata = ["title" => "Board"];

    public function __construct() {
        parent::__construct();
        $this->registerCss("forums", "board");
        $this->registerScript("forums", "board");
        $this->registerCss("", "summernote");
        $this->registerScript("", "summernote");
        $this->registerScript("forums", "category-cloud");
    }

}

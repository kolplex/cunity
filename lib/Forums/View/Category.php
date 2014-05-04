<?php

namespace Forums\View;

use Core\View\View;

class Category extends View {

    protected $templateDir = "forums";
    protected $templateFile = "category.tpl";
    protected $metadata = ["title" => "Category"];

    public function __construct() {
        parent::__construct();
        $this->registerCss("forums", "board");
        $this->registerScript("forums", "category");
        $this->registerScript("forums", "category-cloud");
    }

}

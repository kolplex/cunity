<?php

namespace Forums\View;

use Core\View\View;

class Forums extends View {

    protected $templateDir = "forums";
    protected $templateFile = "forums.tpl";
    protected $metadata = ["title" => "Forums"];

    public function __construct() {
        parent::__construct();
        $this->registerCss("forums", "forums");
        $this->registerScript("forums", "forums");
        $this->registerScript("forums", "category-cloud");
        $this->show();
    }

}
 
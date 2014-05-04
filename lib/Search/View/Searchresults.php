<?php

namespace Search\View;

use Core\View\View;

class Searchresults extends View {

    protected $templateDir = "search";
    protected $templateFile = "searchresults.tpl";
    protected $metadata = ["title" => "Searchresults"];

    public function __construct() {
        parent::__construct();
        $this->registerScript("search","searchresults");
        $this->assign("queryString", $_GET['q']);
        $this->show();
    }

    public function setMetaData(array $data) {
        $this->metadata = $data;
    }

}

<?php

namespace Memberlist\View;

class Memberlist extends \Core\View\View {

    protected $templateDir = "memberlist";
    protected $templateFile = "memberlist.tpl";
    protected $languageFolder = "Memberlist/languages";
    protected $metadata = ["title" => "Memberlist"];

    public function __construct() {
        parent::__construct();
        $this->registerScript("memberlist", "memberlist");
        $this->show();
    }

}

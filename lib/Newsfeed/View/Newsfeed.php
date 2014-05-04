<?php

namespace Newsfeed\View;

class Newsfeed extends \Core\View\View {

    protected $templateDir = "newsfeed";
    protected $templateFile = "newsfeed.tpl";
    protected $languageFolder = "Newsfeed/languages";
    protected $metadata = ["title" => "Newsfeed"];

    public function __construct() {
        parent::__construct();
        $this->registerScript("newsfeed", "newsfeed");
        $this->registerCss("newsfeed", "newsfeed");
        $this->registerCss("gallery","lightbox");                
        $this->registerScript("gallery", "jquery.blueimp-gallery");        
        $this->registerScript("gallery", "lightbox");
        $this->registerScript("", "jquery.jscrollpane");
        $this->registerScript("", "jquery.mousewheel");
        $this->show();
    }

}

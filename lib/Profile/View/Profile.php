<?php

namespace Profile\View;

class Profile extends \Core\View\View {

    protected $templateDir = "profile";
    protected $templateFile = "profile.tpl";
    protected $metadata = ["title" => "Profile"];

    public function __construct() {
        parent::__construct();
        $this->registerScript("profile", "profile");
        $this->registerScript("gallery", "albums");
        $this->registerScript("newsfeed", "newsfeed");
        $this->registerCss("profile", "profile");
        $this->registerCss("newsfeed", "newsfeed");
        $this->registerCss("gallery", "albums");
        $this->registerCss("friends", "friends");
        $this->registerCss("gallery", "lightbox");
        $this->registerScript("gallery", "jquery.blueimp-gallery");
        $this->registerScript("gallery", "lightbox");
        $this->registerScript("", "jquery.jscrollpane");
        $this->registerScript("", "jquery.mousewheel");
    }

    public function render() {
        $this->show();
    }

}

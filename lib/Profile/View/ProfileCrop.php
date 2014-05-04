<?php

namespace Profile\View;

class ProfileCrop extends \Core\View\View {
    
    protected $templateDir = "profile";
    protected $templateFile = "profile-crop.tpl";
    protected $metadata = ["title"=>"Crop Image"];

    public function __construct() {        
        parent::__construct();     
        $this->registerScript("profile", "jquery.imgareaselect.pack");        
        $this->registerScript("profile", "profile-crop");        
        $this->registerCss("profile", "profile");
        $this->registerCss("profile", "imgareaselect-animated");
        $this->registerCss("profile", "profile-crop");
    }
}


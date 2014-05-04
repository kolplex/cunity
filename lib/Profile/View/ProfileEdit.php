<?php

namespace Profile\View;

class ProfileEdit extends \Core\View\View {

    protected $templateDir = "profile";
    protected $templateFile = "profile-edit.tpl";
    protected $metadata = ["title" => "Edit Profile"];

    public function __construct() {
        parent::__construct();
        $this->registerScript("profile", "profile-edit");
        $this->registerScript("profile", "profile");
        $this->registerCss("profile", "profile");
        $this->registerCss("profile", "profile-edit");
        $this->registerScript("", "jquery-ui-1.10.4.custom");
        $this->registerCss("", "summernote");
        $this->registerScript("", "summernote");
        $this->assign("max_filesize",ini_get('upload_max_filesize'));
    }

    public function render() {
        $this->show();
    }

}

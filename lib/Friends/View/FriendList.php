<?php

namespace Friends\View;

use \Core\View\View;

class FriendList extends View {

    protected $templateDir = "friends";
    protected $templateFile = "friendslist.tpl";
    protected $languageFolder = "Friends/languages";
    protected $metadata = ["title" => "My friends"];

    public function __construct() {
        parent::__construct();
        $this->registerScript("friends","friendslist");
        $this->registerCss("friends", "friends");
        $this->show();
    }
}



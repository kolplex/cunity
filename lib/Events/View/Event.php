<?php

namespace Events\View;

use Core\View\View;

class Event extends View {

    protected $templateDir = "events";
    protected $templateFile = "event.tpl";
    protected $metadata = ["title" => "Event"];

    public function __construct() {
        parent::__construct();
        $this->registerCss("events", "event");
        $this->registerCss("newsfeed", "newsfeed");
        $this->registerScript("newsfeed", "newsfeed");
        $this->registerScript("events", "event");
        $this->registerCss("forums", "forum");
        $this->registerScript("forums", "forum");
        $this->registerScript("forums", "category-cloud");
    }

}

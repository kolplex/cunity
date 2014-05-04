<?php

namespace Events\View;

use Core\View\View;

class Events extends View {

    protected $templateDir = "events";
    protected $templateFile = "events.tpl";
    protected $metadata = ["title" => "Events"];

    public function __construct() {
        parent::__construct();
        $this->registerCss("events", "events");
        $this->registerScript("events", "events");
        $this->registerScript("", "bootstrap-datepicker");
        $this->registerCss("", "datepicker3");
        $this->registerScript("", "bootstrap-timepicker");
        $this->registerCss("", "bootstrap-timepicker");
        $this->registerScript("", "calendar");
        $this->registerScript("", "underscore-min");
        $this->registerCss("", "calendar");
        $this->show();
    }

}

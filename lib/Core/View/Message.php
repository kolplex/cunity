<?php

namespace Core\View;

class Message extends View {

    protected $templateDir = "core";
    protected $templateFile = "message.tpl";
    private $validTypes = ["info", "danger", "success"];

    public function __construct($header, $message, $type = "info") {
        parent::__construct();
        $titleTranslated = $this->translate($header);
        $this->metadata = ["title" => $titleTranslated];
        $this->assign("MESSAGE", $this->translate($message));
        $this->assign("HEADER", $titleTranslated);
        $this->assign("TYPE", (in_array($type, $this->validTypes) ? $type : "info"));
        $this->show();
    }

}

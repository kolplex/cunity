<?php

namespace Admin\Models\Pages;

class Settings extends PageAbstract {

    public function __construct() {
        $this->loadData();
        $this->render("settings");
    }

    private function loadData() {
        $langIterator = new \DirectoryIterator("Core/lang");
        foreach ($langIterator AS $lang)
            if ($lang->isReadable() && $lang->getExtension() == "php")
                $this->assignments['availableLanguages'][] = explode("-", $lang->getBasename(".php"));
        $this->assignments["config"] = \Zend_Registry::get("cunity")->config;
    }

}

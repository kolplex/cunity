<?php

namespace Admin\Models\Pages;

class Statistics extends PageAbstract {

    public function __construct() {
        $this->loadData();
        $this->render("statistics");
    }

    private function loadData() {
        $modules = new \Core\Models\Db\Table\Modules();
        $installedModules = $modules->getModules()->toArray();
        $config = \Core\Cunity::get("config");
        $this->assignments['smtp_check'] = $config->mail->smtp_check;
        $this->assignments['modules'] = $installedModules;
    }

}
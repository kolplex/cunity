<?php

namespace Admin\Models\Pages;

class Dashboard extends PageAbstract {

    public function __construct() {
        $this->loadData();
        $this->render("dashboard");
    }

    private function loadData() {
        $modules = new \Core\Models\Db\Table\Modules();
        $installedModules = $modules->getModules()->toArray();
        $config = \Zend_Registry::get("cunity")->config;
        $this->assignments['smtp_check'] = $config->mail->smtp_check;
        $this->assignments['modules'] = $installedModules;
    }

}

<?php

namespace Admin\Models\Pages;

class Modules extends PageAbstract {

    public function __construct() {
        $this->loadData();
        $this->render("modules");
    }

    private function loadData() {       
        $modules = new \Core\Models\Db\Table\Modules();
        $installedModules = $modules->getModules()->toArray();
        $this->assignments['installedModules'] = $installedModules;
    }

}

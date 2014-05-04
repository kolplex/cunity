<?php

namespace Memberlist;

use Core\ModuleController;

class Controller implements ModuleController {

    public function __construct() {
        \Register\Models\Login::loginRequired();
        $this->handleRequest();
    }

    private function handleRequest() {
        if (isset($_GET['action']) && $_GET['action'] == "load") {
            $p = new Models\Process();
            $p->getAll();
        } else
            new View\Memberlist();
    }

    public static function onRegister($user) {
        
    }

    public static function onUnregister($user) {
        
    }

}

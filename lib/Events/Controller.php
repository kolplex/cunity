<?php

namespace Events;

use Core\ModuleController;
use \Register\Models\Login;

class Controller implements ModuleController {

    private $allowedActions = ["createEvent", "loadEvents"];

    public function __construct() {
        Login::loginRequired();
        $this->handleRequest();
    }

    private function handleRequest() {
        if (!isset($_GET['action']) || empty($_GET['action']))
            new View\Events();
        else if (isset($_GET['action']) && !empty($_GET['action']) && in_array($_GET['action'], $this->allowedActions))
            new Models\Process($_GET['action']);
        else
            new Models\Process("loadEvent");
    }

    public static function onRegister($user) {
        
    }

    public static function onUnregister($user) {
        
    }

}

<?php

namespace Notifications;

use Core\ModuleController;

class Controller implements ModuleController {

    public function __construct() {
        $this->handleRequest();
    }

    private function handleRequest() {
        if (isset($_GET['action']) && $_GET['action'] == "get") {
            $process = new Models\Process();
            $process->get($_POST['type']);
        } else if (isset($_GET['action']) && $_GET['action'] == "markRead") {
            $view = new \Core\View\Ajax\View();
            $n = new \Notifications\Models\Db\Table\Notifications();
            $view->setStatus($n->read($_POST['id']));
            $view->sendResponse();
        }
    }

    public static function onRegister($user) {
        
    }

    public static function onUnregister($user) {
        
    }

}

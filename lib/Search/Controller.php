<?php

namespace Search;

use Core\ModuleController;

class Controller implements ModuleController {

    public function __construct() {
        $this->handleRequest();
    }

    private function handleRequest() {
        if (isset($_GET['q']) && !empty($_GET['q']) && empty($_GET['action'])) {
//            $process = new Models\Process();
//            $result = $process->find($_GET['q']);
            new View\Searchresults();            
        } else if (isset($_GET['action']) && $_GET['action'] == "livesearch") {
            $process = new Models\Process();
            $result = $process->find($_POST['q']);
            $view = new \Core\View\Ajax\View();
            $view->setStatus(true);
            $view->addData($result);
            $view->sendResponse();
        }
    }

    public static function onRegister($user) {
        $searchindex = new Models\Process();
        $searchindex->addUser($user->username, $user->name);
    }

    public static function onUnregister($user) {
        $searchindex = new Models\Process();
        $searchindex->removeUser($user->username);
    }

}

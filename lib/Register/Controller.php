<?php

namespace Register;

use Core\ModuleController;

class Controller implements ModuleController {

    public function __construct() {
        $this->handleRequest();
    }

    private function handleRequest() {
        if (!isset($_GET['action'])) {
            $view = new View\Registration();
            $view->render();
        } else {
            switch ($_GET['action']) {
                case "sendRegistration":
                    new Models\Register("sendRegistration");
                    break;
                case 'forgetPw':
                    new Models\Register("forgetPw");
                    break;
                case "login":
                    new Models\Login("login");
                    break;
                case "logout":
                    new Models\Login("logout");
                    break;
                case "verify":
                    new Models\Register("verify");
                    break;
                case "delete":
                    new Models\Register("delete");
                    break;
                case "reset":
                    new Models\Register("reset");
                    break;
                default:
                    $view = new View\Registration();
                    $view->assign('success', false);
                    $view->render();
                    break;
            }
        }
    }

    public static function onRegister($user) {
        
    }

    public static function onUnregister($user) {
        
    }

}

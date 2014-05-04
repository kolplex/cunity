<?php

namespace Admin;

use Core\ModuleController;

class Controller implements ModuleController {

    public function __construct() {
        \Register\Models\Login::loginRequired();
        if (isset($_GET['action']) && $_GET['action'] == "login") {
            new Models\Login("login");
        } else if (isset($_GET['action']) && $_GET['action'] == "save") {
            new Models\Process($_POST['form']);
        } else if (isset($_GET['action']) && !empty($_GET['action'])) {
            $model = "\Admin\Models\\Pages\\" . ucfirst($_GET['action']);
            if (!Models\Login::loggedIn())
                new View\Login();
            else if (\Core\Models\Request::isAjaxRequest())
                new $model;
        } else
            new View\Admin();
    }

    public static function onRegister($user) {
        
    }

    public static function onUnregister($user) {
        
    }

}

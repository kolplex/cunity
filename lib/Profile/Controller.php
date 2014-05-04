<?php

namespace Profile;

use Core\ModuleController;

class Controller implements ModuleController {

    public function __construct() {
        \Register\Models\Login::loginRequired();
        $this->handleRequest();
    }

    private function handleRequest() {
        if (isset($_GET['action']) && ($_GET['action'] == "edit" || $_GET['action'] == "cropImage"))
            new Models\ProfileEdit();
        else
            new Models\Profile();
    }

    public static function onRegister($user) {
        
    }

    public static function onUnregister($user) {
        
    }

}

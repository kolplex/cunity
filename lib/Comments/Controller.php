<?php

namespace Comments;

use Core\ModuleController;
use Register\Models\Login;

class Controller implements ModuleController {

    public function __construct() {
        Login::loginRequired();
        new Models\Process($_GET['action']);
    }

    public static function onRegister($user) {
        
    }

    public static function onUnregister($user) {
        
    }

}
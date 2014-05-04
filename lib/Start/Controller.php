<?php

namespace Start;

use Core\ModuleController;
use Register\Models\Login;

class Controller implements ModuleController {

    public function __construct() {
        Login::checkAutoLogin(true);
        new View\Startpage();
    }

    public static function onRegister($user) {
        
    }

    public static function onUnregister($user) {
        
    }

}

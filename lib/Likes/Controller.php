<?php

namespace Likes;

use Core\ModuleController;
use Register\Models\Login;

class Controller implements ModuleController {

    public function __construct() {
        Login::loginRequired();
        new Models\Likes($_GET['action']);
    }
    
    public static function onRegister($user) {
        
    }

    public static function onUnregister($user) {
        
    }

}

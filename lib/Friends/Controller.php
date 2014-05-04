<?php

namespace Friends;

use Core\ModuleController;

class Controller implements ModuleController {
    
    private $allowedActions = ["add","block","confirm","remove","change","loadData","load","loadOnline","chatStatus"];

    public function __construct() {
        \Register\Models\Login::loginRequired();
        $this->handleRequest();
    }

    private function handleRequest() {
        if (!isset($_GET['action']) || empty($_GET['action']))
            new View\FriendList();
        else if (isset($_GET['action']) && !empty($_GET['action']) && in_array($_GET['action'],$this->allowedActions))
            new Models\Process($_GET['action']);
    }

    public static function onRegister($user) {
        
    }

    public static function onUnregister($user) {
        
    }

}

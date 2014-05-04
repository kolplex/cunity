<?php

namespace Newsfeed;

use Core\ModuleController;

class Controller implements ModuleController {

    private $allowedActions = ["send", "load", "delete", "loadPost"];

    public function __construct() {
        \Register\Models\Login::loginRequired();
        $this->handleRequest();
    }

    private function handleRequest() {
        if (!isset($_GET['action']) || empty($_GET['action']))
            new View\Newsfeed();
        else if (isset($_GET['action']) && !empty($_GET['action']) && in_array($_GET['action'], $this->allowedActions))
            new Models\Process($_GET['action']);
    }

    public static function onRegister($user) {
        $walls = new Models\Db\Table\Walls();
        $walls->createUserWall($user->userid);
    }

    public static function onUnregister($user) {
        $walls = new Models\Db\Table\Walls();
        $walls->deleteWallByOwner($user->userid,"profile");
    }

}

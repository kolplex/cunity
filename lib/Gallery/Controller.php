<?php

namespace Gallery;

use Core\ModuleController;
use \Register\Models\Login;

class Controller implements ModuleController {

    private $allowedActions = ["loadImages", "overview", "loadImage", "edit", "deleteImage", "create", "upload", "deleteAlbum"];

    public function __construct() {
        Login::loginRequired();
        $this->handleRequest();
    }

    private function handleRequest() {
        if (!isset($_GET['action']) || empty($_GET['action']))
            new View\Albums();
        else if (isset($_GET['action']) && !empty($_GET['action']) && in_array($_GET['action'], $this->allowedActions))
            new Models\Process($_GET['action']);
        else if (isset($_GET['action']) && !empty($_GET['action']))
            new Models\Process("loadAlbum");
    }

    public static function onRegister($user) {
        $albums = new Models\Db\Table\Gallery_Albums();
        $albums->newProfileAlbums($user->userid);
    }

    public static function onUnregister($user) {
        $albums = new Models\Db\Table\Gallery_Albums();
        $albums->deleteAlbumsByUser($user->userid);
    }

}

<?php

namespace Forums;

use Core\ModuleController;
use \Register\Models\Login;

class Controller implements ModuleController {

    private $allowedActions = ["forum", "board", "thread", "category", "loadForums", "loadBoards", "loadThreads", "loadPosts", "loadCategories", "createForum", "createBoard", "startThread", "postReply", "editForum", "editBoard", "editThread", "deletePost", "deleteForum", "deleteBoard", "deleteThread"];

    public function __construct() {
        Login::loginRequired();
        $this->handleRequest();
    }

    private function handleRequest() {
        if (!isset($_GET['action']) || empty($_GET['action']))
            new View\Forums();
        else if (isset($_GET['action']) && !empty($_GET['action']) && in_array($_GET['action'], $this->allowedActions))
            new Models\Process($_GET['action']);
        else
            new Models\Process("loadTopic");
    }

    public static function onRegister($user) {
        
    }

    public static function onUnregister($user) {
        
    }

}

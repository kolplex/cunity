<?php

namespace Messages;

use Core\ModuleController;

class Controller implements ModuleController {
    
    private $allowedActions = ["send","load","loadConversationMessages","deletemessage","startConversation","leaveConversation","loadUnread","invite","chatHeartbeat"];

    public function __construct() {
        \Register\Models\Login::loginRequired();
        $this->handleRequest();
    }

    private function handleRequest() {
        if (!isset($_GET['action']) || empty($_GET['action']))
            new View\Inbox();
        else if (isset($_GET['action']) && !empty($_GET['action']) && in_array($_GET['action'],$this->allowedActions))
            new Models\Process($_GET['action']);
        else if(isset($_GET['action']) && !empty($_GET['action']))
            new Models\Conversation();
    }

    public static function onRegister($user) {
        
    }

    public static function onUnregister($user) {
        
    }

}

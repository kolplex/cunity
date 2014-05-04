<?php

namespace Messages\Models;

class Conversation {

    public function __construct() {
        $this->load();
    }

    private function load() {
        $table = new Db\Table\Conversations();
        $userTable = new \Core\Models\Db\Table\Users();
        $view = new \Messages\View\Conversation();
        $conversation = $table->loadConversationDetails($_GET['action']);
        $users = explode(",", $conversation['users']);
        if (!in_array($_SESSION['user']->userid, $users))
            $view = new \Core\View\PageNotFound();
        else
            unset($users[array_search($_SESSION['user']->userid, $users)]);
        $table->markAsRead($_GET['action']);
        $conversation['users'] = $userTable->getSet($users, "u.userid", ["u.userid", "u.username", "u.name"])->toArray();
        $usernames = "";
        foreach ($conversation['users'] AS $user)
            $usernames .= $user['name'] . ',';
        $view->setMetaData(["title" => substr($usernames, 0, -1)]);
        $view->assign("conversation", $conversation);
        $view->show();
    }

}
